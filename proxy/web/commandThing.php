<?php
function curls($url, $data_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-AjaxPro-Method:ShowList',
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
require_once('../bootstrap.php');
$json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/config.json");
$config = $json->getAll();
if(isset($_GET["words"])){
    $get_url = "https://homebase.rokid.com/trigger/with/".$config["remote_token"];

    $post_str = '{
  "type": "asr",
  "devices": {
    "sn": "'.$config["device_sn"].'"
  },
  "data": {
    "text": "'.$_GET["words"].'"
  }
}';

    $post_datas = curls($get_url, $post_str);

    echo $post_datas;
}
