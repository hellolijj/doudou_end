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
        $contents_url = 'https://mp.weixin.qq.com/s/afxA7ZvpI_VFQUrhaZuC9Q';
        echo file_get_contents($contents_url);
    }
}