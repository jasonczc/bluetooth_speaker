<?php
/**
 * Project "Osmium" 2017-2018
 * Author jasonczc <jasonczc@qq.com>
 * MySQLObject.php
 * MYSQL模型,封装mysqli进行操作
 */

namespace osmiumDB\object;


class MySQLObject extends ObjectBase {

    private $object=null;//mysqli对象
    private $address;//地址
    private $user;//用户名
    private $passwd;//密码
    private $dbname;//数据库名称

    public function __construct($address,$user,$passwd,$dbname){//构建操作，初始化数据库信息
        $this->address = $address;
        $this->user = $user;
        $this->passwd = $passwd;
        $this->dbname = $dbname;
    }

    /**
     * 初始化函数，返回值表示是否连接成功
     * @return bool 是否连接成功
     */
    public function init(){
        $this->object = new \mysqli($this->address,$this->user,$this->passwd,$this->dbname);
        if(mysqli_connect_errno()) {
            echo mysqli_connect_error();
            return false;
        }
        return true;
    }

    /**
     * 可以输入数组进行多条执行，当然返回也会返回多个值
     * @param $command string/array
     * @return mixed string当输入类型为string时/array当输入类型为array时
     */
    public function query($command){
        if(is_array($command)){//如果是数组
            foreach($command as $k=>$v){
                $result[$k] = $this->object->query($v);
            }
        }else{
            $result = $this->object->query($command);
        }
        return $result;
    }

    /**
     * 检查当前mysql连接的可用性
     * @return bool 是否断开，加入断开则重新连接
     */
    public function verifyConnect(){
        return mysqli_ping($this->object);
    }
}