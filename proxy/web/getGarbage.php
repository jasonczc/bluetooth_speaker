<?php

    require_once('../bootstrap.php');
    $w = [
        1 => '可回收垃圾',
        2 => '有害垃圾',
        4 => '湿垃圾',
        8 => '干垃圾',
        16 => '大件垃圾'
    ];
    $a = [
        '你' => '我是小垃圾'
    ];
    $json = new OsmiumDB\LocalStorage\JSON(__DIR__ . "/garbage.json");//新建对象
    if (!isset($_POST['sentence'])) {
        echo '我也不知道是什么垃圾';
        exit;
    }
    $k = explode('是', $_POST['sentence']);
    if (isset($a[$k[0]])) {
        echo $a[$k[0]];
        exit;
    }
    foreach ($json->getAll() as $v) {
        if ($v['name'] == $k[0]) {
            echo $k[0] . '是' . $w[$v["categroy"]];
            exit;
        }
    }

    echo '我不知道' . $k[0] . '是什么垃圾';
    //下一步:模糊