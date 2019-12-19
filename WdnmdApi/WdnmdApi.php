<?php

/*
 *
 *                          _ooOoo_
 *                         o8888888o
 *                         88" . "88
 *                         (| -_- |)
 *                         O\  =  /O
 *                       ____/`---'\____
 *                    .'  \\|     |//  `.
 *                   /  \\|||  :  |||//  \
 *                  /  _||||| -:- |||||-  \
 *                  |   | \\\  -  /// |   |
 *                  | \_|  '' \-/ ''  |   |
 *                  \  .-\__  `-`  ___/-. /
 *                  __`. .'  /-.-\  `. . __
 *             ."" '<  `.___\_<|>_/___.'  >'"".
 *            | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *            \  \ `-.   \_ __\ /__ _/   .-` /  /
 *       ======`-.____`-.___\_____/___.-`____.-'======
 *                           `=-='
 *
 *       .............................................
 *                佛祖保佑             永无BUG
 *        佛曰:
 *                写字楼里写字间，写字间里程序员；
 *                程序人员写程序，又拿程序换酒钱。
 *                酒醒只在网上坐，酒醉还来网下眠；
 *                酒醉酒醒日复日，网上网下年复年。
 *                但愿老死电脑间，不愿鞠躬老板前；
 *                奔驰宝马贵者趣，公交自行程序员。
 *                别人笑我忒疯癫，我笑自己命太贱；
 *                不见满街漂亮妹，哪个归得程序员？
 *
 */


// 加载Core
require_once '../WdnmdApi/Core/Core.php';

// 加载通用函数
require_once ('../WdnmdApi/Function.php');


use WdnmdApi\Core\Core;

/**
 * 常量定义
 */

// 路径分隔符
define('DS', DIRECTORY_SEPARATOR);
// 程序主目录
define('__ROOT__', realpath('../'));
// 核心目录
define('__CORE__', __ROOT__ . DS . 'WdnmdApi' . DS . 'Core');
// APP目录
define('__APP__', __ROOT__ . DS . 'app');
// 配置文件
define('__CONFIG__', __ROOT__ . DS . 'config');
// 控制器
define('__CTRL__', __APP__ . DS . 'Home' . DS . 'Controller');


/**
 * 初始化
 */

// 初始化Core
Core::init();

// 加载其他核心文件
Core::addTask('File');          // 文件操作类
Core::addTask('Request');       // 请求
Core::addTask('Router');        // 路由
Core::addTask('Action');        // 控制器
Core::addTask('Response');      // 响应
Core::addTask('Log');           // 日志

// 循环加载
while(Core::listen()) {
    Core::doTask();
}