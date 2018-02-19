<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/18
 * Time: 下午8:58
 */

namespace Api\Logic;

use Api\Model\WeixinModel;
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
    public function list_all ()
    {
        $cid = intval(I('cid'));
        $page = intval(I('page'));
        $page_size = intval(I('page_size'));
        if (!$cid || !is_numeric($cid)) {
            return $this->setError('无效的课程号');
        }
        $page = $page ? $page : 1;
        $page_size = $page_size ? $page_size : 10;
        $signin_items = M('Signin')->cache(60)->page($page)->limit($page_size)->order('gmt_create desc')->select();
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
}