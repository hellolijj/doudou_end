<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/3
 * Time: 下午3:08
 */

namespace Api\Logic;


class WeixinLogic extends BaseLogic {

    public function __construct ()
    {
    }

    public function getOpenid ()
    {
        $openid = session('openid');
        if ($openid) {
            $this->ajaxReturn(['success' => TRUE, 'data' => $openid]);
        } else {
            $this->ajaxReturn(['success' => FALSE, 'data' => NULL]);
        }
    }
}