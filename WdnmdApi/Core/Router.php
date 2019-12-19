<?php


namespace WdnmdApi\Core;

class Router {

    public static $router;

    private $app;
    private $controller;
    private $action;
    private $parameters;

    private function __construct() {

    }

    public static function init() {

        if(!self::$router) {
            self::$router = new self();
        }

        self::$router->parameters   = NULL;

        // 设置路由
        self::$router->setRouter();
    }

    private function setRouter() {

        // 设置注入式路由
        File::includeConfig('route');

        if($this->app !== null && $this->controller !== null && $this->action !== null) {
            return true;
        }

        // 设置响应式路由
        $this->responsiveRoute();

    }

    public static function getApp() {
        return self::$router->app;
    }

    public static function getController() {
        return self::$router->controller;
    }

    public static function getAction() {
        return self::$router->action;
    }

    private function responsiveRoute() {
        if(!isset($_GET['WdnmdApiUri']) || empty($_GET['WdnmdApiUri']) || count($_GET['WdnmdApiUri']) === 0) return false;

        $WdnmdApiUri = explode('/', $_GET['WdnmdApiUri']);

        $actionConfig = File::getConfig('action');

        $this->app = isset($WdnmdApiUri[0]) ? $WdnmdApiUri[0] : $actionConfig['default_app'];
        $this->controller = isset($WdnmdApiUri[1]) ? $WdnmdApiUri[1] : $actionConfig['default_controller'];
        $this->action = isset($WdnmdApiUri[3]) ? $WdnmdApiUri[2] : $actionConfig['default_action'];

    }

    public static function all($uri, $pathOrCallback)
    {

        $exp_uri = explode('@', $uri);

        if(isset($exp_uri[1])) {
            self::$router->parameters = explode('/', $exp_uri[1]);
        }

        $current_uri = Request::getUri();

        $current_uri_param = str_replace($exp_uri[0], '', $current_uri);

        $preg_str = str_replace('/', '\\/', $exp_uri[0]);

        preg_match("/^($preg_str)(?:\/(.*))?/", $current_uri, $match_uri);

        if(empty($match_uri) || !isset($match_uri[2])) {
            return false;
        }

        $exp_match_rui = explode('/', ltrim($current_uri_param, '/'));
        $exp_match_rui_num = count($exp_match_rui);

        var_dump($exp_match_rui);

        if(!preg_match("/^$preg_str(\/.*?){" . $exp_match_rui_num . "}/", $current_uri)) {
            return false;
        }

        if(self::$router->parameters !== NULL) {
            foreach(self::$router->parameters as $index => $value) {
                if(!isset($exp_match_rui[$index])) {
                    die('找不到变量 ' . $value . ' 的值');
                }
                $_REQUEST[$value] = $exp_match_rui[$index];
            }
        }

        if($match_uri[1] === Request::getUri()) {
            return false;
        }

        switch (gettype($pathOrCallback)) {
            case 'string' :
                preg_match('/^([A-Za-z0-9]+)\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)/', $pathOrCallback, $match);
                var_dump($match);
                Router::$router->app = $match[1];
                Router::$router->controller = $match[2];
                Router::$router->action = $match[3];
                break;

            case 'array' :

                break;

            case 'object' :
                $pathOrCallback();
                break;
        }
    }
}