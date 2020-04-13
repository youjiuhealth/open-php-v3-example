<?php
class Cache{
    //静态缓存文件后缀名
    const EXT = 'txt';
    //定义缓存文件存放路径
    private $_dir;
    public function __construct(){
        $this->_dir = dirname(__FILE__).'/cache/';
    }

    /**
     * 存储/读取缓存
     * @param $k
     * @param string $v
     * @param string $expires
     * @param string $path
     * @return bool|int|mixed
     */
    public function cacheData($k,$v = '',$expires='',$path = ''){
        //文件名
        $filename = $this->_dir.$path.$k.'.'.self::EXT;


        //$v不为空：存储缓存或者删除缓存
        if($v !== ''){

            //删除缓存
            if(is_null($v)){
                return @unlink($filename);
            }

            //存储缓存
            $dir = dirname($filename);
            if(!is_dir($dir)){
                mkdir($dir,0777);
            }

            $expires_in = null;
            if($expires){
                $expires_in = time() + $expires;
            }

            //把$v转成string类型
            return file_put_contents($filename,json_encode([
                'expires_in'    => $expires_in,
                'v' => $v
            ]));
        }

        //读取缓存
        if(!is_file($filename)){
            return false;
        }else{
            $data = json_decode(file_get_contents($filename),true);
            if( $data['expires_in'] && $data['expires_in']>time() ){
                return $data['v'];
            }
            return false;
        }
    }
}