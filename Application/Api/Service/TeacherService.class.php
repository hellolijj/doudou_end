<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/14
 * Time: 上午9:23
 */

namespace Api\Service;

class TeacherService extends BaseService {

    public function bind ($name, $tel, $school, $head_img, $sex)
    {
        $data = ['name' => $name, 'tel' => $tel, 'school' => $school, 'head_img' => $head_img, 'sex' => $sex, 'gmt_create' => time(), 'gmt_modified' => time(),];
        $openid = session('openid');
        $weixinService = new WeixinService();
        $is_band = $weixinService->is_bind($openid, 'teacher');
        if (FALSE === $is_band) {
            $uid = M('Teacher')->add($data);
            $weixinService->BeTeacher($openid, $uid);
            return $uid;
        } elseif (TRUE === $is_band) {
            return ['success' => FALSE, 'message' => '已经绑定了'];
        } else {
            return $is_band;
        }
    }

    /*
     * 获取教师用户信息
     */
    public function getTeacherInfo ($uid)
    {
        if (!$uid || !is_numeric($uid)) {
            return ['success' => FALSE, 'message' => 'uid参数错误'];
        }
        $cache_key = 'teacher_uid_' . $uid;
        $teacher_user = json_decode(S($cache_key), TRUE);
        if (!count($teacher_user)) {
            $teacher_user = M('Teacher')->getById($uid);
            if (!$teacher_user) {
                return ['success' => FALSE, 'message' => '获取教师信息失败'];
            }
            S($cache_key, json_encode($teacher_user), 3600);
        }
        return ['success' => TRUE, 'data' => $teacher_user];
    }


}