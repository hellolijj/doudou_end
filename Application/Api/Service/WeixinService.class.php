<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/28
 * Time: 上午10:37
 */

namespace Api\Service;

class WeixinService extends BaseService {

    public static $ERROR_NO_REGISTER = 4001;
    public static $ERROR_INFO = [4001 => '用户没有注册',];

    public function __construct ()
    {
        parent::__construct();
    }



    /*
     * 判断openid 是否绑定
     * @param user_type string 'student' or 'teacher' or null
     * @return true or false or 错误数组
     */
    public function is_bind ($openid, $user_type = '')
    {
        $weixin_user = json_decode(S($openid), TRUE);
        $USER_TYPE = [1 => 'student', 2 => 'teacher',];
        if (!$weixin_user) {
            return ['success' => FALSE, 'message' => '缓存信息失效'];
        }
        // 未传参，说明
        if (empty($user_type) && $weixin_user['uid'] > 0 && $weixin_user['type'] > 0) {
            return TRUE;
        }
        if (!in_array($user_type, $USER_TYPE)) {
            return ['success' => FALSE, 'message' => '无效的user_type参数'];
        }
        if ($weixin_user['uid'] == 0 && $weixin_user['type'] == 0) {
            return FALSE;
        }

        if ($weixin_user['uid'] > 0 && $USER_TYPE[$weixin_user['type']] == $user_type) {
            return TRUE;
        }

        if ($USER_TYPE[$weixin_user['type']] != $user_type) {
            if ($USER_TYPE[$weixin_user['type']] == 'student') {
                return ['success' => FALSE, 'message' => '已经绑定了学生用户'];
            }
            if ($USER_TYPE[$weixin_user['type']] == 'teacher') {
                return ['success' => FALSE, 'message' => '已经绑定了教师用户'];
            }
        }
        return ['success' => FALSE, 'message' => '未知错误'];
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
     * be a teacehr
     */
    public function BeTeacher ($openid, $uid)
    {
        if (!$openid || !$uid) {
            return FALSE;
        }
        $data = ['openid' => $openid, 'uid' => $uid, 'type' => BaseService::$USER_TYPE_TEACHER, 'gmt_modified' => time()];
        $Weixin = D('Weixin');
        if (!$Weixin->where(['openid' => $openid])->save($data)) {
            return $Weixin->getError();
        }
        // 更新缓存信息
        $weixin_user = $Weixin->getByOpenid($openid);
        S($openid, json_encode($weixin_user), 3600);
        return TRUE;
    }



    /*
     * getbyopenid
     * return openid_result
     */
    public function getByOpenid ($openid)
    {
        if (!$openid) {
            return ['success' => FALSE, 'message' => 'openid为空'];
        }
        $cache_key = $openid;
        $cache_value = json_decode(S($cache_key), TRUE);
        if (empty($cache_value)) {
            $Weixin = D('Weixin');
            $weixin_user = $Weixin->getByOpenid($openid);
            if ($weixin_user) {
                S($cache_key, json_encode($weixin_user), 3600);
            } else {
                return ['success' => FALSE, 'code' => self::$ERROR_NO_REGISTER, 'message' => '获取不到用户信息'];
            }
        } else {
            $weixin_user = $cache_value;
        }

        return ['success' => TRUE, 'data' => $weixin_user];;
    }

    /*
     * 获取用户的类型
     */
    public function getUserTypeByOpenid ($openid)
    {
        if (!$openid) {
            return ['success' => FALSE, 'message' => 'openid为空'];
        }
        $weixin_user_result = $this->getByOpenid($openid);
        if ($weixin_user_result['success'] === FALSE) {
            return $weixin_user_result;
        }
        return ['success' => TRUE, 'data' => $weixin_user_result['data']['type']];
    }


}