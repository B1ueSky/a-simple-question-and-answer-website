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
				<input class="form-control" style="width:280px;" type="text" name="keyword" placeholder="Keyword">
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
            <div class="row">
                <div class="col-md-9">
                    <div>
                        <ul class="nav nav-tabs" id="infoTabs">
                            <li class="active"><a>Profile</a></li>
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
                                    <label for="registerTime">Register time:</label>
                                    &nbsp;&nbsp;
                                    <span id="registerTime"><?php echo ($other['registerTime']); ?></span><br/>
                                    <label for="lastLoginTime">Last login:</label>
                                    &nbsp;&nbsp;
                                    <span id="lastLoginTime"><?php echo ($other['lastLoginTime']); ?></span><br/>
                                    <label for="score">Contribution: </label>
                                    &nbsp;&nbsp;
                                    <span id="score"><?php echo ($other['score']); ?></span>
                                    &nbsp;
                                    <br/>
                                    <label for="signature">Signature: </label>
                                    &nbsp;&nbsp;
                                    <span id="signature">
                                    <?php if(empty($other['signature'])): ?>Nothing...
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
                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>1));?>">Questions</a></li>

                            <?php if(($type == 2) ): ?><li class="active">
                            <?php else: ?>
                                <li><?php endif; ?>
                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>2));?>">Answers</a></li>

                            <?php if(($type == 4) ): ?><li class="active">
                            <?php else: ?>
                                <li><?php endif; ?>
                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>4));?>">Favorites</a></li>

                            <?php if(($type == 5) ): ?><li class="active">
                            <?php else: ?>
                                <li><?php endif; ?>
                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>5));?>">Interested Areas</a></li>

                            <?php if(($type == 6) ): ?><li class="active">
                                    <?php else: ?>
                                <li><?php endif; ?>
                            <a href="<?php echo U('UserInfo/index',array('userId'=>$other['userId'],'type'=>6));?>">Expert Areas</a></li>
                        </ul>

                                            </div>
                                            <div id="askList">
                                                <ul  style="list-style-type:none">
                                                    <?php if(is_array($askList)): foreach($askList as $key=>$ask): ?><li class="askBox">
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$ask['questionId']));?>"><?php echo ($ask["title"]); ?></a>
                                                        <span class="pull-right gray"><?php echo ($ask["time"]); ?></span>
                                                    </li><?php endforeach; endif; ?>
                                                </ul>
                                                
                                            </div>
                                            <div id="answerList">
                                                <ul  style="list-style-type:none">
                                                    <?php if(is_array($answerList)): foreach($answerList as $key=>$answer): ?><li class="answerBox">
                                                        Question:
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$answer['questionId']));?>"><?php echo ($answer["Question"]["title"]); ?></a><br>
                                                        Reply:
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
                                                        <a href="<?php echo U('Question/questionPage',array('id'=>$collection['questionId']));?>"><?php echo ($collection["Question"]["title"]); ?></a>
                                                        <span class="pull-right gray"><?php echo ($collection["time"]); ?></span>
                                                    </li><?php endforeach; endif; ?>
                                                </ul>
                                            </div>
                    <div id="interestList">
                        <ul  style="list-style-type:none">
                            <?php if(is_array($interestList)): foreach($interestList as $key=>$interest): ?><li class="collectBox">
                                    <a href="#"><?php echo ($interest["Area"]["areaName"]); ?></a>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>

                    <div id="expertList">
                        <ul  style="list-style-type:none">
                            <?php if(is_array($expertList)): foreach($expertList as $key=>$expert): ?><li class="collectBox">
                                    <a href="#"><?php echo ($expert["Area"]["areaName"]); ?></a>
                                    <span class="pull-right gray"><?php echo ($expert["bio"]); ?></span>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                                            <div><?php echo ($page); ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="right-content">
                                                <a class="btn btn-success btn-lg btn-block" href="<?php echo U('Ask/index');?>">
	<span class="glyphicon glyphicon-edit"></span>I have a question
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
                                <script src="/Public/js/jquery-2.1.1.min.js"></script>
                                <script src="/Public/js/bootstrap.min.js"></script>
                            </body>
                        </html>