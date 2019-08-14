<?php
/**
 * Author jasonczc
 * 用于不支持魔法函数特性的php环境
 */

namespace osmiumDB;


class SimpleClassLoader{
    /**
     * @param $path
     * @param bool $willFindRoot
     * @return bool isSucceed
     */
    public function readPath($path,$willFindRoot = false)
    {
        if (!is_dir($path)) return false;
        $path = $this->transFormDic($path);
        $files = scandir($path);
        unset($files[0], $files[1]);
        foreach ($files as $v) {
            if (is_dir($path . $v)) {
                if ($willFindRoot) {
                    $this->readPath($this->transFormDic($path . $v), true);
                }
            } else {
                if (strtolower($this->getFileType($v)) == 'php') require_once $path . $v;
            }
        }
        return true;
    }

    /**
     * @param $path
     * @return string
     */
    public function transFormDic($path){
        $var = trim($path);
        $len = strlen($var) - 1;
        $end = $var($len);
        if($end == DIRECTORY_SEPARATOR) return $path;
        return $path.DIRECTORY_SEPARATOR;
    }

    /**
     * @param $file filename
     * @return bool|string
     */
    public function getFileType($file){
        return substr(strrchr($file,'.'),1);
    }
}