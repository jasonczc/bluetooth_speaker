<?php
/**
 * Created by PhpStorm.
 * User: jasonczc
 * Date: 2019-08-14
 * Time: 17:15
 */

require_once('../bootstrap.php');
const NOW_VERSION = 1;


$json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/config.json",
    function($that){
        $defaultConfig = [
            "remote_token"=>'',
            "device_sn"=>'',
            "reg_info"=>[
                "address"=>"",
                "lastActive"=>0
            ],
            "version"=>NOW_VERSION
        ];
    if(!isset($that->getAll()["version"])){
        $that->setAll($defaultConfig);
        $that->save();
        echo "创建成功";
    }else{
        if($that->getAll()["version"] < NOW_VERSION){
            echo "版本较旧";
        }else{
            echo "版本已经是最新，不进行创建";
        }
    }
    }
    );