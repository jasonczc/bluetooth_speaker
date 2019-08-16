<?php

require_once('../bootstrap.php');
$w = [
    1 => '可回收垃圾',
    2 => '有害垃圾',
    4 => '湿垃圾',
    8 => '干垃圾',
    16 => '大件垃圾',
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

//type: 词典格式
$fc = new \Lizhichao\Word\VicWord('json');
//自动 这种方法最耗时
$ar = $fc->getAutoWord($k[0]);
$ans = findKeyWords($ar);
if($ans!==''&&!is_null($ans)){
    echo $k[0].$ans;
}else{
    echo "我也不知道$k[0]是什么垃圾";
}

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

function findKeyWords($v)
{
    $ww=[
        "1" => '可回收垃圾',
        "2" => '有害垃圾',
        "4" => '湿垃圾',
        "8" => '干垃圾',
        "16" => '大件垃圾'
    ];
    $types = [
        "不锈钢"=>"可回收垃圾",
        "金属"=>"可回收垃圾",
        "合金"=>"可回收垃圾",
        "玻璃"=>"可回收垃圾"
    ];
    $dbms = 'mysql';     //数据库类型
    $host = 'localhost'; //数据库主机名
    $dbName = 'garbage';    //使用的数据库
    $user = 'root';      //数据库连接用户名
    $pass = '';          //对应的密码
    $dsn = "$dbms:host=$host;dbname=$dbName";
    $baseInfo='SELECT * from classify ';
    $flag = false;
    $kk = 0;
    foreach($v as $vv){
        $kk++;
        if(isset($types[$vv[0]])){
            return $vv[0]."类物品有可能是".$types[$vv[0]];
        }
        if($vv[3]){
            if(!$flag){
                $flag = true;
                $baseInfo = $baseInfo . " where ";
            }else{
                $baseInfo = $baseInfo . " and ";
            }
            $baseInfo = $baseInfo . ' name like "%'.$vv[0].'%" ';
        }
    }
    if($kk===0) return;
    $baseInfo = $baseInfo . " limit 3";
    try {
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        /*
        $rows = $dbh->query($baseInfo)->fetchAll(PDO::FETCH_BOTH);
        var_dump($rows);
        */
        $ans = "我觉得你说的可能是,";
        $dbh->query('set names utf8;');
        $a = $dbh->query($baseInfo);
        $r = 0;
        foreach ($a as $row) {
            $ans = $ans . "$row[1],它是" . $ww[$row[2]] . "  ,,";
            $r++;
        }
        if($r!==0) {
            return $ans;
        }else{
            return find1($v);
        }
    } catch (PDOException $e) {
        echo ("Error!: " . $e->getMessage() . "<br/>");
    }
}

function find1($v){
    $ww=[
        "1" => '可回收垃圾',
        "2" => '有害垃圾',
        "4" => '湿垃圾',
        "8" => '干垃圾',
        "16" => '大件垃圾'
    ];
    $dbms = 'mysql';     //数据库类型
    $host = 'localhost'; //数据库主机名
    $dbName = 'garbage';    //使用的数据库
    $user = 'root';      //数据库连接用户名
    $pass = '';          //对应的密码
    $dsn = "$dbms:host=$host;dbname=$dbName";
    $baseInfo='SELECT * from classify ';
    $flag = false;
    foreach($v as $vv){
        if($vv[3]){
            if(!$flag){
                $flag = true;
                $baseInfo = $baseInfo . " where ";
            }else{
                $baseInfo = $baseInfo . " or ";
            }
            $baseInfo = $baseInfo . ' name like "%'.$vv[0].'%" ';
        }
    }
    $baseInfo = $baseInfo . " limit 3";
    try {
        $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        /*
        $rows = $dbh->query($baseInfo)->fetchAll(PDO::FETCH_BOTH);
        var_dump($rows);
        */
        $ans = "我觉得你说的可能是,";
        $dbh->query('set names utf8;');
        $a = $dbh->query($baseInfo);
        $r = 0;
        foreach ($a as $row) {
            $ans = $ans."$row[1],它是".$ww[$row[2]]."   ,,";
            $r++;
        }
        if($r!==0)
            return $ans;
    } catch (PDOException $e) {
        echo ("Error!: " . $e->getMessage() . "<br/>");
    }
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