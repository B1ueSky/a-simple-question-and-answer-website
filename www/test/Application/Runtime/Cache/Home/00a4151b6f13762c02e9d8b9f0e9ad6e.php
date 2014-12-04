<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Public/css/prettify.css" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/css/myeditor.css" rel="stylesheet">
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/Public/css/common.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="wrap">
      <nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mycollaspse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a href="<?php echo U('Index/index');?>" class="navbar-brand sitetitle">Q&A <span style="font-size:12px"> 一个简单的问答网站</span></a>
		</div>

		<div class="collapse navbar-collapse" id="mycollaspse">
			<ul class="navbar-nav navbar-left nav">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</ul>
			
			<form id="searchForm" class="navbar-form navbar-left form-inline" method="post">
				<input class="form-control" style="width:280px;" type="text" name="keyword" placeholder="输入你想知道的内容">
				<span class="input-group">
				<span class="input-group-btn">
				<button class="btn btn-default" id="searchUser">
				<span class="glyphicon glyphicon-user" style="color:gray">
				</span>用户</button>
				<button class="btn btn-default" id="searchQuestion">
				<span class="glyphicon glyphicon-question-sign" style="color:gray"></span>
				问题</button>
				</span>
				</span>
			</form>
			<ul class="navbar-nav navbar-right nav">
				
				<?php if(empty($_SESSION['userName'])): ?><li><a id="login" href="<?php echo U('Login/loginPage');?>">登录</a></li>
				<li><a id="register" href="<?php echo U('Register/registerPage');?>"  >注册</a></li>
				<?php else: ?>
				<li>
					<a  href="<?php echo U('UserInfo/index');?>">
						<img src="/Uploads/<?php echo ($_SESSION['icon']); ?>" style="width:24px;height:24px;border-radius: 5px;">
						<?php echo ($_SESSION['userName']); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo U('Login/logout');?>">注销</a>
				</li><?php endif; ?>
			</ul>
		</div>
	</div>
</nav>
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#searchUser").click(function(e){
	e.preventDefault();
$("#searchForm").attr("action","<?php echo U('Search/searchUser');?>");
$("#searchForm").submit();
});
$("#searchQuestion").click(function(e){
	e.preventDefault();
$("#searchForm").attr("action","<?php echo U('Search/searchQuestion');?>");
$("#searchForm").submit();
});
});
</script>
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <h2 class="page-header">
            问题
            </h2>
            <div class="media question">
              <div class="pull-left" >
                <img class="media-object icon-sm" src="/Uploads/<?php echo ($question["User"]["icon"]); ?>">
                <a href="<?php echo U('UserInfo/index',array('userId'=>$question['User']['userId']));?>" class="userName"><?php echo ($question["User"]["userName"]); ?></a>
              </div>
              <div class="media-body">
                <div class="media-heading">
                  <?php if(($question["solved"] == 1) ): ?><span class="glyphicon glyphicon-ok-sign solved">[已解决]</span>
                  <?php else: ?>
                  <span class="glyphicon glyphicon-question-sign unsolved">[待解决]</span><?php endif; ?>
                  <a href="<?php echo U('Question/questionPage',array('id'=>$question['questionId']));?>"><?php echo ($question["title"]); ?></a>
                  <small>[ 悬赏分：<?php echo ($question["score"]); ?> ]</small>
                  <span class="pull-right gray"><?php echo ($question["time"]); ?></span>
                </div>
                <div class="media-action">
                  <div style="text-indent:10px;">
                    <span class="glyphicon glyphicon-tags"></span>
                    标签:
                    <?php if(is_array($question["label"])): foreach($question["label"] as $key=>$singleLabel): ?><span class="label myLabel"><?php echo ($singleLabel); ?>
                    </span>
                    &nbsp;<?php endforeach; endif; ?>
                  </div>
                  
                  <div>
                    <br/>
                    <p class="gray questionContent" style="text-indent:28px;"><?php echo ($question["content"]); ?></p>
                  </div>
                  <div>
                    <span class="pull-right">
                    <button class="btn btn-default disabled">
                    <span class="glyphicon glyphicon-eye-open gray">
                    浏览<span class="viewNum"><?php echo ($question["view"]); ?></span>
                    </span>
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-default" href="#toAnswer">
                      <span class="glyphicon glyphicon-comment gray">
                      回复<span class="answerNum"><?php echo (count($question["Answer"])); ?></span>
                      </span>
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if(($question["CollectEnable"] == 1) or (empty($_SESSION['userId'])) ): ?><button class="btn btn-default disabled">
                    <span class="glyphicon glyphicon-star gray">
                    收藏<span class="collectNum"><?php echo (count($question["Collect"])); ?></span>
                    </span>
                    </button>
                    <?php else: ?>
                    <button class="btn btn-default Collect">
                    <span class="glyphicon glyphicon-star gray">
                    收藏<span class="collectNum"><?php echo (count($question["Collect"])); ?></span>
                    </span>
                    </button><?php endif; ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <?php if(!empty($bestAnswer["answerId"])): ?><h2 class="page-header">提问者采纳</h2>
            <div class="answer bestAnswer" id="bestAnswer">
              <div class="media">
                <div class="pull-left">
                  <img class="media-object icon-sm" src="/Uploads/<?php echo ($bestAnswer["User"]["icon"]); ?>">
                </div>
                
                <div class="media-body">
                  <div class="media-heading">
                    <a href="<?php echo U('UserInfo/index',array('userId'=>$bestAnswer['User']['userId']));?>">
                      <?php echo ($bestAnswer["User"]["userName"]); ?>
                    </a>
                    <span class="pull-right gray"><?php echo ($bestAnswer["time"]); ?></span>
                  </div>
                  
                  <div class="media-content" >
                    <p style="text-indent:28px;padding-left:10px;">
                    <?php echo ($bestAnswer["content"]); ?>
                    </p>
                  </div>
                  <div class="media-action">
                    <div class="pull-right">
                      <a class="quote-btn subAnswer" href="#answer">
                        回复(<span class="subAnswerNum"><?php echo (count($bestAnswer["Subanswer"])); ?></span>)
                      </a>
                      <a class="quote-btn hideSubAnswer" style="display:none;" href="#answer">
                        收起回复
                      </a>
                      <?php if(($bestAnswer["enable"] == 1) or (empty($_SESSION['userId'])) ): ?><button class="btn btn-default disabled">
                      <span class="glyphicon glyphicon-thumbs-up"></span>
                      <?php echo ($bestAnswer["up"]); ?>
                      </button>
                      <button class="btn btn-default disabled">
                      <span class="glyphicon glyphicon-thumbs-down"></span>
                      <?php echo ($bestAnswer["down"]); ?>
                      </button>
                      <?php else: ?>
                      <button class="btn btn-default reviewUp">
                      <span class="glyphicon glyphicon-thumbs-up"></span>
                      <?php echo ($bestAnswer["up"]); ?>
                      </button>
                      <button class="btn btn-default reviewDown">
                      <span class="glyphicon glyphicon-thumbs-down"></span>
                      <?php echo ($bestAnswer["down"]); ?>
                      </button><?php endif; ?>
                    </div>
                    <br/>
                    <br/>
                    <div class="subAnswerContent">
                      <ul class="media-list subAnswerList">
                        <?php if(is_array($bestAnswer["Subanswer"])): foreach($bestAnswer["Subanswer"] as $key=>$subAnswer): ?><li class="media">
                          <div class="pull-left">
                            <img class="media-object icon-sm" src="/Uploads/<?php echo ($subAnswer["User"]["icon"]); ?>">
                          </div>
                          <div class="media-body">
                            <div class="media-content" >
                              <p>
                              <span>
                              <a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['User']['userId']));?>">     <?php echo ($subAnswer["User"]["userName"]); ?>
                              </a>
                              <?php if(!empty($subAnswer["ReplyUser"])): ?><span>回复
                              <a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['ReplyUser']['userId']));?>">
                                <?php echo ($subAnswer["ReplyUser"]["userName"]); ?>
                              </a>
                              </span><?php endif; ?>
                              :
                              </span>
                              <?php echo ($subAnswer["content"]); ?>
                              </p>
                              <span class="pull-right gray" style="padding-right:10px;">
                              <button class="btn btn-link answer_to">
                              回复
                              </button>
                              <span style="display:none" class="user_to_id"><?php echo ($subAnswer["userId"]); ?></span>
                              <span style="display:none" class="user_to_name"><?php echo ($subAnswer["User"]["userName"]); ?></span>
                              <?php echo ($subAnswer["time"]); ?>
                              </span>
                            </div>
                          </div>
                        </li><?php endforeach; endif; ?>
                      </ul>
                      <?php if(empty($_SESSION['userName'])): ?><span class="error">
                      <a href="<?php echo U('Login/loginPage');?>">
                        &nbsp;登录&nbsp;
                      </a>后才可以回复
                      </span>
                      <?php else: ?>
                      <form method="post" class="form-inline">
                        <div class="input-group">
                          <span  class="answer_to_label" style="display:none">回复</span>
                          <span  style="display:none" type="text" class="user_to_name"></span>
                          <input  type="button" style="display:none" class="btn btn-default btn-xs cancel_answer_to"  value="X">
                        </div>
                        <input disabled="disabled" style="display:none" class="answerId" value="<?php echo ($bestAnswer["answerId"]); ?>">
                        <input style="display:none" disabled="disabled" class="user_to_id">
                        <input type="text" class="form-control mySubAnswer" style="width:90%">
                        <button  class="btn btn-default submitSubAnswer">回复</button>
                      </form><?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div><?php endif; ?>
            <div id="answers">
              <h2 class="page-header">
              共 <em><span class="answerNum"><?php echo (count($question["Answer"])); ?></span></em>
              条回答
              </h2>
              <ul class="media-list otherAnswerList">
                <?php if(is_array($otherAnswers)): foreach($otherAnswers as $key=>$otherAnswer): ?><li class="media answer">
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
                        <?php if(!empty($question["acceptable"])): ?><a href="<?php echo U('Question/accept',array('questionId'=>$question['questionId'],'bestAnswerId'=>$otherAnswer['answerId']));?>">采纳</a><?php endif; ?>
                        <a class="quote-btn subAnswer" href="#answer">回复(<span class="subAnswerNum"><?php echo (count($otherAnswer["Subanswer"])); ?></span>)</a>
                        <a class="quote-btn hideSubAnswer" style="display:none;" href="#answer">收起回复</a>
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
                                <?php if(!empty($subAnswer["ReplyUser"])): ?><span>回复<a href="<?php echo U('UserInfo/index',array('userId'=>$subAnswer['ReplyUser']['userId']));?>"><?php echo ($subAnswer["ReplyUser"]["userName"]); ?></a></span><?php endif; ?>
                                :
                                </span>
                                <?php echo ($subAnswer["content"]); ?>
                                </p>
                                <span class="pull-right gray" style="padding-right:10px;">
                                <button class="btn btn-link answer_to">
                                回复
                                </button>
                                <span style="display:none" class="user_to_id"><?php echo ($subAnswer["userId"]); ?></span>
                                <span style="display:none" class="user_to_name"><?php echo ($subAnswer["User"]["userName"]); ?></span>
                                <?php echo ($subAnswer["time"]); ?></span>
                              </div>
                            </div>
                          </li><?php endforeach; endif; ?>
                        </ul>
                        <?php if(empty($_SESSION['userName'])): ?><span class="error"><a  href="<?php echo U('Login/loginPage');?>">&nbsp;登录&nbsp;</a>后才可以回复</span>
                        <?php else: ?>
                        <form method="post" class="form-inline">
                          <div class="input-group">
                            <span  class="answer_to_label" style="display:none">回复</span>
                            <span  style="display:none" type="text" class="user_to_name"></span>
                            <input  type="button" style="display:none" class="btn btn-default btn-xs cancel_answer_to"  value="X">
                          </div>
                          <input disabled="disabled" style="display:none" class="answerId" value="<?php echo ($otherAnswer["answerId"]); ?>">
                          <input style="display:none" disabled="disabled" class="user_to_id">
                          <input type="text" class="form-control mySubAnswer" style="width:90%">
                          <button  class="btn btn-default submitSubAnswer">回复</button>
                        </form><?php endif; ?>
                      </div>
                    </div>
                  </div>
                </li><?php endforeach; endif; ?>
              </ul>
            </div>
            <div id="myAnswer">
              <span id="toAnswer"></span>
              <h2 class="page-header" >我要回答</h2>
              <div style="padding-left:60px;">
                <form class="form-horizontal myAnswerForm">
                  <div class="form-group">
                    
                    <div class="col-md-8">
                      <div id="alerts"></div>
                      <div>
                        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="bold" title="加粗(Ctrl+B)"> <i class="icon-bold"></i>
                            </a>
                            <a class="btn btn-default" data-edit="italic" title="斜体(Ctrl+I)"> <i class="icon-italic"></i>
                            </a>
                            <a class="btn btn-default" data-edit="strikethrough" title="删除线">
                              <i class="icon-strikethrough"></i>
                            </a>
                            <a class="btn btn-default" data-edit="underline" title="下划线(Ctrl+U)">
                              <i class="icon-underline"></i>
                            </a>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="justifyleft" title="左对齐(Ctrl+L)">
                              <i class="icon-align-left"></i>
                            </a>
                            <a class="btn btn-default" data-edit="justifycenter" title="居中(Ctrl+E)">
                              <i class="icon-align-center"></i>
                            </a>
                            <a class="btn btn-default" data-edit="justifyright" title="右对齐(Ctrl+R)">
                              <i class="icon-align-right"></i>
                            </a>
                            <a class="btn btn-default" data-edit="justifyfull" title="两端对齐(Ctrl+J)">
                              <i class="icon-align-justify"></i>
                            </a>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="添加超链接">
                              <i class="icon-link"></i>
                            </a>
                            <div class="dropdown-menu input-append">
                              <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                              <button class="btn btn-default" type="button">Add</button>
                            </div>
                            <a class="btn btn-default" data-edit="unlink" title="取消超链接">
                              <i class="icon-cut"></i>
                            </a>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" title="插入图片或直接将图片拖拽至输入框" id="pictureBtn">
                              <i class="icon-picture"></i>
                            </a>
                            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="undo" title="撤销(Ctrl+Z)">
                              <i class="icon-undo"></i>
                            </a>
                          </div>
                          <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                        </div>
                        <div id="editor" class="myAnswerContent" style="width:600px;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-offset-5 col-md-4 error myAnswerError" style="text-align:right">
                      <?php if(empty($_SESSION['userName'])): ?><a href="<?php echo U('Login/loginPage');?>">&nbsp;登录&nbsp;</a>后才可以回复<?php endif; ?>
                    </div>
                    <div class="col-md-2">
                      <?php if(empty($_SESSION['userName'])): ?><button  class="btn btn-primary disabled">回复</button>
                      <?php else: ?>
                      <button  class="btn btn-primary submitMyAnswer">回复</button><?php endif; ?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="right-content">
              <a class="btn btn-success btn-lg btn-block" href="<?php echo U('Ask/index');?>">
	<span class="glyphicon glyphicon-edit"></span>我要提问
</a>
<br>
<div class="panel panel-default">
	<div class="panel-heading">本月热门问题</div>
	<div class="panel-body" style="padding-left:0px;">
		<ul>
			<?php if(is_array($hotList)): foreach($hotList as $key=>$hotQuestion): ?><li class="hot">
				<a href="<?php echo U('Question/questionPage',array('id'=>$hotQuestion['questionId']));?>"><?php echo ($hotQuestion["title"]); ?></a>
			</li><?php endforeach; endif; ?>
		</ul>
	</div>
</div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <script src="/Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/jquery.hotkeys.js"></script>
    <script src="/Public/js/prettify.js"></script>
    <script src="/Public/js/bootstrap-wysiwyg.js"></script>
    <script src="/Public/js/myeditor.js"></script>
    <script src="/Public/js/jquery.form.js"></script>
    <script src="/Public/js/jquery.livequery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
    
    $(".Collect").click(function(){
    $.ajax({
    url:"<?php echo U('Question/collect');?>",
    method:"post",
    dateType:"json",
    data:{
    "questionId":"<?php echo ($question["questionId"]); ?>"
    },
    success: function(data){
    if(data.success){
    $(".collectNum").text(data.count);
    $(".Collect").addClass("disabled");
    }
    }
    });
    });
    $(".submitMyAnswer").click(function(e){
    e.preventDefault();
    $(this).parentsUntil('.myAnswer').find("form").ajaxSubmit({
    
    url: "<?php echo U('Question/submitMyAnswer');?>",
    type:"post",
    dataType:"json",
    
    data:{
    'questionId':"<?php echo ($question["questionId"]); ?>",
    'content':$(".myAnswerContent").html()
    },
    
    success:function(data){
    if(data.success){
    $("#answers").find('ul:first').append(data.html);
    $(".answerNum").text(data.count);
    $(".myAnswerContent").html("");
    }
    }
    
    });
    });
    
    $(".submitSubAnswer").livequery(function(){
    $(this).click(function(e){
    e.preventDefault();
    var answer = $(this).parentsUntil('.answer');
    var answerId = answer.find("form .answerId").val();
    var user_to_id = answer.find("form .user_to_id").val();
    var content = answer.find("form .mySubAnswer").val();
    
    answer.find('form').ajaxSubmit({
    
    url: "<?php echo U('Question/submitSubAnswer');?>",
    type:"post",
    dataType:"json",
    
    data:{
    'answerId':answerId,
    'user_to_id':user_to_id,
    'content':content
    },
    
    success:function(data){
    if(data.success){
    $(".answerNum").text(data.count);
    answer.find('ul').append(data.html);
    answer.find('.subAnswerNum').text(data.subCount);
    answer.find("form .user_to_id").val("");
    answer.find("form .user_to_name").text("");
    answer.find("form .user_to_id").hide();
    answer.find("form .user_to_name").hide();
    answer.find("form .answer_to_label").hide();
    answer.find(".cancel_answer_to").hide();
    answer.find("form .mySubAnswer").val("");
    }
    }
    
    });
    });
    });
    $(".reviewUp").livequery(function(){
    $(this).click(function(){
    var answer = $(this).parentsUntil('.answer');
    var answerId = answer.find("form .answerId").val();
    var reviewUp = answer.find(".reviewUp");
    var reviewDown = answer.find(".reviewDown");
    $.ajax({
    url:"<?php echo U('Question/reviewUp');?>",
    method:'post',
    data: {'answerId':answerId},
    dataType: "json",
    success: function(data){
    if(data.success){
    reviewUp.html('<span class="glyphicon glyphicon-thumbs-up"></span>'+data.count);
    reviewUp.addClass("disabled");
    reviewDown.addClass("disabled");
    }
    }
    });
    });
    });
    $(".reviewDown").livequery(function(){
    $(this).click(function(){
    var answer = $(this).parentsUntil('.answer');
    var answerId = answer.find("form .answerId").val();
    var reviewUp = answer.find(".reviewUp");
    var reviewDown = answer.find(".reviewDown");
    $.ajax({
    url:"<?php echo U('Question/reviewDown');?>",
    method:'post',
    data: {'answerId':answerId},
    dataType: "json",
    success: function(data){
    if(data.success){
    reviewDown.html('<span class="glyphicon glyphicon-thumbs-down"></span>'+data.count);
    reviewUp.addClass("disabled");
    reviewDown.addClass("disabled");
    }
    }
    });
    });
    });
    $(".answer_to").livequery(function(){
    $(this).click(function(){
    var answer = $(this).parentsUntil('.answer');
    
    answer.find("form .answer_to_label").show();
    answer.find("form .user_to_name").show();
    answer.find("form .cancel_answer_to").show();
    var user_to_id = $(this).parent().find(".user_to_id").text();
    var user_to_name = $(this).parent().find(".user_to_name").text();
    answer.find("form .user_to_id").val(user_to_id);
    answer.find("form .user_to_name").text(user_to_name);
    });
    $(".cancel_answer_to").click(function(){
    var answer = $(this).parentsUntil('.answer');
    answer.find("form .user_to_id").val("");
    answer.find("form .user_to_name").text("");
    answer.find("form .user_to_id").hide();
    answer.find("form .user_to_name").hide();
    answer.find("form .answer_to_label").hide();
    $(this).hide();
    });
    });
    $(".subAnswer").livequery(function(){
    $(this).click(function(){
    $('.subAnswer').show();
    $('.hideSubAnswer').hide();
    $('.subAnswerContent').hide();
    var answer = $(this).parentsUntil('.answer');
    answer.find('.subAnswerContent').show();
    answer.find('.hideSubAnswer').show();
    $(this).hide();
    });
    }
    );
    $(".hideSubAnswer").livequery(function(){
    $(this).click(function(){
    $('.subAnswer').show();
    $('.hideSubAnswer').hide();
    $('.subAnswerContent').hide();
    var answer = $(this).parentsUntil('.answer');
    answer.find('.subAnswerContent').hide();
    answer.find('.subAnswer').show();
    $(this).hide();
    });
    });
    }
    );
    </script>
  </body>
</html>