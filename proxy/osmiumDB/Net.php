<?php
/**
 * Project "Osmium" 2017
 * Author jasonczc
 * net.php
 */
namespace osmiumDB;

use osmiumDB\object\ObjectBase;

abstract class Net extends Database {
    /**
     * @var object
     */
    public $storageObj=null;

    /**
     * @param $obj
     * @return boolean 验证联网对象是否存在
     */
    function hasObj($obj){
        return is_null($this->getObj());
    }

    /**
     * @param $obj
     * @return boolean 此时是否可用
     */
    function testConnectObj(ObjectBase $obj){
        return $obj->verifyConnect();
    }


    /**
     * @return mixed
     */

    public function getObj(){
        return $this->storageObj;
    }


}