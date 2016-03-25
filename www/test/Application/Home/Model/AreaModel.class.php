<?php
namespace Home\Model;
use Think\Model\RelationModel;
class AreaModel extends RelationModel{
    protected $_link=array(
        'Interest'=>array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'Interest',
            'foreign_key'=> 'areaId',
        )
    );

}