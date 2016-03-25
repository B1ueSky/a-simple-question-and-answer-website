<?php
namespace Home\Controller;
use Think\Controller;
class HotController extends Controller {
	//选取一个月内浏览数最多的问题作为本月热点问题
	public function getHotList() {
		$Model = M();
		$hotList = $Model->query( "select * from t_question  where DATE_SUB(CURDATE(),INTERVAL 1 MONTH) <= date(time) order by view desc limit 0,10" );
		$this->assign( 'hotList', $hotList );
	}
}
