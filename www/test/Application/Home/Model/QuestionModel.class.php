<?php
namespace Home\Model;
use Think\Model\RelationModel;
class QuestionModel extends RelationModel{
    protected $_link=array(
       'User'=>array(
		'mapping_type' => self::BELONGS_TO,
		'class_name' => 'User',
		'foreign_key'=> 'userId',
		),
       'Answer'=>array(
		'mapping_type' => self::HAS_MANY,
		'class_name' => 'Answer',
		'foreign_key'=> 'questionId',
		),

	   'Tagin'=>array(
		   'mapping_type' => self::HAS_MANY,
		   'class_name' => 'Tagin',
		   'foreign_key'=> 'questionId',
	   ),

        'BestAnswer' => array(
        'mapping_type' => self::BELONGS_TO,
		'class_name' => 'Answer',
		'foreign_key'=> 'bestAnswer',
         ),

        'Collect'=>array(
		'mapping_type' => self::HAS_MANY,
		'class_name' => 'Collect',
		'foreign_key'=> 'questionId',
		)
	);
  
}