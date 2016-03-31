<?php if (!defined('THINK_PATH')) exit();?><li class="media answer">
  <div class="pull-left">
  <img class="media-object icon-sm" src="/Uploads/<?php echo ($otherAnswer["User"]["icon"]); ?>"></div>
  <div class="media-body">
    <div class="media-heading">
      <a href="<?php echo U('UserInfo/index',array('userId'=>$otherAnswer['User']['userId']));?>"><?php echo ($otherAnswer["User"]["userName"]); ?></a>
      <span class="pull-right gray"><?php echo ($otherAnswer["time"]); ?></span>
    </div>
    <div class="media-content" >
      <p style="text-indent:28px;padding-left:10px;">
      <?php echo ($otherAnswer["content"]); ?>
      </p>
    </div>
    <div class="media-action">
      <div class="pull-right">
        <a class="quote-btn subAnswer" href="#answer">Reply(<span class="subAnswerNum"><?php echo (count($otherAnswer["Subanswer"])); ?></span>)</a>
        <a class="quote-btn hideSubAnswer" style="display:none;" href="#answer">Hide reply</a>
        <?php if(($otherAnswer["enable"] == 1) or (empty($_SESSION['userId'])) ): ?><button class="btn btn-default disabled"><span class="glyphicon glyphicon-thumbs-up"></span><?php echo ($otherAnswer["up"]); ?></button>
        <button class="btn btn-default disabled"><span class="glyphicon glyphicon-thumbs-down"></span><?php echo ($otherAnswer["down"]); ?></button>
        <?php else: ?>
        <button class="btn btn-default reviewUp"><span class="glyphicon glyphicon-thumbs-up"></span><?php echo ($otherAnswer["up"]); ?></button>
        <button class="btn btn-default reviewDown"><span class="glyphicon glyphicon-thumbs-down"></span><?php echo ($otherAnswer["down"]); ?></button><?php endif; ?>
      </div>
      <br/>
      <br/>
      <div class="subAnswerContent">
        <ul class="media-list subAnswerList">
          <?php if(is_array($otherAnswer["Subanswer"])): foreach($otherAnswer["Subanswer"] as $key=>$subAnswer): ?><li class="media">
            <div class="pull-left">
            <img class="media-object icon-sm" src="/Uploads/<?php echo ($subAnswer["User"]["icon"]); ?>"></div>
            <div class="media-body">
              <div class="media-content" >
                <p>
                <span ><a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['User']['userId']));?>"><?php echo ($subAnswer["User"]["userName"]); ?></a>
                <?php if(!empty($subAnswer["ReplyUser"])): ?><span>Reply<a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['ReplyUser']['userId']));?>"><?php echo ($subAnswer["ReplyUser"]["userName"]); ?></a></span><?php endif; ?>
                :
                </span>
                <?php echo ($subAnswer["content"]); ?>
                </p>
                <span class="pull-right gray" style="padding-right:10px;">
                <button class="btn btn-link answer_to">
                Reply
                </button>
                <span style="display:none" class="user_to_id"><?php echo ($subAnswer["userId"]); ?></span>
                <span style="display:none" class="user_to_name"><?php echo ($subAnswer["User"]["userName"]); ?></span>
                <?php echo ($subAnswer["time"]); ?></span>
              </div>
            </div>
          </li><?php endforeach; endif; ?>
        </ul>
        <form method="post" class="form-inline">
          <div class="input-group">
            <span  class="answer_to_label" style="display:none">Reply</span>
            <span  style="display:none" type="text" class="user_to_name"></span>
            <input  type="button" style="display:none" class="btn btn-default btn-xs cancel_answer_to"  value="X">
          </div>
          <input disabled="disabled" style="display:none" class="answerId" value="<?php echo ($otherAnswer["answerId"]); ?>">
          <input style="display:none" disabled="disabled" class="user_to_id">
          <input type="text" class="form-control mySubAnswer" style="width:90%">
          <button  class="btn btn-default submitSubAnswer">Reply</button>
        </form>
      </div>
    </div>
  </div>
</li>