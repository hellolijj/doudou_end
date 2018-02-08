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

    /*
     * be a student
     */
    public function BeStudent ($openid, $uid)
    {
        if (!$openid || !$uid) {
            return FALSE;
        }
        $data = ['openid' => $openid, 'uid' => $uid, 'type' => BaseService::$USER_TYPE_STUDENT,];
        $Weixin = D('Weixin');
        if (!$Weixin->where(['openid' => $openid])->save($data)) {
            return $Weixin->getError();
        }

        // 更新缓存信息
        $cache_key = 'user_openid_' . $openid;
        $openid_result = $Weixin->getByOpenid($openid);
        S($cache_key, json_encode(['openid' => $openid_result]), 3600);
        return TRUE;
    }

    /*
     * getbyopenid
     * return openid_result
     */
    public function getByOpenid ($openid)
    {
        if (!$openid) {
            return FALSE;
        }
        $cache_key = 'user_openid_' . $openid;
        $cache_value = json_decode(S($cache_key), TRUE);
        if (empty($cache_value['openid'])) {
            $Weixin = D('Weixin');
            $openid_result = $Weixin->getByOpenid($openid);
            if ($openid_result) {
                S($cache_key, json_encode(['openid' => $openid_result]), 3600);
            } else {
                return FALSE;
            }
        } else {
            $openid_result = $cache_value['openid'];
        }

        return $openid_result;
    }


}