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
		$canview = $_POST['canview'];

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

		# check canview emails
        # split the string by space.
		$emails = preg_split('/[\s]+/', $canview, -1, PREG_SPLIT_NO_EMPTY);
		$userId_list = array();

        foreach ($emails as $email) {

			$condition['email'] = $email;
			$user = $User->where($condition)->select();

            if (count($user) <= 0) {
				$this->ajaxReturn( "Email ".$email." does not exist." );
				return;
			} else {
                foreach ($user as $u)
                {
                    $userId_list[] += $u['userId'];
                }
            }
        }

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
        if (empty($userId_list)) {
            $data['isPublic'] = True;
        } else {
            $data['isPublic'] = False;
        }
		$questionId = $Question->add( $data );

		# add tagin areas
		$Tagin = D('Tagin');
		$data = array();
		foreach ($areas as $area) {
			$data['areaId'] = $area;
			$data['questionId'] = $questionId;
			$Tagin->add($data);
		}

        # add canview relations if private
        if (!empty($userId_list))
        {
            $userId_list[] += session( 'userId' ); # add user themselves
            $Canview = D('Canview');
            $data = array();
            foreach ($userId_list as $userId)
            {
                $data['userId']     = $userId;
                $data['questionId'] = $questionId;
                $Canview->add($data);
            }
        }

		$this->ajaxReturn( "success" );
	}

	protected function _initialize() {
		$this->where = 'Ask';
		$this->title = 'Ask Question';

		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
