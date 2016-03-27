<?php
namespace Home\Model;
use Think\Model\RelationModel;
class TaginModel extends RelationModel{
    protected $_link=array(
        'Question'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Question',
            'foreign_key'=> 'questionId',
        ),
        'Area'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Area',
            'foreign_key'=> 'areaId',
        )
    );

}