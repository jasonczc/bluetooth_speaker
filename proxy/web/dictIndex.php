<?php
/**
 * Created by PhpStorm.
 * User: jasonczc
 * Date: 2019-08-15
 * Time: 16:22
 */
//目前可支持 igb 和 json 两种词典库格式；igb需要安装igbinary扩展，igb文件小，加载快
require_once('../bootstrap.php');
$dict = new \Lizhichao\Word\VicDict('json');

//添加词语词库 add(词语,词性) 不分语言，可以是utf-8编码的任何字符
$dict->add('金属','1');
$dict->add('不锈钢','2');

//保存词库
$dict->save();