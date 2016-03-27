<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model;
class RegisterController extends Controller {

	//跳转到注册页
	public function registerPage() {
		$this->display( 'User:register' );
	}

	//创建验证码
	public function createVerify() {
		$Verify = new \Think\Verify();
		$Verify->fontSize = 18;
		$Verify->length   = 4;
		$Verify->useNoise = false;
		$Verify->imageW = 120;
		$Verify->imageH = 40;
		$Verify->expire = 600;
		$Verify->entry();
	}

	//注册
	public function register() {

		$email= I( 'email' );

		$User = D( "User" );

		if ( !$User->create() ) {
			$this->assign( "error", $User->getError() );
			$this->assign( "typed", $_POST );
			$this->display( 'User:register' );
			return;
		}else {
			$verify = new \Think\Verify();
			if ( !$verify->check( $_POST['verify'], "" ) ) {
				$this->assign( "typed", $_POST );
				$this->assign( "verifyError", "try again" );
				$this->display( 'User:register' );
				return;
			}
			$User->password = substr( md5( $User->password ), 0, 16 ) . substr( sha1( $User->password ), 16, 24 );
			$User->icon = 'default.jpg';
			$User->score = 10;
			$User->registerTime = date( 'Y-m-d H:i:s', time() );
			$User->lastLoginTime = date( 'Y-m-d H:i:s', time() );
			$User->add();

			$user = $User->where( "email='$email'" )->find();

			session( 'userId', $user['userId'] );
			session( 'userName', $user['userName'] );
			session( 'icon',  $user['icon'] );
			session( 'email',  $user['email'] );
			session( 'signature', $user['signature'] );
			session( 'score', $user['score'] );
			session( 'registerTime', format_date( $user['registerTime'] ) );
			session( 'lastLoginTime', format_date( $user['lastLoginTime'] ) );

			$this->success( '...', U('Index/index') );
		}
	}

	protected function _initialize() {
		$this->where = 'register';
		$this->title = 'Register';

		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
