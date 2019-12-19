<?php

/**
 * 路由配置
 */

// 例： Router::all('uri', 'App@Controller/action');

use WdnmdApi\Core\Router;

Router::all('test@id/name/age', 'Home/Index/test');

Router::all('233/1@q', 'Home/Index/test1');