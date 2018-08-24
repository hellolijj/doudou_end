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
        $openid = get_openid();
        if ($openid) {
            return $this->setSuccess(['openid' => $openid], '获取openid成功');
        } else {
            return $this->setError('获取openid失败');
        }
    }
}