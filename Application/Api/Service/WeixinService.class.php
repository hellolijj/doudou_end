<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/28
 * Time: 上午10:37
 */

namespace Api\Service;

class WeixinService extends BaseService {

    public function __construct ()
    {
        parent::__construct();
        $this->recordOpenid();
    }

    /*
     * 如果首次使用平台则记录下其openid
     */
    private function recordOpenid ()
    {
        $openid = $this::$current_user_openid;
        $user_type = $this::$current_user_type;

        if ($openid && $user_type < 0) {
            $data = ['openid' => $openid, 'type' => self::$USER_TYPE_UN_REGISTER,];
            $WEIXIN = D('weixin');
            $WEIXIN->create($data);
            $WEIXIN->add();
        }
    }

    /*
     * 从微信订阅号 根据openid 信息
     */
    private function getWeixinInfoByTecent ()
    {
        // todo
    }


}