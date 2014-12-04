<?php
namespace Home\Model;
use Think\Model\RelationModel;
class AnswerModel extends RelationModel{
    protected $_link=array(
       'User'=>array(
		'mapping_type' => self::BELONGS_TO,
		'class_name' => 'User',
		'foreign_key'=> 'userId',
		),

        'ReplyUser'=>array(
		'mapping_type' => self::BELONGS_TO,
		'class_name' => 'User',
		'foreign_key'=> 'replyUserId',
		),

        'Question'=>array(
         'mapping_type' => self::BELONGS_TO,
		'class_name' => 'Question',
		'foreign_key'=> 'questionId',
        )
	);
  
}