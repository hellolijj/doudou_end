<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/21
 * Time: 上午2:25
 */

namespace Home\Controller;
use Think\Controller;


class BaseController extends Controller{

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
    }

    public function index() {
        $per = new Person();
        $this->success();




    }

    protected function ajaxReturn($data, $type = '')
    {
        parent::ajaxReturn($data, $type); // TODO: Change the autogenerated stub
    }
}