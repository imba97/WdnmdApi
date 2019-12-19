<?php


namespace WdnmdApi\Core;


use ReflectionMethod;


class Action
{
    public static function init() {
        $controller = Router::getController();
        $action     = Router::getAction();

        $className = $controller . 'Controller';

        $class = new $className;

        if(!method_exists($class, $action)) {
            die('未找到类方法：' . $action);
        }

        $method = new ReflectionMethod($className, $action);
        $parameters = $method->getParameters();

        $param = array();

        foreach($parameters as $p) {
            if(key_exists($p->name, $_REQUEST)) {
                $param[$p->name] = $_REQUEST[$p->name];
            } else {
                $param[$p->name] = '';
            }
        }

        call_user_func_array([$class, $action], $param);
    }


}