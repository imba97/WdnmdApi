<?php


namespace WdnmdApi\Core;


class File
{

    private static $_config;

    public function __construct()
    {

    }

    public static function init() {
        $_config = array();
    }

    /**
     * getConfig 获取配置文件
     * @param string $configFileName 配置文件名
     * @param null|string|array $items 配置项名称
     * @return mixed
     */
    public static function getConfig($configFileName, $items = NULL) {

        if(empty(self::$_config[$configFileName])) {
            self::$_config[$configFileName] = require (__CONFIG__ . DS . $configFileName . '.php');
        }

        $config = self::$_config[$configFileName];

        if($items === NULL) return $config;

        /**
         * 判断类型返回相应的数据
         * string 类型 返回配置中$items字段
         * array 类型 循环获取$items中的值作为$config的键，返回最后一个
         */
        switch (gettype($items)) {
            case 'string' :
                $config = $config[$items];
                break;

            case 'array' :
                foreach ($items as $item) {
                    $config = $config[$item];
                }
                break;
        }

        return $config;
    }

    /**
     * 加载文件 Include
     */
    public static function includeConfig($configFileName) {
        include (__CONFIG__ . DS . $configFileName . '.php');
    }
}