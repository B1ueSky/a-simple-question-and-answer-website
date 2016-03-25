<?php
namespace Home\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel {

	protected $patchValidate = true;

	protected $_validate = array(
		array('email','require','必须填写邮箱'),
		array('email','','邮箱已被注册',0,'unique',1), 
		array('email','email','邮箱格式不合法'),
		array('rePassword','password','确认密码不正确',0,'confirm'), 
		array('password','require','密码不能为空')
		);
	protected $_auto = array(
		array('registerTime','time',1,'function'),
		);

}