<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/16
 * Time: 上午12:21
 */

namespace Api\Logic;

use Api\Service\ClassService;
use Api\Service\ClassServie;
use Api\Service\CourseService;
use Api\Service\SigninRecordService;
use Api\Service\WeixinService;

/*
 * 基于课程的类，调用课程类的用户都是已绑定用户
 */

class CourseLogic extends UserBaseLogic {

    public function __construct ()
    {
        parent::__construct();

    }

    /*
     * 创建一个课程
     */
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
        return $this->setSuccess($crease_result['data'], '添加成功');
    }

    /*
     * 更新课程信息
     */
    public function update ()
    {
        $course_id = intval(I('course_id'));
        // 入参校验
        $course_name = I('course_name');
        $course_img = I('course_img');
        $course_class_name = I('course_class_name');
        $course_remark = I('course_remark');
        if (!$course_name || !$course_img || !$course_class_name || !$course_id) {
            return $this->setError('参入参数不能为空');
        }
        if ($this->user_type != WeixinService::$USER_TYPE_TEACHER) {
            return $this->setError('不是教师用户');
        }
        $data = ['name' => $course_name, 'class_name' => $course_class_name, 'logo' => $course_img, 'remark' => $course_remark, 'gmt_modified' => time(),];
        $Course = D('Course');
        $course_save = $Course->where(['id' => $course_id])->save($data);
        if (!$course_save) {
            return $this->setError($Course->getError());

        }
        return $this->setSuccess(NULL, '更新成功');
    }

    /*
     * list 正在使用的课程
     */
    public function list_in_use ()
    {
        $uid = session('uid');
        $user_type = session('user_type');
        $page = intval(I('page'));
        $page_size = 20;
        if (!$page) {
            $page = 1;
        }
        // 教师用户从course表查找
        if ($user_type == WeixinService::$USER_TYPE_TEACHER) {
            $courseService = new CourseService();
            $course_items = $courseService->list_in_use_for_teacher($uid, $page, $page_size);
            $course_count = D('Course')->countCourseByUid($uid);

        } elseif ($user_type == WeixinService::$USER_TYPE_STUDENT) {
            $classService = new ClassService();
            $course_items_result = $classService->list_in_use_for_student($uid, $page, $page_size);
            print_r($course_items_result);
            die;
            if ($course_items_result['success'] === FALSE) {
                return $this->setError($course_items_result['message']);
            }
            $course_items = $course_items_result['data'];
            $course_count = D('Class')->countClassByUid($uid);
        }
        $this->hasMorePage($course_count, $page, $page_size);
        if ($course_items) {
            return $this->setSuccess($course_items, '获取所有课程');
        } else {
            return $this->setError('你还没有创建课程');
        }
    }

    /*
    * list 锁上的所有的课程
    */
    public function list_lock ()
    {

    }

    /*
     * 检索课程
     */
    public function search ()
    {
        $course_id = intval(I('course_id'));
        if (!$course_id) {
            return $this->setError('传入的参数不能为空');
        }
        $courseService = new CourseService();
        $course = $courseService->search($course_id);
        return $course;
    }

    /*
     * 学生用户 添加课程
     */
    public function add ()
    {
        $course_id = intval(I('course_id'));
        $uid = intval(session('uid'));
        $user_type = intval(session('user_type'));
        if (!$course_id || !$uid || !$user_type) {
            return $this->setError('参数不能为空');
        }
        if ($user_type != WeixinService::$USER_TYPE_STUDENT) {
            return $this->setError('非学生用户不能加入课程');
        }
        $courseService = new CourseService();
        $course_add_result = $courseService->add($uid, $course_id);
        if ($course_add_result['success'] === FALSE) {
            return $this->setError($course_add_result['message']);
        }
        return $this->setSuccess($course_id, '添加成功');
    }

    /*
     * 退出课程
     */
    public function quite ()
    {

    }

    /*
     * 获取当前课程
     */
    public function current ()
    {
        $uid = session('uid');
        $user_type = session('user_type');
        $current_course_id = intval(I('current_course_id'));
        $courseService = new CourseService();
        $course_item_result = $courseService->get_current_course($uid, $user_type, $current_course_id);
        if ($course_item_result['success'] === FALSE) {
            return $this->setError($course_item_result['message']);
        }
        return $this->setSuccess($course_item_result['data']);
    }


    /*
     * 获取课程信息返回给客户端
     */
    public function get_info ()
    {
        $course_id = intval(I('course_id'));
        if (!$course_id) {
            return $this->setError('参数错误');
        }
        $course_info = D('Course')->getById($course_id);
        if (empty($course_info)) {
            return $this->setError('查不到该课程信息');
        }
        return $this->setSuccess($course_info);
    }

    /*
     * list班级的所有学生列表
     */
    public function list_student ()
    {
        $course_id = intval(I('course_id'));
        if (!$course_id) {
            return $this->setError('参数错误');
        }
        $student_list = D('Class')->where(['cid' => $course_id])->select();
        if (empty($student_list)) {
            return $this->setError('该课程还没有学生加入');
        }

        // todo 不知道为什么，这里竟然能公用。后面要拆开
        $signinRecordService = new SigninRecordService();
        $signinRecordService->signin_record_add_info($student_list);

        return $this->setSuccess($student_list, '获取成功');
    }
}