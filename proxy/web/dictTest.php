<?php
/**
 * Created by PhpStorm.
 * User: jasonczc
 * Date: 2019-08-15
 * Time: 15:09
 */
require_once('../bootstrap.php');
//type: 词典格式
$fc = new \Lizhichao\Word\VicWord('igb');
//自动 这种方法最耗时
$ar = $fc->getAutoWord('聚知台是一个及时沟通工具');
var_dump($ar);
