<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/17
 * Time: 下午7:51
 */


namespace Api\Service;


class ClassService extends BaseService {

    /*
     * 判断uid是否加入课程
     */
    public function is_first_add ($uid, $course_id)
    {
        if (!$uid || !$course_id) {
            return ['success' => FALSE, 'message' => '参数不能为空'];
        }
        $Class = D('Class');
        $is_add_result = $Class->cache(60)->where(['uid' => $uid, 'cid' => $course_id])->find();
        if ($is_add_result) {
            return ['success' => FALSE, 'message' => '你已经加入了'];
        }
        return ['success' => TRUE];
    }
}