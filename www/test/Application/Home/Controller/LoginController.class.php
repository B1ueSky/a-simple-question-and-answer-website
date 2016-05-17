<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	//跳转到登录界面
	public function loginPage() {
		$this->display( 'User:login' );
	}

	//登录
	public function login() {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password = substr( md5( $password ), 0, 16 ) . substr( sha1( $password ), 16, 24 );
		$User = D( "User" );
		$user  = $User->where( "email='$email'" )->find();

		if ( !( $user['userId'] ) ) {
			$this->assign( "typed", $_POST );
			$error['email'] = "Invalid user or incorrect password";
			$this->assign( "error", $error );
			$this->display( "User:login" );
			return;
		}
		if ( $user['password'] !== $password ) {
			$this->assign( "typed", $_POST );
			$error['password'] = "Invalid user or incorrect password";
			$this->assign( "error", $error );
			$this->display( "User:login" );
			return;
		}

		$userId = $user['userId'];

		if ( $_POST['rememberMe'] ) {
			A( "AutoLogin" )->rememberMe( $userId, $user['password'] );

		}

		$lastLoginTime = date( 'Y-m-d H:i:s', time() );
		$User-> where( "userId=$userId" )->setField( 'lastLoginTime', date( 'Y-m-d H:i:s', time() ) );

		session( 'userId', $user['userId'] );
		session( 'userName', $user['userName'] );
		session( 'icon',  $user['icon'] );
		session( 'email',  $user['email'] );
		session( 'signature', $user['signature'] );
		session( 'score', $user['score'] );
		session( 'registerTime', format_date( $user['registerTime'] ) );
		session( 'lastLoginTime', format_date( $user['lastLoginTime'] ) );
		//session( 'lastLoginTime', format_date( $user['lastLoginTime'] ) );
		//var logedin == true;

		$this->success( 'Success', U('Index/index') );
	
	}

	//注销
	public function logout() {
		session( null );
		cookie( null );
		$this->success( 'Success', U('Index/index') );
	}

	protected function _initialize() {
		$this->where = 'Login';
		$this->title = '登录';

		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
