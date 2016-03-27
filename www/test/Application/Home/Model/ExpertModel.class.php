<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ExpertModel extends RelationModel{
    protected $_link=array(
        'User'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'User',
            'foreign_key'=> 'userId',
        ),
        'Area'=>array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Area',
            'foreign_key'=> 'areaId',
        )
    );

}