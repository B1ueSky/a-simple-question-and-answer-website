<?php
namespace Home\Controller;
use Think\Controller;
class UserInfoController extends Controller {

    //用户信息
    public function index() {
        $userId = $_GET['userId'];
        $type = $_GET['type'];
        $pageNum = $_GET['p'];

        if ( ( session( 'userId' ) and empty( $userId ) ) ) {
            $userId = session( 'userId' );
        }
        if ( $type == 2 ) {
            $this->getAnswerList( $userId, $pageNum );
        }else if ( $type==3 ) {
            $this->getReplayList( $userId, $pageNum );
        }else if ( $type==4 ) {
            $this->getCollectionList( $userId, $pageNum );
        }else if ( $type==5 ) {
            $this->getInterestAreaList( $userId, $pageNum );
        }else if ( $type==6 ) {
            $this->getExpertAreaList( $userId, $pageNum );
        }else {
            $this->getAskList( $userId, $pageNum );
        }

        $this->assign( 'type', $type );

        if ( $userId == session( 'userId' ) ) {
            $User = D( 'User' );
            $user = $User->find( $userId );

            session( 'score', $user['score'] );
            session( 'registerTime', format_date( $user['registerTime'] ) );
            session( 'lastLoginTime', format_date( $user['lastLoginTime'] ) );

            $this->display( 'User:userInfo' );
        }
        else {

            $User = D( 'User' );
            $user = $User->find( $userId );
            $user['registerTime'] = format_date( $user['registerTime'] );
            $user['lastLoginTime'] = format_date( $user['lastLoginTime'] );

            $this->assign( 'other', $user );

            $this->display( 'User:othersInfo' );
        }
    }

    //保存信息
    public function saveInfo() {
        $newUserName = $_POST['newUserName'];
        $newSignature = $_POST['newSignature'];

        if ( trim( $newUserName ) == '' ) {
            $this->ajaxReturn( "userNameError" );
            return;
        }

        $email = session( 'email' );

        $User = M( "User" );
        $User->userName = $newUserName;
        $User->signature = $newSignature;
        $User->where( "email='$email'" )->save();

        session( 'userName', $newUserName );
        session( 'signature', $newSignature );

        $this->ajaxReturn( 'success' );
    }


    //修改密码
    public function saveNewPassword() {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        if ( $newPassword !== $confirmNewPassword ) {
            $this->ajaxReturn( "confirmNewPasswordError" );
            return;
        }

        $User = D( 'User' );
        $userId = session( 'userId' );
        $user = $User->find( $userId );

        $oldOne = substr( md5( $oldPassword ), 0, 16 ) . substr( sha1( $oldPassword ), 16, 24 );
        $newOne = substr( md5( $newPassword ), 0, 16 ) . substr( sha1( $newPassword ), 16, 24 );
        if ( $oldOne !== $user['password'] ) {
            $this->ajaxReturn( "oldPasswordError" );
            return;
        }

        $data['userId'] = $userId;
        $data['password'] = $newOne;
        $User-> save( $data );
        $this->ajaxReturn( "success" );
    }

    // add interested area
    public function saveNewInterestedArea() {
        $newAreaId = $_POST['newAreaId'];
        //$newAreaId = 10;
        $Interest = D( 'Interest' );
        $userId = session( 'userId' );
        //$userId = 13;

        $data['userId'] = $userId;
        $data['areaId'] = $newAreaId;
        $Interest->data( $data )->add();
        $this->ajaxReturn( "success" );
    }

    //上传头像
    public function xiuxiuUpload() {
        $post_input = 'php://input';
        $save_path = dirname( "./" );
        $postdata = file_get_contents( $post_input );


        if ( isset( $postdata ) && strlen( $postdata ) > 0 ) {
            $img =  uniqid() . '.jpg';
            $filename = $save_path . '/Uploads/' .$img;
            $handle = fopen( $filename, 'w+' );
            fwrite( $handle, $postdata );
            fclose( $handle );
            if ( is_file( $filename ) ) {
                //保存新的头像，删除旧的头像
                $User = D( 'User' );
                echo 'Image data save successed,file:' . $filename;
                $data['userId'] = session( 'userId' );
                $data['icon'] = $img;
                $User->save( $data );
                $filebefore = $save_path . '/Uploads/' . session( 'icon' );
                if ( session( 'icon' )!='default.jpg' ) {
                    unlink( $filebefore );
                }
                session( 'icon', $img );
                exit ();
            }else {
                die ( 'Image upload error!' );
            }
        }else {
            die ( 'Image data not detected!' );
        }
    }


    //提问列表
    public function getAskList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
        $Question = D( "Question" );

        $count = $Question->where( "userId=$userId" )->order( "questionId desc" )->count();

        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();
        $askList = $Question->where( "userId=$userId" )->order( "questionId desc" )->relation( true )->page( $pageNum.',10' )->select();

        $this->assign( 'page', $show );
        $this->assign( 'askList', $askList );
    }

    //回答列表
    public function getAnswerList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
        $Answer = D( "Answer" );
        $Question = D( "Question" );

        $count = $Answer->where( "userId=$userId" )->order( "answerId desc" )->count();
        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();

        $answerList = $Answer->where( "userId=$userId" )->order( "answerId desc" )->relation( true )->page( $pageNum.',10' )->select();

        for ( $i=0;$i<count( $answerList );$i++ ) {
            if ( empty( $answerList[$i]['ReplyUser'] ) ) {
                $parentAnswerId = $answerList[$i]['parentAnswerId'];
                $reply = $Answer->where( "answerId=$parentAnswerId" )->relation( true )->find();
                $answerList[$i]['ReplyUser'] = $reply['User'];
            }
        }
        $this->assign( 'page', $show );
        $this->assign( "answerList", $answerList );
    }

    //回复我的 列表
    public function getReplayList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
         $Answer = D("Answer");
         $Question = D("Question");

        $count = $Answer->where("replyUserId=$userId or (isnull(replyUserId) and parentAnswerId in (select answerId as id from t_answer as t where t.userId = $userId)) or (isnull(parentAnswerId) and questionId in (select questionId from t_question where userId=$userId))")->order("answerId desc")->count();
        
        $Page = new \Think\Page($count,10);
        $Page->setConfig('theme',"<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>");
        $show = $Page->show();

        $replyList = $Answer->where("replyUserId=$userId or (isnull(replyUserId) and parentAnswerId in (select answerId as id from t_answer as t where t.userId = $userId)) or (isnull(parentAnswerId) and questionId in (select questionId from t_question where userId=$userId))")->order("answerId desc")->relation(true)->page($pageNum.',10')->select();

        $this->assign( 'page', $show );
        $this->assign( "replyList", $replyList );
    }

    //收藏列表
    public function getCollectionList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
        $Collection = D( "Collect" );

        $count = $Collection->where( "userId=$userId" )->count();

        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();

        $collectionList =  $Collection->where( "userId=$userId" )->order( "collectId desc" )->relation( "Question" )->page( $pageNum.',10' )->select();
        $this->assign( 'page', $show );
        $this->assign( "collectionList", $collectionList );
    }

    // Interested areas
    public function getInterestAreaList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
        $Interest = D( "Interest" );

        $count = $Interest->where( "userId=$userId" )->count();

        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();

        $interestList =  $Interest->where( "userId=$userId" )->order( "interestId desc" )->relation( "Area" )->page( $pageNum.',10' )->select();
        $this->assign( 'page', $show );
        $this->assign( "interestList", $interestList );

        # find other areas
        $interestAreaIds = array();
        foreach ($interestList as $interest) {
            $interestAreaIds[] = $interest['areaId'];
        }
        $this->assign( "interestAreaIds", $interestAreaIds );

        $Area = D( "Area" );
        $map['areaId'] = array('not in', $interestAreaIds);
        $otherAreaList = $Area->where($map)->select();

        $this->assign( "otherAreaList", $otherAreaList );

    }

    // Expert areas
    public function getExpertAreaList( $userId, $pageNum ) {
        if ( empty( $pageNum ) ) {
            $pageNum = 1;
        }
        $Expert = D( "Expert" );

        $count = $Expert->where( "userId=$userId" )->count();

        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();

        $expertList =  $Expert->where( "userId=$userId" )->order( "expertId desc" )->relation( "Area" )->page( $pageNum.',10' )->select();
        $this->assign( 'page', $show );
        $this->assign( "expertList", $expertList );
    }

    protected function _initialize() {
        $this->where = 'UserInfo';
        $this->title = '用户信息';

        A( 'AutoLogin' )->autoLogin();
        A( 'Hot' )->getHotList();
    }
}
