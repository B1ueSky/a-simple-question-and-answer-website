<?php
namespace Home\Controller;
use Think\Controller;
class QuestionController extends Controller {

    //问题列表
    public function getQuestionList( $pageNum = '1' ) {

        $Question = D( 'Question' );
        $count = $Question->count();
        $Page = new \Think\Page( $count, 10 );
        $Page->setConfig( 'theme', "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>" );
        $show = $Page->show();
        $list = $Question->page( $pageNum.',10' )->order( "questionId desc" )->relation( true )->select();

        for ( $i=0;$i<count( $list );$i++ ) {
            $list[$i]['label'] = explode( ",", $list[$i]['label'] );
        }

        $this->assign( 'questionList', $list );
        $this->assign( 'page', $show );
    }

    //收藏
    public function collect() {
        $questionId = $_POST['questionId'];
        $userId = session( 'userId' );

        $Collect = M( "Collect" );

        $data['questionId'] = $questionId;
        $data['userId'] = $userId;
        $data['time'] = date( 'Y-m-d H:i:s', time() );

        $Collect->add( $data );

        $result['success'] = true;
        $result['count'] = $Collect->where( "questionId = $questionId" )->count();
        $this->ajaxReturn( $result );
    }

    //顶
    public function reviewUp() {
        $answerId = $_POST['answerId'];
        $userId = session( 'userId' );
        if ( empty( $answerId ) or empty( $userId ) ) {
            $this->ajaxReturn( "error" );
            return;
        }

        $Review = M( 'Review' );

        $data['answerId'] = $answerId;
        $data['userId'] = $userId;
        $data['up'] = 1;

        $Review->add( $data );

        $upNum = $Review->where( "answerId=$answerId and up=1" )->count();

        $result['success'] = true;
        $result['count'] = $upNum;
        $this->ajaxReturn( $result );
    }

    //踩
    public function reviewDown() {
        $answerId = $_POST['answerId'];
        $userId = session( 'userId' );
        if ( empty( $answerId ) or empty( $userId ) ) {
            $this->ajaxReturn( "error" );
            return;
        }

        $Review = M( 'Review' );

        $data['answerId'] = $answerId;
        $data['userId'] = $userId;
        $data['up'] = 0;

        $Review->add( $data );


        $upNum = $Review->where( "answerId=$answerId and up=0" )->count();

        $result['success'] = true;
        $result['count'] = $upNum;
        $this->ajaxReturn( $result );
    }

    //采纳问题
    public function accept() {
        $questionId = $_GET['questionId'];
        $bestAnswerId = $_GET['bestAnswerId'];

        $data['questionId'] = $questionId;
        $data['bestAnswer'] = $bestAnswerId;
        $data['solved'] = 1;


        $Question = D( "Question" );


        $question = $Question->find( $questionId );
        if ( $question['solved'] == 1 ) {
            $this->error( "该问题已经解决" );
            return;
        }

        $score = $question['score'];

        $Question->save( $data );



        $Answer = D( "Answer" );
        $answer = $Answer->find( $bestAnswerId );
        $userId = $answer['userId'];

        $User = D( "User" );
        $User->execute( "update t_user set score = score+$score where userId=$userId" );

        $this->success( "采纳成功" );
    }

    //跳转到问题页
    public function questionPage() {

        $questionId = $_GET['id'];

        $Question = D( 'Question' );

        $Question->execute( "update t_question set view=view+1 where questionId=$questionId" );

        $question = $Question->relation( true )->find( $questionId );

        $question['content'] = $this->transContent( $question['content'] );

        $question['label'] = explode( ",", $question['label'] );

        $userId = session( 'userId' );

        if ( $userId ==$question['userId'] and ( $question['solved']!=1 ) ) {
            $question['acceptable'] = true;
        }

        $Answer = D( 'Answer' );
        $Review = M( 'Review' );
        $Collect = M( 'Collect' );
        $question['CollectEnable'] = $Collect->where( "questionId=$questionId and userId=$userId" )->count();

        $bestAnswerId = $question['bestAnswer'];
        if ( empty( $bestAnswerId ) ) {
            $otherAnswers = $Answer->where( "(questionId=$questionId)  And (isNull(parentAnswerId))" )->relation( true )->select();
        }else {
            $bestAnswerList = $Answer->where( "(questionId=$questionId) AND (answerId=$bestAnswerId) And (isNull(parentAnswerId))" )->relation( true )->select();
            $bestAnswer = $bestAnswerList[0];
            $bestAnswer['up'] = $Review->where( "answerId=$bestAnswerId and up=1" )->count();
            $bestAnswer['down'] = $Review->where( "answerId=$bestAnswerId and up=0" )->count();
            $bestAnswer['enable'] = $Review->where( "answerId=$bestAnswerId and userId=$userId" )->count();
            $bestAnswer['Subanswer'] = $Answer->where( "parentAnswerId = $bestAnswerId" )->relation( true )->select();
            $otherAnswers = $Answer->where( "(questionId=$questionId) AND (answerId<>$bestAnswerId) And (isNull(parentAnswerId))" )->relation( true )->select();
        }

        for ( $i=0;$i<count( $otherAnswers );$i++ ) {
            $otherAnswerId = $otherAnswers[$i]['answerId'];
            $otherAnswers[$i]['Subanswer'] = $Answer->where( "parentAnswerId = $otherAnswerId" )->relation( true )->select();
            $otherAnswers[$i]['up'] = $Review->where( "answerId=$otherAnswerId and up=1" )->count();
            $otherAnswers[$i]['down'] = $Review->where( "answerId=$otherAnswerId and up=0" )->count();
            $otherAnswers[$i]['enable'] = $Review->where( "answerId=$otherAnswerId and userId=$userId" )->count();
        }

        $this->assign( 'bestAnswer', $bestAnswer );
        $this->assign( 'otherAnswers', $otherAnswers );
        $this->assign( 'question', $question );

        $this->display( "Question:question" );
    }

    //回答问题
    public function submitMyAnswer() {
        $content = $_POST['content'];
        $userId = session( 'userId' );
        $questionId = $_POST['questionId'];
        $time =  date( 'Y-m-d H:i:s', time() );

        if ( trim( $content ) == "" ) {
            $result['success'] = false;
            $result['info'] = "内容不能为空";
            $this->ajaxReturn( $result );
            return;
        }
        $Answer = D( "Answer" );
        $Review = D( "Review" );
        $data['questionId'] = $questionId;
        $data['userId'] = $userId;
        $data['content'] = $content;
        $data['time'] = $time;

        $answerId = $Answer->add( $data );

        $answer = $Answer->relation( true )->find( $answerId );

        $answer['up'] = $Review->where( "answerId=$answerId and up=1" )->count();
        $answer['down'] = $Review->where( "answerId=$answerId and up=0" )->count();
        $answer['enable'] = $Review->where( "answerId=$answerId and userId=$userId" )->count();

        $result['success'] = true;
        $result['html'] =  $this->assign( "otherAnswer", $answer )->fetch( "Question:answerItem" );
        $result['count'] = $Answer->where( "questionId=$questionId" )->count();
        $this->ajaxReturn( $result );
    }

    //对回复进行回复
    public function submitSubAnswer() {
        $parentAnswerId = $_POST['answerId'];
        $content = $_POST['content'];
        $replyUserId = $_POST['user_to_id'];
        $userId = session( 'userId' );
        $time = date( 'Y-m-d H:i:s', time() );


        $Answer = D( "Answer" );
        $parentAnswer = $Answer->find( $parentAnswerId );
        $questionId = $parentAnswer['questionId'];
        $data['questionId'] = $questionId;
        $data['parentAnswerId'] = $parentAnswerId;
        $data['userId'] = $userId;
        $data['replyUserId'] = $replyUserId;
        $data['content'] = $content;
        $data['time'] = $time;
        if ( $data['userId'] == "" ) $data['userId'] = null;
        if ( $data['replyUserId'] == "" ) $data['replyUserId'] = null;

        $subAnswerId = $Answer->add( $data );

        $subAnswer = $Answer->relation( true )->find( $subAnswerId );
        $result['success'] = true;
        $result['html'] =  $this->assign( "subAnswer", $subAnswer )->fetch( "Question:subAnswerItem" );
        $result['count'] = $Answer->where( "questionId=$questionId" )->count();
        $result['subCount'] = $Answer->where( "parentAnswerId = $parentAnswerId" )->count();
        $this->ajaxReturn( $result );
    }

    //将内容还原成html
    public function transContent( $str ) {
        $str = htmlspecialchars_decode( $str );
        return $str;
    }


    protected function _initialize() {
        $this->where = 'question';
        $this->title = '问题';

        A( 'AutoLogin' )->autoLogin();
        A( 'Hot' )->getHotList();
    }

}
