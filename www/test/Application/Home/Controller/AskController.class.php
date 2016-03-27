<?php
namespace Home\Controller;
use Think\Controller;
class AskController extends Controller {
	public function index() {
		$Area = D('Area');
		$areas = $Area->select();
		$this->assign('areas', $areas);
		$this->display( 'Ask:ask' );
	}

	//提问
	public function askQuestion() {
		$title = $_POST['title'];
		$content = $_POST['content'];
		$score = $_POST['score'];
		//$label = $_POST['label'];
		$areas = $_POST['areaList'];

		if ( empty( $score ) ) {
			$score = 0;
		}

		if ( trim( $title )=="" ) {
			$this->ajaxReturn( "You need a title" );
			return;
		}

		if ( trim( $content )=="" ) {
			$this->ajaxReturn( "Please write something" );
			return;
		}

		if ( !is_numeric( $score ) ) {
			$this->ajaxReturn( "It has to be a number" );
			return;
		}

		if ( is_null($areas) || count($areas) <= 0 ) {
			$this->ajaxReturn( "Please select at least one areas." );
			return;
		}


		$User = D( 'user' );
		$userId = session( 'userId' );
		$user = $User->find( $userId );
		$haveScore = $user['score'];

		if ( intval( $score, 10 ) >intval( $haveScore, 10 ) ) {
			$this->ajaxReturn( "you currently have：$haveScore" );
			return;
		}

		$Auth = A( "Auth" );
		$result = $Auth->check( $userId );
		if ( !( $result['success'] ) ) {
			$this->ajaxReturn( $result['info'] );
			return;
		}

		$User->execute( "update t_user set score=score-$score where userId=$userId" );

		$Question = D( "Question" );

		$data['userId'] = $userId;
		$data['title'] = $title;
		$data['content'] = $content;
		$data['score']  = $score;
		//$data['label'] = $label;
		$data['view'] = 0;
		$data['time'] = date( 'Y-m-d H:i:s', time() );
		$questionId = $Question->add( $data );

		# add tagin areas

		$Tagin = D('Tagin');
		$data = array();
		foreach ($areas as $area) {
			$data['areaId'] = $area;
			$data['questionId'] = $questionId;
			$Tagin->add($data);
		}

		$this->ajaxReturn( "success" );
	}

	protected function _initialize() {
		$this->where = 'Ask';
		$this->title = '提问';

		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
