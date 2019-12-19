<?php


namespace WdnmdApi\Core;


class Core
{

    // 定义任务方法类型
    const _STATIC = 1;
    const _OBJECT = 2;
    const _SINGLE = 3;

    private static $_controllerList = [];

    // 根据类名正则获取真实路径
    private static $_className;
    private static $_classFilePath;
    private static $_replaceFileName;

    public function __construct()
    {

    }

    public static function init() {

        // 文件名占位符
        self::$_replaceFileName = '{name}';

        /**
         * 命名空间正则表达式
         * WdnmdApi\Core\*.php
         * WdnmdApi\Base\*.php
         * *Controller.php
         */

        self::$_className = array(
            '/WdnmdApi\\\\Core\\\\(.*)/',
            '/WdnmdApi\\\\Base\\\\(.*)/'
        );

        // 命名空间对应的真实路径
        self::$_classFilePath = array(
            __CORE__ . DS . self::$_replaceFileName . '.php',
            __ROOT__ . DS . 'WdnmdApi' . DS . 'Base' . DS . self::$_replaceFileName . '.php'
        );


        spl_autoload_register(['WdnmdApi\Core\Core', 'register']);
    }

    public static function register($className) {
        $path = self::getRealPathByClassName($className);
        if($path) require_once($path);
    }

    public static function listen() {

        // 执行队列没任务
        if(count(self::$_controllerList) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $class 类名
     * @param string $function 方法名
     * @param array $param 参数
     * @param int|null $type 方法类型
     * @param string $location 添加位置 unshift|push
     */
    public static function addTask($class, $function = 'init', $param = [], $type = self::_STATIC, $location = 'push') {

        $task = array(
            'class'     =>  $class,
            'function'  =>  $function,
            'param'     =>  $param,
            'type'      =>  $type
        );

        switch($location) {
            case 'push' :
                array_push(self::$_controllerList, $task);
                break;
            case 'unshift' :
                array_unshift(self::$_controllerList, $task);
                break;
            default :
                array_push(self::$_controllerList, $task);
        }
    }

    public static function doTask() {

        $task = array_shift(self::$_controllerList);

        switch($task['type']) {
            case self::_STATIC :
                $class = '\\WdnmdApi\\Core\\' . $task['class'];
                call_user_func_array([$class, $task['function']], $task['param']);
                break;

            case self::_OBJECT :
                $objectNamespace = '\\WdnmdApi\\Core\\' . $task['class'];
                $class = new $objectNamespace;
                call_user_func_array([$class, $task['function']], $task['param']);
                break;

            case self::_SINGLE :
                $class = '\\WdnmdApi\\Core\\' . $task['class'];
                call_user_func_array([$class, $task['function']], $task['param']);
                break;
        }

        // 如果存在回调函数则执行
        $functionName = $task['class'].'Callback';
        if(method_exists(self::class, $functionName)) {
            self::$functionName();
        }
    }

    public static function clear() {
        self::$_controllerList = [];
    }

    /**
     * 获取类名对应的真实目录
     * @param $className
     * @return array|bool
     */
    private static function getRealPathByClassName($className) {

        // 循环每个命名空间与传过来的进行对比

        foreach (self::$_classFilePath as $key => $value) {

            preg_match(self::$_className[$key], $className, $pregResult);

            if($pregResult === null || !isset($pregResult[1])) {
                continue;
            }

            switch(gettype($value)) {
                case 'array' :
                    foreach($value as $val) {
                        preg_match(self::$_className[$key], $className, $pregResult);
                        $path = str_replace(self::$_replaceFileName, $pregResult[1], $val);
                        if(file_exists($path)) {
                            return $path;
                        }
                    }
                    break;
                case 'string' :
                    preg_match(self::$_className[$key], $className, $pregResult);

                    // 如果除类名其他都相同 说明在此命名空间 则返回对应的真实路径
                    if($pregResult !== null && isset($pregResult[1])) {
                        return str_replace(self::$_replaceFileName, $pregResult[1], $value);
                    }
                    break;
            }

        }



        return false;

    }

    /**
     * 添加类名和对应的真实路径
     * @param $className
     * @param $path
     */
    public static function addClassNamePath($className, $path) {
        if(!in_array($className, self::$_classFilePath)) {
            array_push(self::$_className, $className);
            array_push(self::$_classFilePath, $path);
        }
    }

    /**
     * Router回调函数，Router被加载后会执行这个函数
     * 1. 设置Controller的真实路径
     */
    private static function RouterCallback() {

        // 1. 设置Controller的真实路径
        self::addClassNamePath(
            '/((?:.*)Controller)/',
            __APP__ . DS . Router::getApp() . DS . 'Controller' . DS . self::$_replaceFileName . '.php'
        );
        // ===================================

    }

    /**
     * File回调函数
     * 1. 加载配置中的其他路径信息
     */
    private static function FileCallback() {

        // 1. 加载配置中的其他路径信息
        $filePathConfig = File::getConfig('file', 'classNamePath');
        if(count($filePathConfig) === 0) {
            return false;
        }
        foreach($filePathConfig as $regx => $path) {
            self::addClassNamePath($regx, $path);
        }
        // ===================================
    }
}