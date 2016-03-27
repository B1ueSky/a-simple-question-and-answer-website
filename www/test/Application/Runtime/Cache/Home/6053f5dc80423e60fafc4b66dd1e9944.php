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
                            <li class="active">
                                <a href="#basicInfoTab">Account</a>
                            </li>
                            <li>
                                <a href="#infoTab">Edit information</a>
                            </li>
                            <li>
                                <a href="#passwordTab">Change password</a>
                            </li>
                            <li>
                                <a href="#iconTab">Edit photo</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="basicInfoTab">
                            <div class="userInfo">
                                <img src = "/Uploads/<?php echo ($_SESSION['icon']); ?>" class="icon">
                                <div id="editIcon" class="editIcon">Edit photo</div>
                            </div>
                            <div class="infoText">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span> <b><?php echo ($_SESSION['userName']); ?></b>
                                (<?php echo ($_SESSION['email']); ?>)
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" id="editInfo" class="editInfo">Edit information</a>
                                </span>
                                <div id="detail">
                                    <label for="registerTime">Register time:</label>
                                    &nbsp;&nbsp;
                                    <span id="registerTime"><?php echo ($_SESSION['registerTime']); ?></span>
                                    <br/>
                                    <label for="lastLoginTime">Last login:</label>
                                    &nbsp;&nbsp;
                                    <span id="lastLoginTime"><?php echo ($_SESSION['lastLoginTime']); ?></span>
                                    <br/>
                                    <label for="score">Contribution:</label>
                                    &nbsp;&nbsp;
                                    <span id="score"><?php echo ($_SESSION['score']); ?></span>
                                    &nbsp;
                                    <button id="scoreTip" style="outline:none;text-decoration:none;" type="button" class="btn btn-link" data-container="body" data-toggle="popover" data-placement="right"
                                    data-html="true" data-content="How to improve:<ol>
                                        <li>If your answer gets accepted, you will get higher contribution score</li>
                                    </ol>
                                    Why it is important:
                                    <ol>
                                        <li>If your contribution is lower than 10, you can ask 3 question per day</li>
                                        <li>If your contribution is higher than 10, you can ask 5 question per day</li>
                                        <li>You can use your contribution score to pay others to answer your question</li>
                                    </ol>
                                    ">
                                    (Make more credit?)
                                    </button>
                                    <br/>
                                    <label for="signature">Signature:</label>
                                    &nbsp;&nbsp;
                                    <span id="signature">
                                    <?php if(empty($_SESSION['signature'])): ?>Nothing...
                                    <?php else: ?>
                                    <?php echo ($_SESSION['signature']); endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="infoTab">
                            <div>
                                <br/>
                                <br/>
                                <form class="form-horizontal" id="infoForm">
                                    <div class="form-group">
                                        <label for="newUserName" class="col-md-2 control-label">Username</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="newUserName" name="newUserName"placeholder="Username" required="required" value="<?php echo ($_SESSION['userName']); ?>">
                                            <span class="error userNameError"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="newSignature" class="col-md-2 control-label">Signature</label>
                                        <div class="col-md-6">
                                            <textarea ros="3" type="textfield" class="form-control" id="newSignature" name="newSignature" placeholder="Describe yourself..." ><?php echo ($_SESSION['signature']); ?></textarea>
                                            <span class="error signatureError"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-7 col-md-6">
                                            <button id="saveInfo" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane" id="passwordTab">
                            <br/>
                            <form class="form-horizontal" id="passwordForm">
                                <div class="form-group">
                                    <label for="oldPassword" class="col-md-2 control-label">Old password</label>
                                    <div class="col-md-3">
                                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old password" required="required">
                                        <span class="error oldPasswordError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class="col-md-2 control-label">New password</label>
                                    <div class="col-md-3">
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New password" required="required">
                                        <span class="error newPasswordError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmNewPassword" class="col-md-2 control-label">Re-enter new password</label>
                                    <div class="col-md-3">
                                        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Re-enter new password" required="required">
                                        <span class="error confirmNewPasswordError"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button class="btn btn-primary" id="submitNewPassword" >Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="iconTab">
                            <div id="altContent"></div>
                        </div>
                        <div>
                            <ul class="nav nav-tabs">
                                <?php if(($type == 1) or empty($type) ): ?><li class="active">
                                    <?php else: ?>
                                    <li><?php endif; ?>
                                        <a href="<?php echo U('UserInfo/index?type=1');?>">My questions</a>
                                    </li>
                                    <?php if(($type == 2) ): ?><li class="active">
                                        <?php else: ?>
                                        <li><?php endif; ?>
                                            <a href="<?php echo U('UserInfo/index?type=2');?>">My answers</a>
                                        </li>
                                        <?php if(($type == 3) ): ?><li class="active">
                                            <?php else: ?>
                                            <li><?php endif; ?>
                                                <a href="<?php echo U('UserInfo/index?type=3');?>">Others reviews</a>
                                            </li>
                                            <?php if(($type == 4) ): ?><li class="active">
                                                <?php else: ?>
                                                <li><?php endif; ?>
                                                    <a href="<?php echo U('UserInfo/index?type=4');?>">My favorites</a>
                                                </li>
                                <?php if(($type == 5) ): ?><li class="active">
                                        <?php else: ?>
                                    <li><?php endif; ?>
                                <a href="<?php echo U('UserInfo/index?type=5');?>">Interested Areas</a></li>

                                <?php if(($type == 6) ): ?><li class="active">
                                        <?php else: ?>
                                    <li><?php endif; ?>
                                <a href="<?php echo U('UserInfo/index?type=6');?>">Expert Areas</a></li>
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
                                                    Answer:
                                                    <a href="<?php echo U('UserInfo/index',array('userId'=> $answer['ReplyUser']['userId']));?>"><?php echo ($answer["ReplyUser"]["userName"]); ?>
                                                    </a>
                                                    <span class="pull-right gray"><?php echo ($answer["time"]); ?></span>
                                                    <div style="text-indent:28px;"><?php echo ($answer["content"]); ?></div>
                                                </li><?php endforeach; endif; ?>
                                            </ul>
                                        </div>
                                        <div id="replyList">
                                            <ul  style="list-style-type:none">
                                                <?php if(is_array($replyList)): foreach($replyList as $key=>$reply): ?><li class="replyBox">
                                                    <a href="<?php echo U('UserInfo/index',array('userId'=>$reply['User']['userId']));?>"><?php echo ($reply["User"]["userName"]); ?></a>
                                                    Question:
                                                    <a href="<?php echo U('Question/questionPage',array('id'=>$reply['questionId']));?>"><?php echo ($reply["Question"]["title"]); ?></a><br>
                                                    Other's review:
                                                    <span class="pull-right gray"><?php echo ($reply["time"]); ?></span>
                                                    <div style="text-indent:28px;"><?php echo ($reply["content"]); ?></div>
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
                            <?php if(empty($interestList)): else: ?>
                                Interested topics:<?php endif; ?>
                            <ul  style="list-style-type:none">
                                <?php if(is_array($interestList)): foreach($interestList as $key=>$interest): ?><li class="collectBox">
                                        <?php echo ($interest["Area"]["areaName"]); ?>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>

                        <div id="otherInterestedAreaList">
                            <?php if(empty($otherInterestedAreaList)): else: ?>
                                Other topics:<?php endif; ?>
                            <ul  style="list-style-type:none">
                                <?php if(is_array($otherInterestedAreaList)): foreach($otherInterestedAreaList as $key=>$area): ?><li class="collectBox">
                                        <?php echo ($area["areaName"]); ?>
                                        <form class="form-horizontal addInterestForm" action="<?php echo U('UserInfo/saveNewInterestedArea');?>" method="post">
                                            <input type="hidden" name="newAreaId" value="<?php echo ($area["areaId"]); ?>">
                                            <div class="form-group">
                                                <div class="col-md-offset-7 col-md-6">
                                                    <button class="btn btn-primary addInterest">Add to Interested</button>
                                                </div>
                                            </div>
                                        </form>
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
                        <div id="otherExpertAreaList">
                            <?php if(empty($otherExpertAreaList)): else: ?>
                                Other topics:<?php endif; ?>
                            <ul  style="list-style-type:none">
                                <?php if(is_array($otherExpertAreaList)): foreach($otherExpertAreaList as $key=>$area): ?><li class="collectBox">
                                        <form class="form-horizontal" id="addExpertForm" action="<?php echo U('UserInfo/saveNewExpertArea');?>" method="post">
                                            <input type="hidden" name="newAreaId" value="<?php echo ($area["areaId"]); ?>">
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    <?php echo ($area["areaName"]); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="bio" placeholder="Bio on <?php echo ($area["areaName"]); ?>" required="required">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="addExpert" class="btn btn-primary">Add to Expert</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                                        <div><?php echo ($page); ?></div>
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
                        <script src="/Public/js/jquery-2.1.1.min.js"></script>
                        <script src="/Public/js/xiuxiu.js"></script>
                        <script src="/Public/js/bootstrap.min.js"></script>
                        <script src="/Public/js/jquery.form.js"></script>
                        <script type="text/javascript">
                        $(document).ready(function(){
                        xiuxiu.setLaunchVars("customMenu", []);
                        xiuxiu.embedSWF("altContent",5,"600px","430px");
                        //必须为绝对路径。。。忧伤了。。。
                        xiuxiu.setUploadURL("http://www.test.com/<?php echo U('UserInfo/xiuxiuUpload');?>");
                        xiuxiu.onUploadResponse = function (data)
                        {
                        location.reload();
                        //alert("上传响应" + data);
                        //$("#infoTabs a:first").tab('show');
                        }

                        $("#saveInfo").click(function(e){
                        e.preventDefault();
                        $("#infoForm").ajaxSubmit({
                        url: "<?php echo U('UserInfo/saveInfo');?>",
                        type:"post",
                        dataType:"json",
                        success:function(data){
                        if(data =="userNameError"){
                        $(".userNameError").text("Username is required.");
                        return;
                        }
                        if(data=="success"){
                        //修改成功
                        location.reload();
                        }
                        }
                        });
                        });
                        /*
                        $(".addInterest").click(function(e){
                            e.preventDefault();
                            $(".addInterestForm").ajaxSubmit({
                                url: "<?php echo U('UserInfo/saveNewInterestedArea');?>",
                                type:"post",
                                dataType:"json",
                                success:function(data){
                                    if(data=="success"){
                                        //修改成功
                                        location.reload();
                                    }
                                }
                            });
                        });

                        $("#addExpert").click(function(e){
                            e.preventDefault();
                            $("#addExpertForm").ajaxSubmit({
                                url: "<?php echo U('UserInfo/saveNewExpertArea');?>",
                                type:"post",
                                dataType:"json",
                                success:function(data){
                                    if(data=="success"){
                                        //修改成功
                                        location.reload();
                                    }
                                }
                            });
                        });
                         */
                        $("#submitNewPassword").click(function(e){
                        e.preventDefault();
                        $("#passwordForm").ajaxSubmit({
                        url: "<?php echo U('UserInfo/saveNewPassword');?>",
                        type:"post",
                        dataType:"json",
                        success:function(data){
                        $(".oldPasswordError").text("");
                        $(".newPasswordError").text("");
                        $(".confirmNewPasswordError").text("");
                        if(data == "confirmNewPasswordError"){
                        $(".confirmNewPasswordError").text("Password doesn't match.");
                        }
                        if(data == "oldPasswordError"){
                        $(".oldPasswordError").text("Wrong old password.");
                        }
                        if(data == "success"){
                            $("#oldPassword").val("");
                            $("#newPassword").val("");
                            $("#confirmNewPassword").val("");
                        location.reload();
                        }
                        }
                        });
                        });
                        $("#infoTabs a").click(function (e) {
                        window.scrollTo(0,0);
                        $(this).tab('show');
                        });
                        $("#tabs2 a").click(function (e) {
                        $(this).tab('show');
                        });
                        $("#editIcon").click(function(){
                        window.scrollTo(0,0);
                        $("#infoTabs a[href='#iconTab']").tab('show');
                        });
                        $("#editInfo").click(function(){
                        window.scrollTo(0,0);
                        $("#infoTabs a[href='#infoTab']").tab('show');
                        });
                        $("#editPassword").click(function(){
                        window.scrollTo(0,0);
                        $("#infoTabs a[href='#passwordTab']").tab('show');
                        });
                        $("#scoreTip").popover();
                        $("#scoreTip").hover(
                        function(){
                        $('#scoreTip').popover('show')
                        },
                        function(){
                        $('#scoreTip').popover('hide')
                        });
                        }
                        );
                        </script>
                    </body>
                </html>