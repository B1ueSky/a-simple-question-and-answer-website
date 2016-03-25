<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
          <div class="col-md-8 col-md-offset-1">
            <div class="left-content">
              <h3><b>注册</b></h3>
              <form class="form-horizontal" action="<?php echo U('Register/register');?>" method="post" role="form">
                <div class="form-group">
                  <label for="email" class="col-md-2 control-label">邮箱</label>
                  <div class="col-md-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="邮箱" required="required" value="<?php echo ($typed['email']); ?>">
                    <span class="error" id="emailError"><?php echo ($error['email']); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="userName" class="col-md-2 control-label">用户名</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="用户名"  required="required" value="<?php echo ($typed['userName']); ?>">
                    <span class="error" id="userNameError"><?php echo ($error['userName']); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="password" class="col-md-2 control-label">密码</label>
                  <div class="col-md-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="密码"  required="required" value="<?php echo ($typed['password']); ?>">
                    <span class="error" id="passwordError"><?php echo ($error['password']); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="rePassword" class="col-md-2 control-label">确认密码</label>
                  <div class="col-md-4">
                    <input type="password" class="form-control" id="rePassword" name="rePassword" placeholder="确认密码"  required="required" value="<?php echo ($typed['rePassword']); ?>">
                    <span class="error" id="rePasswordError"><?php echo ($error['rePassword']); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="verifyText" class="col-md-2 control-label">验证码</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="verifyText" name="verify"  placeholder="验证码" required="required">
                    <img  alt="验证码"  id="verifyImg" src="<?php echo U('Register/createVerify',array());?>">
                    <span class="error" id="verifyError"><?php echo ($verifyError); ?></span>
                    <br><a href="#" id="changeVerify">看不清？换一张</a>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-6 col-md-10">
                    <button id="submit" class="btn btn-primary">注册</button>
                  </div>
                </div>
              </form>
              <div class="loginTip well">
                <h4><b>登录后，您可以：</b></h4>
                <ol>
                  <li>提出问题寻求帮助</li>
                  <li>参与问题的讨论和回复</li>
                  <li>收藏有价值的问题</li>
                </ol>
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
    <script type="text/javascript">
    $(document).ready(
    function(){
    var verifySrc = $("#verifyImg").attr("src");
    $("#changeVerify").click(function(){
    if( verifySrc.indexOf('?')>0){
    $("#verifyImg").attr("src", verifySrc+'&random='+Math.random());
    }else{
    $("#verifyImg").attr("src", verifySrc.replace(/\?.*$/,'')+'?'+Math.random());
    }
    }
    );
    }
    );
    </script>
  </body>
</html>