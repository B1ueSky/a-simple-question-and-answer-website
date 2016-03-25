<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
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
            <div class="left-content">
              <h3><b>发布问题</b></h3>
              <form class="form-horizontal questionForm">
                <div class="form-group">
                  <label for="title" class="col-md-2 control-label">标题</label>
                  <div class="col-md-4">
                    <input type="title" class="form-control" id="title" name="title" placeholder="请用一句话概括您的问题" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label for="editor" class="col-md-2 control-label">内容</label>
                  <div class="col-md-8">
                    <div id="alerts"></div>
                    <div>
                      <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="bold" title="加粗(Ctrl+B)"><i class="icon-bold"></i></a>
                          <a class="btn btn-default" data-edit="italic" title="斜体(Ctrl+I)"><i class="icon-italic"></i></a>
                          <a class="btn btn-default" data-edit="strikethrough" title="删除线"><i class="icon-strikethrough"></i></a>
                          <a class="btn btn-default" data-edit="underline" title="下划线(Ctrl+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="justifyleft" title="左对齐(Ctrl+L)"><i class="icon-align-left"></i></a>
                          <a class="btn btn-default" data-edit="justifycenter" title="居中(Ctrl+E)"><i class="icon-align-center"></i></a>
                          <a class="btn btn-default" data-edit="justifyright" title="右对齐(Ctrl+R)"><i class="icon-align-right"></i></a>
                          <a class="btn btn-default" data-edit="justifyfull" title="两端对齐(Ctrl+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="添加超链接"><i class="icon-link"></i></a>
                          <div class="dropdown-menu input-append">
                            <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                            <button class="btn btn-default" type="button">Add</button>
                          </div>
                          <a class="btn btn-default" data-edit="unlink" title="取消超链接"><i class="icon-cut"></i></a>
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" title="插入图片或直接将图片拖拽至输入框" id="pictureBtn"><i class="icon-picture"></i></a>
                          <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                        </div>
                        <div class="btn-group">
                          <a class="btn btn-default" data-edit="undo" title="撤销(Ctrl+Z)"><i class="icon-undo"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                      </div>
                      <div id="editor">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="score" class="col-md-2 control-label">悬赏分</label>
                  <div class="col-md-4">
                    <input type="score" class="form-control" id="score" name="score" placeholder="悬赏积分不能大于您的可用积分" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label for="label" class="col-md-2 control-label">标签</label>
                  <div class="col-md-4">
                    <input type="label" class="form-control" id="label" name="label" placeholder="多个标签请用半角逗号分隔" required="required">
                  </div>
                </div>
              </form>
              <div class="col-md-offset-5 col-md-4 error askError" style="text-align:right">
                <?php if(empty($_SESSION['userName'])): ?><a href="<?php echo U('Login/loginPage');?>">&nbsp;登录&nbsp;</a>后才可以发布问题<?php endif; ?>
              </div>
              <div class="col-md-2">
                <?php if(empty($_SESSION['userName'])): ?><button class="btn btn-primary disabled">发布</button>
                <?php else: ?>
                <button class="btn btn-primary submitQuestion">发布</button><?php endif; ?>
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