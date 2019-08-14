<?php
/**
 * Project "Osmium" 2017-2018
 * Author jasonczc <jasonczc@qq.com>
 * MySQL.php
 * 操作 @MySQLObject 对象且继承 @Net 接口的类
 */
namespace osmiumDB\net;
use osmiumDB\Net;
use osmiumDB\object\MySQLObject;

class MySQL extends Net {

    /**
     * MySQL constructor.
     * @param $address
     * @param $user
     * @param $passwd
     * @param $dbname string 数据库名称
     */
    public function __construct($address,$user,$passwd,$dbname){
        $this->storageObj = new MySQLObject($address,$user,$passwd,$dbname);
        $this->storageObj->init();
    }

    /**
     * 建表操作
     * @param $tablename string 表名
     * @param $data array 键名为id，键值属性
     * @param null $primaryKey string 是否有主键，假如无主键则空
     */
    public function createTable($tablename,$data,$primaryKey = null){
        $cmd = 'CREATE TABLE IF NOT EXISTS '.$tablename.'(';
        $isFirst = true;
        foreach($data as $k=>$v){
            if($isFirst)$isFirst = false;
            else $cmd = $cmd.',';
            $cmd = $cmd.$data[$k].' ';
            $cmd = $cmd.$data[$v];
        }
        if($primaryKey != null){
            $cmd = $cmd.',PRIMARY KEY (`'.$primaryKey.'`)';
        }
        $cmd = $cmd.')';
        $this->storageObj->query($cmd);
    }
}