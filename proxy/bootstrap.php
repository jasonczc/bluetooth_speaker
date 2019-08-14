<?php
/**
 * Created by PhpStorm.
 * User: jasonczc
 * Date: 2019-03-07
 * Time: 13:23
 */

define("SECURITY_BOOT",true);
$file = __DIR__;
define("WEB_ROOT_PATH",$file);
date_default_timezone_set('Asia/Shanghai');

spl_autoload_register(function ($target_name) {
    if(!SECURITY_BOOT) return;
    require_once __DIR__ . "bootstrap.php/" . str_replace("\\","/",$target_name) . ".php";
    });