<?php

namespace Api\Service;

use Api\Model\CourseModel;

class CourseService extends BaseService {


    public function create ($uid, $course_name, $course_class_name, $course_logo, $course_remark)
    {
        $data = ['uid' => $uid, 'name' => $course_name, 'class_name' => $course_class_name, 'logo' => $course_logo, 'remark' => $course_remark, 'status' => 1, 'gmt_create' => time(), 'gmt_modified' => time(),];
        $COURSE = M('Course');
        $create_result = $COURSE->add($data);
        if (!$create_result) {
            return ['success' => FALSE, 'message' => $COURSE->getError()];
        }
        return ['success' => TRUE, 'message' => '数据添加成功'];
    }

    public function list_in_use ($uid, $page, $page_size)
    {
        if (!$uid || !is_numeric($uid)) {
            return ['success' => FALSE, 'message' => 'uid参数错误'];
        }
        $teacher = D('Teacher')->cache(60)->find($uid);
        $course_lists = D('Course')->getCourseByUid($uid, $page, $page_size);
        foreach ($course_lists as &$course_list) {
            $course_list['teacher'] = ['name' => $teacher['name'], 'school' => $teacher['school'],];
        }
        return $course_lists;
    }

    /*
     * 输入course_id 添加课程
     * todo 1、教师用户不能添加课程 2、你已经添加了该课程不能重复添加
     *
     *
     */
    public function add ($uid, $course_id)
    {
        if (!$course_id || !$uid) {
            return ['success' => FALSE, 'message' => 'uid参数错误'];
        }
        $classService = new ClassService();
        $is_add_result = $classService->is_first_add($uid, $course_id);
        if ($is_add_result['success'] === FALSE) {
            return ['success' => FALSE, 'message' => '该课程你已加入，不能重复添加'];
        }
        $data = ['uid' => $uid, 'cid' => $course_id, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('Class')->add($data);


    }

    public function search ($course_id)
    {
        if (!$course_id || !is_numeric($course_id)) {
            return ['success' => FALSE, 'message' => 'uid参数错误'];
        }
        $course = D('Course')->cache(60)->find($course_id);
        if (empty($course)) {
            return ['success' => FALSE, 'message' => '该课程不存在'];
        }
        $uid = $course['uid'];
        $teacher = D('Teacher')->cache(60)->find($uid);
        $course['school'] = $teacher['school'];
        $course['teacher_name'] = $teacher['name'];
        $course['is_ok'] = TRUE;

        // 对课程状态判断 1、正常 2、已经加入 3、课程已经锁定
        if ($course['status'] == CourseModel::$STATUS_LOCKED) {
            $course['is_ok'] = FALSE;
            $course['err_message'] = '该课程已锁定不能加入';
        }
        return ['success' => TRUE, 'data' => $course];
    }


}