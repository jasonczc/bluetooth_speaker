<?php
/**
 * Created by PhpStorm.
 * User: jasonczc
 * Date: 2019-08-14
 * Time: 12:06
 */

require_once('../bootstrap.php');
$json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/regInfo.json");
$data = $json->getAll();

if (!isset($data["address"])){
    $data = [
        "address"=>"",
        "lastActive"=>0
    ];
    $json->setAll($data);
    $json->save();
}

