<?php


namespace WdnmdApi\Core;


class DB
{

    private static $db;

    private $_connect;

    private $_host;
    private $_port;
    private $_user;
    private $_password;

    private $_table;

    /**
     * MySQL constructor.
     * 构造连接信息
     */
    public function __construct()
    {

    }

    public static function init() {

        if(self::$db === null) {
            self::$db = new self;
        }

        $config = File::getConfig('database');

        self::$db->_host = $config['default']['DATABASE_HOST'];
        self::$db->_port = $config['default']['DATABASE_PORT'];
        self::$db->_user = $config['default']['DATABASE_USER'];
        self::$db->_password = $config['default']['DATABASE_PASSWORD'];

        // 连接数据库
        /*$connect = mysqli_connect(self::$db->_host . ':' . self::$db->_port, self::$db->_user, self::$db->_password, self::$db->_table);

        if(!$connect) {
            die('数据库连接失败');
        }*/
    }

    public function getTable() {
        echo self::$db->_table;
    }

    public static function table($tableName) {
        self::$db->_table = $tableName;
        return self::$db;
    }

}