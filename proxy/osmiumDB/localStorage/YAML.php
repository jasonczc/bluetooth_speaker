<?php
/**
 * Project "Osmium" 2017
 * Author jasonczc
 * YAML.php
 */
namespace osmiumDB\localStorage;

use OsmiumDB\Local;
use OsmiumDB\Database;

class YAML extends Local{
    public $type = Database::YAML;
    /**
     *
     */
    public function setToStorage(){
        $this->storage = yaml_parse(self::fixYAMLIndexes(parent::getSourceFile()));
    }
    /**
     * @param $str
     * @return mixed
     */
    public static function fixYAMLIndexes($str){
        return preg_replace("#^([ ]*)([a-zA-Z_]{1}[ ]*)\\:$#m", "$1\"$2\":", $str);
    }

    /**
     * @param bool $async
     * @return mixed
     */
    public function save($async = false){
        try{
            if(!$async){
                file_put_contents($this->file, yaml_emit($this->storage, YAML_UTF8_ENCODING));
                return true;
            }
        }catch(\Throwable $e){
            return $e;
        }
        return false;
    }
}