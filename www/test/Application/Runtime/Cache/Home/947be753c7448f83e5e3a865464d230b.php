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
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="left-content">
              <h3 class="page-header">
              <?php if(!empty($keyword)): ?>“<span class="keywordText"><?php echo ($keyword); ?></span>”&nbsp;&nbsp;<?php endif; ?>Search results：
              </h3>
              <ul class="media-list questionList">
                <?php if(is_array($questionList)): foreach($questionList as $key=>$question): ?><li class="media question">
                  <div class="pull-left">
                    <img class="media-object icon-sm" src="/Uploads/<?php echo ($question["User"]["icon"]); ?>">
                    <a href="<?php echo U('UserInfo/index',array('userId'=>$question['User']['userId']));?>" class="userName"><?php echo ($question["User"]["userName"]); ?></a>
                  </div>
                  <div class="media-body">
                    <div class="media-heading">
                      <?php if(($question["solved"] == 1) ): ?><span class="glyphicon glyphicon-ok-sign" style="color:green;font-size: 14px;">[Solved]</span>
                      <?php else: ?>
                      <span class="glyphicon glyphicon-question-sign" style="color:rgb(212, 106, 64);font-size: 14px;">[Waiting]</span><?php endif; ?>
                      <a href="<?php echo U('Question/questionPage',array('id'=>$question['questionId']));?>"><?php echo ($question["title"]); ?></a>
                      <small>[ Price：<?php echo ($question["score"]); ?> ]</small>
                      <span class="pull-right gray"><?php echo ($question["time"]); ?></span>
                    </div>
                    <div class="media-action">
                      <div style="text-indent:10px;">
                        <span class="glyphicon glyphicon-tags"></span>
                        Tags:
                        <?php if(is_array($question["label"])): foreach($question["label"] as $key=>$singleLabel): ?><span class="label myLabel"><?php echo ($singleLabel); ?>
                        </span>
                        &nbsp;<?php endforeach; endif; ?>
                      </div>
                      <div>
                        <span class="pull-right">
                        <span class="glyphicon glyphicon-eye-open gray">Read<?php echo ($question["view"]); ?></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-comment gray">Answer<?php echo (count($question["Answer"])); ?></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-star gray">Favorite<?php echo (count($question["Collect"])); ?></span>
                        </span>
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
  </body>
</html>