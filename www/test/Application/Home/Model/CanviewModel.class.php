<?php
namespace Home\Model;
use Think\Model\RelationModel;
class CanviewModel extends RelationModel{
    protected $_link=array(
        'Question'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Question',
            'foreign_key'=> 'questionId',
        ),
        'User'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'User',
            'foreign_key'=> 'userId',
        )
    );

}