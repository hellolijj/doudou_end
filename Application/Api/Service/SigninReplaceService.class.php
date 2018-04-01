<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/3/22
 * Time: 上午11:29
 */


namespace Api\Service;


use Api\Model\SigninRecordModel;

class SigninReplaceService extends BaseService {

    public static $OPERATE_LIST = ['replace', 'leave', 'absence'];  // '代签，请假， 缺席'


    /*
     * todo 1、判断是否为该课程教师 2、根据不同的操作方法进行不同的操作。
     */
    public function replace($teacher_uid, $course_id, $signin_id, $student_uid, $operation) {

        $signin_item = D('Signin')->getById($signin_id);
        if (empty($signin_item)) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        if ($signin_item['uid'] != $teacher_uid || $signin_item['cid'] != $course_id) {
            //return ['success' => FALSE, 'message' => '签到信息错误'];
        }

        if ($operation == SigninReplaceService::$OPERATE_LIST[0]) {
            D('SigninRecord')->add_with_status($course_id, $signin_id, $student_uid, SigninRecordModel::$STATUS_REPLACE);
            D('Signin')->countIncById($course_id, $signin_id);
        } elseif ($operation == SigninReplaceService::$OPERATE_LIST[1]) {
            D('SigninRecord')->add_with_status($course_id, $signin_id, $student_uid, SigninRecordModel::$STATUS_LEAVE);
            D('Signin')->countIncById($course_id, $signin_id);
        } elseif ($operation == SigninReplaceService::$OPERATE_LIST[2]) {
            D('SigninRecord')->add_with_status($course_id, $signin_id, $student_uid, SigninRecordModel::$STATUS_ABSENCE);
             D('Signin')->countDecById($course_id, $signin_id);
        }

        return ['success' => TRUE];
    }




}