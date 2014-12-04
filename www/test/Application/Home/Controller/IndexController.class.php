<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function index() {
		$Question = A( 'Question' );
		$Question->getQuestionList( $_GET['p'] );

		$this->display( 'Index:index' );
	}

	protected function _initialize() {
		$this->where = 'index';
		$this->title = '首页';
		A( 'AutoLogin' )->autoLogin();
		A( 'Hot' )->getHotList();
	}
}
