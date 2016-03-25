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
                    <div class="col-md-9">
                        <div class="left-content">
                            <h3 class="page-header">
                            <?php if(!empty($keyword)): ?>“<span class="keywordText"><?php echo ($keyword); ?></span>”&nbsp;&nbsp;<?php endif; ?>搜索结果：
                            </h3>
                            <ul class="media-list userList">
                                <?php if(is_array($userList)): foreach($userList as $key=>$user): ?><li class="media user">
                                    <div class="pull-left">
                                        <img class="media-object icon-sm" src="/Uploads/<?php echo ($user["icon"]); ?>">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading" style="text-indent:5px;">
                                            <span class="glyphicon glyphicon-user" style="color:gray"></span>
                                            <a href="<?php echo U('UserInfo/index',array('userId'=>$user['userId']));?>"><b><?php echo ($user["userName"]); ?></b></a>
                                            <span>(<?php echo ($user["email"]); ?>)</span>
                                        </div>
                                        <div class="media-action">
                                            
                                            <div style="text-indent:10px;">
                                                <span>
                                                签名：
                                                <?php if(empty($user["signature"])): ?>TA什么都没写~
                                                <?php else: ?>
                                                <?php echo ($user["signature"]); endif; ?>
                                                </span>
                                            </div>
                                            <div style="text-indent:10px;">
                                                <span>注册时间：<?php echo ($user["registerTime"]); ?></span>
                                                <span style="padding-left:60px;">上次登录：<?php echo ($user["lastLoginTime"]); ?></span>
                                            </div>
                                            <div><p class="gray questionContent" style="text-indent:28px;"><?php echo ($question["content"]); ?></p></div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; ?>
                                <div><?php echo ($page); ?></div>
                            </ul>
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
    </body>
</html>