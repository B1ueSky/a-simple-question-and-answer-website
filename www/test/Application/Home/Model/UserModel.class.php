<?php
namespace Home\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel {

	protected $patchValidate = true;

	protected $_validate = array(
		array('email','require','Email address is required'),
		array('email','','Someone else used this email address',0,'unique',1),
		array('email','email','Wrong format'),
		array('rePassword','password','They are not the same password',0,'confirm'),
		array('password','require','You need a password')
		);
	protected $_auto = array(
		array('registerTime','time',1,'function'),
		);

}