<?php

    require_once('../bootstrap.php');
    $w = [
        1 => '可回收垃圾',
        2 => '有害垃圾',
        4 => '湿垃圾',
        8 => '干垃圾',
        16 => '大件垃圾'
    ];
    $a = [//人机交互情况
        '你' => '我是小垃圾'
    ];
$trigger_camera=["这","帮我看看","帮我看看这","帮忙看看","给我看看","帮忙看看这"];
    $json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/garbage.json");//新建对象
    if (!isset($_POST['sentence'])) {
        echo '我也不知道是什么垃圾';
        exit;
    }
    $k = explode('是', $_POST['sentence']);//处理词库


    if (in_array($k[0],$trigger_camera)){
        echo("我来看看");
        exit;
    }

    if (isset($a[$k[0]])) {//精确搜索，人机交互情况
        echo $a[$k[0]];
        exit;
    }
    foreach ($json->getAll() as $v) {//精确搜索
        if ($v['name'] == $k[0]) {
            echo $k[0] . '是' . $w[$v["categroy"]];
            exit;
        }
    }

//下一步:模糊

    echo '我不知道' . $k[0] . '是什么垃圾';

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

function commandThing($words){
    $json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/config.json");
    $config = $json->getAll();
    if (isset($_GET["words"])) {
        $get_url = "https://homebase.rokid.com/trigger/with/" . $config["remote_token"];

        $post_str = '{
  "type": "asr",
  "devices": {
    "sn": "' . $config["device_sn"] . '"
  },
  "data": {
    "text": "' . $words . '"
  }
}';

        $post_datas = curls($get_url, $post_str);

        echo $post_datas;
    }

}