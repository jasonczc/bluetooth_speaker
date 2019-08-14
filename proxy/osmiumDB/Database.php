<?php
/**
 * Project "Osmium" 2017
 * Author jasonczc
 * Database.php
 */
namespace osmiumDB;

abstract class Database{
    const SQLLITE = 0;
    const YAML = 1;
    const JSON = 2;
    const ENUM = 3;
    const SERIALIZED = 4;
    const PROPERTISE = 5;
    const MySQL = 10;
    const Redis = 11;

    public $type = Database::YAML;


    /**
     * @param $value
     * @return boolean
     */
    //abstract protected function setAll($value);


    /**
     * @param $type
     * @return bool
     */
    /*  public function setDatabaseType($type){
          switch($type){
              case DataBase::SQLLITE:
              case DataBase::YAML:
              case DataBase::JSON:
              case DataBase::MySQL:
              case DataBase::Redis:
                  $this->type = $type;
                  return true;
                  break;
              default:
                  return false;
          }
      }
    */

    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }
}