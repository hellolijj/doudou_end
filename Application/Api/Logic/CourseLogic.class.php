<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/16
 * Time: 上午12:21
 */

namespace Api\Logic;

use APi\Service\CourseService;
use Api\Service\WeixinService;

class CourseLogic extends BaseLogic {


    /*
     * 创建一个课程
     */
    // todo 写一个专门用于上传图片的接口
    public function create ()
    {
        $openid = session('openid');
        $weixinService = new WeixinService();
        $weixin_user_result = $weixinService->getByOpenid($openid);
        if ($weixin_user_result['success'] === FALSE) {
            return $weixin_user_result;
        }
        $uid = $weixin_user_result['data']['uid'];
        $user_type = $weixin_user_result['data']['type'];
        if (!$uid || !is_numeric($uid)) {
            return $this->setError('uid参数错误');
        }
        if ($user_type != WeixinService::$USER_TYPE_TEACHER) {
            return $this->setError('不是教师用户');
        }
        // 入参校验
        $course_name = I('course_name');
        $course_img = I('course_img');
        $course_class_name = I('course_class_name');
        $course_remark = I('course_remark');
        if (!$course_name || !$course_img || !$course_class_name) {
            return $this->setError('参入参数不能为空');
        }
        // todo  课程数量要做限制
        $courseService = new CourseService();
        $crease_result = $courseService->create($uid, $course_name, $course_class_name, $course_img, $course_remark);
        if ($crease_result['success'] === FALSE) {
            return $this->setError($crease_result['message']);
        }
        return $this->setSuccess([], '添加成功');
    }
}