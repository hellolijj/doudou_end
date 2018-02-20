<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/18
 * Time: 下午8:58
 */

namespace Api\Logic;

use Api\Model\WeixinModel;
use Api\Service\SigninRecordService;
use Api\Service\SigninService;

class SigninLogic extends UserBaseLogic {

    public function __construct ()
    {
        parent::__construct();
    }

    /*
     * 教师发起点名
     */
    public function create ()
    {
        if ($this->user_type != WeixinModel::$USER_TYPE_TEACHER) {
            return $this->setError('非教师用户不能发起点名');
        }
        $cid = intval(I('cid'));
        $title = I('title');
        $start_time = intval(I('start_time'));
        $end_time = intval(I('end_time'));
        $address = I('address');
        $latitude = floatval(I('latitude'));
        $longitude = floatval(I('longitude'));
        $radius = intval(I('radius'));
        if (!$cid || !$title || !$address || !$latitude || !$longitude || !$radius) {
            return $this->setError('参数不能为空');
        }
        if ($start_time >= $end_time || $start_time < strtotime('2018-01-01') || $end_time > strtotime('2033-01-01')) {
            return $this->setError('时间参数不合法');
        }
        $signinService = new SigninService();
        $signin_create_result = $signinService->add($this->uid, $cid, $title, $start_time, $end_time, $address, $latitude, $longitude, $radius);
        if (!$signin_create_result) {
            return $this->setError('签到创建失败');
        }
        return $this->setSuccess([], '签到创建成功');
    }


    /*
     * 罗列所有的点名列表
     */
    public function list_all_item ()
    {
        $cid = intval(I('cid'));
        $page = intval(I('page'));
        $page_size = intval(I('page_size'));
        if (!$cid || !is_numeric($cid)) {
            return $this->setError('无效的课程号');
        }
        $page = $page ? $page : 1;
        $page_size = $page_size ? $page_size : 10;
        $signin_items = M('Signin')->cache(60)->where(['cid' => $cid])->page($page)->limit($page_size)->order('gmt_create desc')->select();
        if (!$signin_items) {
            if ($this->user_type == WeixinModel::$USER_TYPE_TEACHER) {
                return $this->setError('你还没有发布点名哦～');
            } elseif ($this->user_type == WeixinModel::$USER_TYPE_STUDENT) {
                return $this->setError('你的老师还没发布点名');
            } else {
                return $this->setError('用户类型错误');
            }
        }
        $signinService = new SigninService();
        $classfied_signin_result = $signinService->classfy_signin_items($signin_items);
        if ($classfied_signin_result['success'] === FALSE) {
            return $classfied_signin_result;
        }
        return $this->setSuccess($classfied_signin_result['data'], '点名获取成功');
    }

    /*
     * 查看所有的签到记录
     */
    public function list_all_record ()
    {
        $signin_id = intval(I('signin_id'));
        $page = intval(I('page'));
        $page_size = intval(I('page_size'));
        if (!$signin_id) {
            return $this->setError('参数错误');
        }
        $page = $page ? $page : 1;
        $page_size = $page_size ? $page_size : 20;
        $signin_records = M('Signin_record')->cache('signin_' . $signin_id, 30)->where(['sid' => $signin_id])->page($page)->limit($page_size)->select();
        $signin_records_count = intval(M('Signin_record')->where(['sid' => $signin_id])->count());
        $this->hasMorePage($signin_records_count, $page, $page_size);
        $signinRecordService = new SigninRecordService();
        $signinRecordService->signin_record_add_info($signin_records);

        return $this->setSuccess(['finish' => $signin_records, 'undo' => []]);
    }

    /*
     * 在线签到
     */
    public function signin_online ()
    {
        $signin_id = intval(I('signin_id'));
        $course_id = intval(I('course_id'));
        $latitude = floatval(I('latitude'));
        $longitude = floatval(I('longitude'));
        if (!$signin_id || !$course_id || !$longitude || !$latitude) {
            return $this->setError('参数错误');
        }
        if ($this->user_type != WeixinModel::$USER_TYPE_STUDENT) {
            return $this->setError('非学生用户不能签到');
        }
        // TODO 是不是本班学生，是不是重复签到， 是不是学生身份，时间符不符合标准 地理位置怎么样
        $signinService = new SigninService();
        $check_result = $signinService->check_signin_online($this->uid, $course_id, $signin_id);
        if ($check_result['success'] === FALSE) {
            return $this->setError($check_result['message']);
        }
        D('SigninRecord')->add($course_id, $signin_id, $this->uid, $latitude, $longitude);
        return $this->setSuccess([], '签到成功');
    }

    /*
     * 查看某次签到的详细相信信息
     */
    public function get_management ()
    {
        $signin_id = intval(I('signin_id'));
        $course_id = intval(I('course_id'));
        if (!$signin_id || !$course_id) {
            return $this->setError('参数错误');
        }
        $signin_management = M('Signin')->cache('signin_management_' . $signin_id)->find($signin_id);
        if (!$signin_management) {
            return $this->setError('本次签到信息不存在');
        }
        $signin_management['start_time_formate_date'] = date('Y-m-d', $signin_management['start_time']);
        $signin_management['start_time_formate_time'] = date('H:i', $signin_management['start_time']);
        $signin_management['end_time_formate_time'] = date('H:i', $signin_management['end_time']);


        return $this->setSuccess($signin_management, '获取成功');
    }

}