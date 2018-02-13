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
    }


    /*
     * 判断openid 是否绑定
     * @param user_type string 'student' or 'teacher'
     */
    public function is_bind ($openid, $user_type)
    {
        $weixin_user = $this->getByOpenid($openid);
        $USER_TYPE = [1 => 'student', 2 => 'teacher',];
        if (!$weixin_user) {
            return FALSE;
        }
        if (!empty($weixin_user['uid']) && $weixin_user['type'] && $USER_TYPE[$weixin_user['type']] == $user_type) {
            return TRUE;
        }
        return FALSE;
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
        $cache_key = $openid;
        $weixin_user = $Weixin->getByOpenid($openid);
        S($cache_key, json_encode($weixin_user), 3600);
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
        $cache_key = $openid;
        $cache_value = json_decode(S($cache_key), TRUE);
        if (empty($cache_value)) {
            $Weixin = D('Weixin');
            $weixin_user = $Weixin->getByOpenid($openid);
            if ($weixin_user) {
                S($cache_key, json_encode($weixin_user), 3600);
            } else {
                return FALSE;
            }
        } else {
            $weixin_user = $cache_value;
        }

        return $weixin_user;
    }


}