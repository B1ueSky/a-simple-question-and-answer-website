<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
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
			<a href="<?php echo U('Index/index');?>" class="navbar-brand sitetitle">TeachTalk <span style="font-size:12px"> The best answers, by teachers, for teachers</span></a>
		</div>

		<div class="collapse navbar-collapse" id="mycollaspse">
			<ul class="navbar-nav navbar-left nav">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</ul>
			
			<form id="searchForm" class="navbar-form navbar-left form-inline" method="post">
				<input class="form-control" style="width:170px;" type="text" name="keyword" placeholder="Keyword">
				<span class="input-group">
				<span class="input-group-btn">
				<button class="btn btn-default" id="searchQuestion">
				<span class="glyphicon glyphicon-question-sign" style="color:gray"></span>
				Question</button>
				<button class="btn btn-default" id="searchUser">
				<span class="glyphicon glyphicon-user" style="color:gray">
				</span>User</button>
				</span>
				</span>
			</form>
			<ul class="navbar-nav navbar-right nav">
				
				<?php if(empty($_SESSION['userName'])): ?><li><a id="login" href="<?php echo U('Login/loginPage');?>">Login</a></li>
				<li><a id="register" href="<?php echo U('Register/registerPage');?>"  >Register</a></li>
				<?php else: ?>
				<li>
					<a  href="<?php echo U('UserInfo/index');?>">
						<img src="/Uploads/<?php echo ($_SESSION['icon']); ?>" style="width:24px;height:24px;border-radius: 5px;">
						<?php echo ($_SESSION['userName']); ?>
					</a>
				</li>
				<li>
					<a href="<?php echo U('Login/logout');?>">Log out</a>
				</li><?php endif; ?>
			</ul>
		</div>
	</div>
</nav>
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#searchQuestion").click(function(e){
		e.preventDefault();
		$("#searchForm").attr("action","<?php echo U('Search/searchQuestion');?>");
		$("#searchForm").submit();
	});
	$("#searchUser").click(function(e){
		e.preventDefault();
	$("#searchForm").attr("action","<?php echo U('Search/searchUser');?>");
	$("#searchForm").submit();
	});
});
</script>
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="left-content">
              <h3><b>Ask a question</b></h3>
              <form class="form-horizontal questionForm">
                <div class="form-group">
                  <label for="title" class="col-md-2 control-label">Title</label>
                  <div class="col-md-4">
                    <input type="title" class="form-control" id="title" name="title" placeholder="Enter a one line summary..." required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label for="editor" class="col-md-2 control-label">Details</label>
                  <div class="col-md-8">
                    <div id="alerts"></div>
                    <div>
                      <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="bold" title="Bold(Ctrl+B)"><i class="icon-bold"></i></a>
                          <a class="btn btn-default" data-edit="italic" title="Italic(Ctrl+I)"><i class="icon-italic"></i></a>
                          <a class="btn btn-default" data-edit="strikethrough" title="Strike-through"><i class="icon-strikethrough"></i></a>
                          <a class="btn btn-default" data-edit="underline" title="Underline(Ctrl+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="justifyleft" title="Align left(Ctrl+L)"><i class="icon-align-left"></i></a>
                          <a class="btn btn-default" data-edit="justifycenter" title="Align center(Ctrl+E)"><i class="icon-align-center"></i></a>
                          <a class="btn btn-default" data-edit="justifyright" title="Align right(Ctrl+R)"><i class="icon-align-right"></i></a>
                          <a class="btn btn-default" data-edit="justifyfull" title="Align full(Ctrl+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Add link"><i class="icon-link"></i></a>
                          <div class="dropdown-menu input-append">
                            <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                            <button class="btn btn-default" type="button">Add</button>
                          </div>
                          <a class="btn btn-default" data-edit="unlink" title="Remove link"><i class="icon-cut"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" title="Drag / insert an image" id="pictureBtn"><i class="icon-picture"></i></a>
                          <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="undo" title="Undo(Ctrl+Z)"><i class="icon-undo"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                      </div>
                      <div id="editor">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="score" class="col-md-2 control-label">Price</label>
                  <div class="col-md-4">
                    <input type="score" class="form-control" id="score" name="score" placeholder="Price should be lower than your score." required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Areas</label>
                  <div class="col-md-4">
                    <?php if(is_array($areas)): foreach($areas as $key=>$area): ?><p><input type="checkbox" name="areaList[]" value="<?php echo ($area["areaId"]); ?>"> <?php echo ($area["areaName"]); ?></input></p><?php endforeach; endif; ?>
                  </div>
                </div>
              </form>
              <div class="col-md-offset-5 col-md-4 error askError" style="text-align:right">
                <?php if(empty($_SESSION['userName'])): ?><a href="<?php echo U('Login/loginPage');?>">&nbsp;Login&nbsp;</a>to ask question<?php endif; ?>
              </div>
              <div class="col-md-2">
                <?php if(empty($_SESSION['userName'])): ?><button class="btn btn-primary disabled">Post</button>
                <?php else: ?>
                <button class="btn btn-primary submitQuestion">Post</button><?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="right-content">
              <a class="btn btn-success btn-lg btn-block" href="<?php echo U('Ask/index');?>">
	<span class="glyphicon glyphicon-edit"></span> I have a question
</a>
<br>
<div class="panel panel-default">
	<div class="panel-heading">Monthly trending topic</div>
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
    <script type="text/javascript">
    $(document).ready(function(){
    $(".submitQuestion").click(function(){
    $(".questionForm").ajaxSubmit({
    url: "<?php echo U('Ask:askQuestion');?>",
    type:"post",
    data:{
    "content":$("#editor").html()
    },
    dataType:"json",
    success:function(data){
    if(data != "success"){
    $(".askError").text(data);
    }else{
    location.href="<?php echo U('Index/index');?>";
    }
    }
    });
    });
    });
    </script>
  </body>
</html>