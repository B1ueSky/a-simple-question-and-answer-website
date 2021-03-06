<?php
/**
 * 语言包配置文件
 */
return array(
    'app_begin'        => array('Behavior\CheckLangBehavior'),   //注意这里，官方的文档解释感觉有误（大家自行分辨），TP3.2.3用Behavior\CheckLang会出错，提示：Class 'Behavior\CheckLang' not found
    'LANG_SWITCH_ON'   => true,      // 开启语言包功能
    'LANG_AUTO_DETECT' => true,    // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'        => 'zh-cn,',         // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l',          // 默认语言切换变量，注意到上面发的链接了么，l=zh-cn，就是在这里定义l这个变量
);