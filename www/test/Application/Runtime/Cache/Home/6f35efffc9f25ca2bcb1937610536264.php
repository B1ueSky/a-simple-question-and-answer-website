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
        <div class="container">
            <nav class="navbar-default navbar-fixed-top navbar">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a href="<?php echo U('Index/index');?>" class="navbar-brand sitetitle">Q&A <span style="font-size:12px"> 一个简单的问答网站</span></a>
		</div>
		
		<div class="collapse navbar-collapse">
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
<script src="/Public/js/bootstrap.min.js"></script>
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
            <div class="row">
                <div class="col-md-9">
                    <div>
                        <ul class="nav nav-tabs" id="infoTabs">
                            <li class="active"><a>基本信息</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="basicInfoTab">
                            <div class="userInfo">
                                <img src = "/Uploads/<?php echo ($other['icon']); ?>" class="icon">
                            </div>
                            <div class="infoText">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span><b><?php echo ($other['userName']); ?></b>(<?php echo ($other['email']); ?>)</span>
                                <div id="detail">
                                    <label for="registerTime">注册时间:</label>
                                    &nbsp;&nbsp;
                                    <span id="registerTime"><?php echo ($other['registerTime']); ?></span><br/>
                                    <label for="lastLoginTime">上次登录:</label>
                                    &nbsp;&nbsp;
                                    <span id="lastLoginTime"><?php echo ($other['lastLoginTime']); ?></span><br/>
                                    <label for="score">积分: </label>
                                    &nbsp;&nbsp;
                                    <span id="score"><?php echo ($other['score']); ?></span>
                                    &nbsp;
                                    <br/>
                                    <label for="signature">签名: </label>
                                    &nbsp;&nbsp;
                                    <span id="signature">
                                    <?php if(empty($other['signature'])): ?>TA什么都没有写哦~
                                    <?php else: ?>
                                    <?php echo ($other['signature']); endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="nav nav-tabs">
                            <?php if(($type == 1) or empty($type) ): ?><li class="active">
                                <?php else: ?>
                                <li><?php endif; ?>
                                    <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>1));?>">TA的提问</a></li>
                                    <?php if(($type == 2) ): ?><li class="active">
                                        <?php else: ?>
                                        <li><?php endif; ?>
                                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>2));?>">TA的回答</a></li>
                                            <?php if(($type == 4) ): ?><li class="active">
                                                <?php else: ?>
                                                <li><?php endif; ?>
                                                    <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>4));?>">TA的收藏</a></li>
                                                </ul>
                                            </div>
                                            <div id="askList">
                                                <ul  style="list-style-type:none">
                                                    <?php if(is_array($askList)): foreach($askList as $key=>$ask): ?><li class="askBox">
                                                        发布了问题：
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$ask['questionId']));?>"><?php echo ($ask["title"]); ?></a>
                                                        <span class="pull-right gray"><?php echo ($ask["time"]); ?></span>
                                                    </li><?php endforeach; endif; ?>
                                                </ul>
                                                
                                            </div>
                                            <div id="answerList">
                                                <ul  style="list-style-type:none">
                                                    <?php if(is_array($answerList)): foreach($answerList as $key=>$answer): ?><li class="answerBox">
                                                        在问题
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$answer['questionId']));?>"><?php echo ($answer["Question"]["title"]); ?></a>
                                                        中回复
                                                        <a href="<?php echo U('UserInfo/index',array('userId'=>$answer['ReplyUser']['userId']));?>"><?php echo ($answer["ReplyUser"]["userName"]); ?></a>
                                                        <span class="pull-right gray"><?php echo ($answer["time"]); ?></span>
                                                        <div style="text-indent:28px;">
                                                            <?php echo ($answer["content"]); ?>
                                                        </div>
                                                    </li><?php endforeach; endif; ?>
                                                </ul>
                                            </div>
                                            <div id="collectionList">
                                                <ul  style="list-style-type:none">
                                                    <?php if(is_array($collectionList)): foreach($collectionList as $key=>$collection): ?><li class="collectBox">
                                                        收藏了问题：
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$collection['questionId']));?>"><?php echo ($collection["Question"]["title"]); ?></a>
                                                        <span class="pull-right gray"><?php echo ($collection["time"]); ?></span>
                                                    </li><?php endforeach; endif; ?>
                                                </ul>
                                            </div>
                                            <div><?php echo ($page); ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="right-content">
                                                <a class="btn btn-success btn-lg btn-block" href="<?php echo U('Ask/index');?>">
	<span class="glyphicon glyphicon-edit"></span>我要提问
</a>
<br>
<div class="panel panel-default">
	<div class="panel-heading">本月热门问题</div>
	<div class="panel-body">
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
                                <script src="/Public/js/jquery-2.1.1.min.js"></script>
                                <script src="/Public/js/bootstrap.min.js"></script>
                            </body>
                        </html>