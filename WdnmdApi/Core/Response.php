<?php


namespace WdnmdApi\Core;


class Response
{

    private static $response;

    public static function init() {
        if(self::$response == null) {
            self::$response = new self;
        }
    }
}