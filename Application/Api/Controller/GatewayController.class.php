<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午10:57
 * api项目的网关
 */

namespace Api\Controller;

use Api\Logic\BaseLogic;

class GatewayController extends BaseController {

    protected $method = '';

    protected $params = [];


    /**
     * 1、检查关键信息 时间错 method在不在
     * 2、检查openid 并缓存 student info
     * 3、执行指定的logic方法
     */
    public function route ()
    {

        $this->check();
        
        $method_arr = explode('.', $this->method);
        $logic_name = $method_arr[1];
        $function_name = $method_arr[2];
        $logic = D($logic_name, 'Logic');

        // 对方法的判断
        $result = new BaseLogic();
        if (!method_exists($logic, $function_name)) {
            $this->ajaxReturn($result->setError('无效的API参数'));
        }

        $this->ajaxReturn($logic->{$function_name}());
    }

    private function check ()
    {
        $result = new BaseLogic();

        $this->method = I('method');
        $timestamp = I('timestamp');

        // 检查时间戳
        if (!empty($timestamp)) {
            $offset_time = abs(intval($timestamp) - time());
            if ($offset_time > 600) {
                $this->ajaxReturn($result->setError('失效的时间戳'));
            }
        }

        // 检查logic类 方法
        if (empty($this->method)) {
            $this->ajaxReturn($result->setError('无效的API方法'));
        }

        // 检查应用名称 和 接口合法性
        list($app_name, $logic_name) = explode('.', $this->method);
        if ($app_name !== C('APP_NAME') || !in_array(strtoupper($logic_name), C('API_LIST'))) {
            $this->ajaxReturn($result->setError('无效的API方法'));
        }
        // todo 对方法的判断
    }


}