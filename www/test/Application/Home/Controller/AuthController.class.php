<?php
namespace Home\Controller;
use Think\Controller;
class AuthController extends Controller {

  //判断一个用户是否还有权限发布问题
  //积分小于10的用户每天只能发布一个问题
  //积分大于10的用户每天最多发布三个问题
  public function check( $userId ) {

    if ( empty( $userId ) ) {
      $result['success'] = false;
      $result['info'] = "Please log in first";
      return $result;
    }

    $Question = D( "Question" );
    $questionList = $Question->where( "userId=$userId" )->select();

    $questionCount = 0;

    for ( $i=0;$i<count( $questionList );$i++ ) {
      $question = $questionList[$i];
      if ( $this->isToday( $question['time'] ) ) {
        $questionCount++;
      }
    }

    $User = D( 'User' );
    $user = $User->find( $userId );
    $score = $user['score'];
    if ( $score>=10 ) {
      if ( $questionCount>=5 ) {
        $result['success'] = false;
        $result['info'] = "You can ask at most 5 question a day since you have".$score."";
      }else {
        $result['success'] = true;
      }

    }else {
      if ( $questionCount>=3 ) {
        $result['success'] = false;
        $result['info'] = "You can ask at most 3 question a day since you have".$score."";
      }else {
        $result['success'] = true;
      }
    }

    return $result;
  }

  //判断一个日期是否为今天
  public function isToday( $date ) {

    if ( empty( $date ) ) {
      return false;
    }

    $today = substr( date( 'Y-m-d H:i:s', time() ), 0, 10 );
    $date = substr( $date, 0, 10 );
    if ( $date == $today ) {
      return true;
    }else {
      return false;
    }
  }
}
