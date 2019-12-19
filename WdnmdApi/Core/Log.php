<?php


namespace WdnmdApi\Core;


class Log
{
    /**
     * @var string $_level info|success|error
     */
    static private $_level;

    public function __construct()
    {
        self::$_level = 'info';
    }

    public static function init() {

    }
}