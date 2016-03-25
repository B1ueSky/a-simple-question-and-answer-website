<?php
namespace Home\Controller;
use Think\Controller;
class AutoLoginController extends Controller {

	//自动登录
	public function autoLogin() {
		if ( cookie( 'token' ) ) {

			$token = cookie( 'token' );

			$userId = $token['userId'];
			if ( !is_numeric( $userId ) )
				return 0;

			$User = D( 'User' );
			$user = $User->find( $userId );
			if ( $user['userId'] != $userId )
				return 0;

			if ( $token['verify'] != sha1( md5( $user['password'] ) ) )
				return 0;

			session( 'userId', $user['userId'] );
			session( 'userName', $user['userName'] );
			session( 'icon',  $user['icon'] );
			session( 'email',  $user['email'] );
			session( 'signature', $user['signature'] );
			session( 'score', $user['score'] );
			session( 'registerTime', format_date( $user['registerTime'] ) );
			session( 'lastLoginTime', format_date( $user['lastLoginTime'] ) );

			//更新上次登录时间
			$User-> where( "userId=$userId" )->setField( 'lastLoginTime', date( 'Y-m-d H:i:s', time() ) );

			cookie( 'token', $token, 864000 );
			return 1;
		} else {
			return 0;
		}
	}

	//将用户基本信息存到cookie中
	public function rememberMe( $userId, $password, $expire=864000 ) {
		$token['userId']  = $userId;
		$token['verify'] = sha1( md5( $password ) );
		cookie( 'token', $token, $expire );
		return 1;
	}
}
