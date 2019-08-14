<?php
/**
 * Project "Osmium" 2017
 * Author jasonczc
 * Local.php
 */

namespace osmiumDB;

abstract class Local extends Database{
    /**
     * @var string
     */
    public $file;//local file
    public $storage;
    public $default = null;


    /**
     * @return string
     */
    public function getSourceFile(){
        return file_get_contents($this->file);
    }


    /**
     * Local constructor.
     * @param $file
     * @param null $func 匿名函数，提供整个对象，可空
     * @param null $default 默认的数组内容,假如不为空则覆盖匿名函数提供内容
     */
    public function __construct($file,$func = null,$default = null){
        $this->file = $file;
        $this->setToStorage();
        if($this->isNewFile()){
            if($func !== null) call_user_func($func,$this);
            if($default !== null){
                $this->storage = $default;
                $this->save();
            }
        }
    }

    /**
     * @return boolean
     */
    abstract function save();

    abstract function setToStorage();
    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        if(isset($this->storage[$key])){
            return $this->storage[$key];
        }else{
            return null;
        }
    }

    public function getAll(){
        return $this->storage;
    }
    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value){
        $this->storage[$key] = $value;
        return true;
    }

    /**
     * @param $v
     * @return bool
     */
    public function setAll($v){
        $this->storage = $v;
        return true;
    }

    /**
     * @param $v
     * @return bool
     */
    public function coverAll($v){
        foreach($v as $k=>$v1){
            $this->storage[$k] = $v1;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getFile(){
        return $this->file;
    }

    public function isNewFile(){
        if($this->getSourceFile() !== "") return true;
        return false;
    }

}