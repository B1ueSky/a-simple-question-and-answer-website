<?php if (!defined('THINK_PATH')) exit();?><li class="media">
    <div class="pull-left">
    <img class="media-object icon-sm" src="/Uploads/<?php echo ($subAnswer["User"]["icon"]); ?>"></div>
    <div class="media-body">
        <div class="media-content" >
            <p>
            <span><a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['User']['userId']));?>"><?php echo ($subAnswer["User"]["userName"]); ?></a>
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
</li>