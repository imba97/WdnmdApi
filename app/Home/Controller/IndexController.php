<?php


use WdnmdApi\Base\Controller;


class IndexController extends Controller
{
    public function index() {
        var_dump('页面：Home/Index/index');
    }

    public function test() {
        var_dump('页面：Home/Index/test');
    }

    public function test1($q) {
        echo '<br>';
        echo '<br>';
        var_dump($q);
        echo '<br>';
        echo '<br>';
        var_dump('页面：Home/Index/test1');
    }
}