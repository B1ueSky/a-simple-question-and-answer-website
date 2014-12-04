<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends Controller {

    //查找问题
    public function searchQuestion() {

        $keyword = $_POST['keyword'];
        $pageNum = $_GET['p'];
        if ( empty( $pageNum ) ) $pageNum = 1;
        $map['title|content|label'] =array( 'like', "%$keyword%" );

        $Question = D( 'Question' );
        $count = $Question->where( $map )->count();
        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();

        $list = $Question->where( $map )->order( "questionId desc" )->page( $pageNum.',10' )->relation( true )->select();

        for ( $i=0;$i<count( $list );$i++ ) {
            $list[$i]['label'] = explode( ",", $list[$i]['label'] );
        }

        $this->assign( 'keyword', $keyword );
        $this->assign( 'questionList', $list );
        $this->assign( 'page', $show );
        $this->display( "Search:questionResult" );
    }


    //查找用户
    public function searchUser() {

        $keyword = $_POST['keyword'];
        $pageNum = $_GET['p'];
        if ( empty( $pageNum ) ) $pageNum = 1;
        $map['userName|email'] =array( 'like', "%$keyword%" );

        $User = D( 'User' );
        $count = $User->where( $map )->count();
        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();


        $list = $User->where( $map )->page( $pageNum.',10' )->relation( true )->select();

        for ( $i=0;$i<count( $list );$i++ ) {
            $list[$i]['registerTime'] = format_date( $list[$i]['registerTime'] );
            $list[$i]['lastLoginTime'] = format_date( $list[$i]['lastLoginTime'] );
        }
        $this->assign( 'keyword', $keyword );
        $this->assign( 'userList', $list );
        $this->assign( 'page', $show );

        $this->display( "Search:userResult" );
    }

    protected function _initialize() {
        $this->where = 'search';
        $this->title = '搜索';
        A( 'AutoLogin' )->autoLogin();
        A( 'Hot' )->getHotList();
    }
}
