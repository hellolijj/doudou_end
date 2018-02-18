<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/16
 * Time: 下午9:42
 */

namespace Api\Logic;

/*
 * userbase 调用此类表示都是已经注册用户
 */
use Api\Service\WeixinService;

class UserBaseLogic extends BaseLogic {

    public function __construct ()
    {
        $check_uid_result = $this->check_uid();
        if ($check_uid_result['success'] === FALSE) {
            echo json_encode($check_uid_result);
            die;
        }
    }

    private function check_uid ()
    {
        $openid = session('openid');
        $weixinService = new WeixinService();
        $weixin_user_result = $weixinService->getByOpenid($openid);
        if ($weixin_user_result['success'] === FALSE) {
            return $weixin_user_result;
        }
        $uid = intval($weixin_user_result['data']['uid']);
        $user_type = intval($weixin_user_result['data']['type']);
        if (!$uid || !$user_type) {
            return ['success' => FALSE, 'message' => '为了不影响你的正常使用请先完善个人信息'];
        }
        session('uid', $uid);
        session('user_type', $user_type);
    }
}
