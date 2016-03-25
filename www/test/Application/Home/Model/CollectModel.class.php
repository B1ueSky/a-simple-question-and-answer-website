<?php
namespace Home\Model;
use Think\Model\RelationModel;
class CollectModel extends RelationModel{
    protected $_link=array(
       'User'=>array(
		'mapping_type' => self::BELONGS_TO,
		'class_name' => 'User',
		'foreign_key'=> 'userId',
		),
        'Question'=>array(
         'mapping_type' => self::BELONGS_TO,
		'class_name' => 'Question',
		'foreign_key'=> 'questionId',
        )
	);
  
}