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

    protected $secret_key = 'L39e5e2OdI3e542Aa1Cb9cb80ef';
    protected $session_uid = 0;
    protected $session_openid = 0;
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

        $logic = D($logic_name, 'logic');

        // 对方法的判断
        $result = new BaseLogic();
        if (!method_exists($logic, $function_name)) {
            $this->ajaxReturn($result->setError('无效的API参数'));
        }
        // 处理openid uid
        $this->dealOpenidOrUid();

        $this->ajaxReturn($logic->{$function_name}());
    }

    private function check ()
    {
        $result = new BaseLogic();

        $this->method = I('method');
        $this->session_openid = I('openid');
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

    /**
     * 1、对openid uid 进行检查
     * 2、看userinfo在不在memchche上
     * 3、如果 userinfo 在memcache上 就继续。如果不在memcache则添加缓存
     * 4、如果openid 不在平台上，则添加到平台。
     */
    private function dealOpenidOrUid ()
    {
        $result = new BaseLogic();
        // 判断uid openid
        $uid = I('uid') ? I('uid') : session('uid');
        $openid = I('openid') ? I('openid') : session('openid');
        if (empty($openid) && empty($openid)) {
            $this->ajaxReturn($result->setError('无效的API参数'));
        }
        // update session
        if (I('uid') && I('uid') != session('uid')) {
            session('uid', $uid);
        }
        if (I('openid') && I('openid') != session('openid')) {
            session('openid', $openid);
        }

        // 对微信uid的判断
        /*$cache_key = 'user_info_by_uid_'.$uid;
        $cache_value = json_decode(S($cache_key));
        if (empty($cache_value->user_info)) {
            // 判断是否注册
            var_dump($openid);
            var_dump(weixinService::$current_user_openid);

            echo WeixinService::$current_user_openid; die;
            if (is_register()) {
                // todo add 缓存
            } else {
                // todo 是否在weixin 表中有记录
                if (is_passer()){
                    // todo 添加微信表 中记录
                }

                // todo 提示你还没有注册
            }
        }*/

    }

}