<?php


namespace WdnmdApi\Core;


class Request
{

    private static $request;

    private $method;
    private $host;
    private $uri;

    public static function init() {

        if(self::$request === null) {
            self::$request = new self;
        }

        self::$request->method = strtolower($_SERVER['REQUEST_METHOD']);
        self::$request->host = $_SERVER['HTTP_HOST'];
        self::$request->uri = ltrim($_SERVER['REQUEST_URI'], '/');

    }

    public static function getUri() {
        return self::$request->uri;
    }
}