<?php
namespace Page\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo "page service";
    }

    // 使用帮助页面
    public function help() {
        $contents_url = 'https://mp.weixin.qq.com/s/F9X9NykRfKKA9uZPJEnj9g';
//        echo file_get_contents($contents_url, TRUE);
        redirect($contents_url);
    }
}