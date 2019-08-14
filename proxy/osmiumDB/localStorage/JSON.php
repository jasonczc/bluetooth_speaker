<?php
/**
 * Project "Osmium" 2017
 * Author jasonczc
 * JSON.php
 */
namespace osmiumDB\localStorage;
use osmiumDB\Local;
use osmiumDB\Database;

class JSON extends Local{
    public $type = Database::JSON;
    /**
     *
     */
    public function setToStorage(){
        $this->storage = json_decode(parent::getSourceFile(),true);
    }

    /**
     * @param bool $async
     * @return mixed
     */
    public function save($async = false){
        try{
            if(!$async){
                file_put_contents($this->file, json_encode($this->storage, JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING));
                return true;
            }
        }catch(\Throwable $e){
            return $e;
        }
        return false;
    }

}