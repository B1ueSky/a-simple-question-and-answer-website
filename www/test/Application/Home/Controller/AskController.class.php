<?php
namespace Home\Controller;
use Think\Controller;
class AskController extends Controller {
	public function index() {
		$this->display( 'Ask:ask' );
	}

	//提问
	public function askQuestion() {
		$title = $_POST['title'];
		$content = $_POST['content'];
		$score = $_POST['score'];
		$label = $_POST['label'];

		if ( empty( $score ) ) {
			$score = 0;
		}

		if ( trim( $title )=="" ) {
			$this->ajaxReturn( "标题不能为空" );
			return;
		}

		if ( trim( $content )=="" ) {
			$this->ajaxReturn( "内容不能为空" );
			return;
		}

		if ( !is_numeric( $score ) ) {
			$this->ajaxReturn( "悬赏分必须是数字" );
			return;
		}

		$User = D( 'user' );
		$userId = session( 'userId' );
		$user = $User->find( $userId );
		$haveScore = $user['score'];

		if ( intval( $score, 10 ) >intval( $haveScore, 10 ) ) {
			$this->ajaxReturn( "悬赏分不能大于可用积分(当前可用：$haveScore)" );
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
		$data['label'] = $label;
		$data['view'] = 0;
		$data['time'] = date( 'Y-m-d H:i:s', time() );
		$Question->add( $data );

		$this->ajaxReturn( "success" );
	}

	protected function _initialize() {
		$this->where = 'Ask';
		$this->title = '提问';

		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
