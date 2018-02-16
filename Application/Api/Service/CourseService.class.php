<?php

namespace APi\Service;

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
}