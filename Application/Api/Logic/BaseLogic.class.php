<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Api\Logic;

use Api\Service\BaseService;
use Api\Service\StudentService;
use Api\Service\WeixinService;

/**
 * 文档模型逻辑层公共模型
 * 所有逻辑层模型都需要继承此模型
 */
class BaseLogic{
    public $result = ['success' => FALSE, 'message' => '', 'data' => NULL, 'is_openid' => FALSE,];

    public function __construct ()
    {
        $this->openidInit();
        // $this->uidInit();
    }

    public function setError ($message, $data = NULL)
    {
        $this->result['success'] = FALSE;
        $this->result['message'] = $message;
        $this->result['data'] = $data;
        $this->result['is_openid'] = session('openid') ? TRUE : FALSE;
        return $this->result;
    }

    public function setSuccess ($data, $message = '')
    {
        $this->result['success'] = TRUE;
        $this->result['message'] = $message;
        $this->result['data'] = $data;
        $this->result['is_openid'] = session('openid') ? TRUE : FALSE;
        return $this->result;
    }

    public function hasMorePage ($total_count, $page = 0, $page_size = 0)
    {
        $has_more = FALSE;
        if (!is_numeric($page) || !is_numeric($page_size) || $page <= 0 || $page_size <= 0) {
            $has_more = FALSE;
        }
        if ($total_count <= 0) {
            $has_more = FALSE;
        }
        $total_page = ceil($total_count / $page_size);
        $has_more = $page < $total_page ? TRUE : FALSE;

        $this->result['is_openid'] = session('openid') ? TRUE : FALSE;
        $this->result['page'] = $page;
        $this->result['page_size'] = $page_size;
        $this->result['has_more'] = $has_more;
    }

    /*
     * 对微信openid 初始化处理
     */
    private function openidInit ()
    {
        $openid = session('openid');
        if (!$openid) {
            return $this->setError('无效的openid参数');
        }
        if ($openid != session('openid')) {
            session('openid', $openid);
        }
        $weixinService = new WeixinService();
        $openid_result = $weixinService->getByOpenid($openid);
        if (!$openid_result) {
            $data = ['openid' => $openid, 'uid' => 0, 'type' => 0];
            $Weixin = D('Weixin');
            $Weixin->create($data);
            if (!$Weixin->create($data)) {
                return $this->setError($Weixin->getError());
            } elseif (!$Weixin->add()) {
                return $this->setError($Weixin->getError());
            }
        }
    }

    /*
     * uid 初始化处理
     * uid 依赖于openid
     */
    private function uidInit ()
    {
        $openid = session('openid');
        $uid = 0;
        if (!$openid) {
            return $this->setError('无效的openid参数');
        }
        $weixinService = new WeixinService();
        $openid_result = $weixinService->getByOpenid($openid);
        if (!$openid_result) {
            return $this->setError('获取openid参数失败');
        }
        $uid = $openid_result['uid'];
        if ($uid <= BaseService::$USER_TYPE_UN_REGISTER) {
            // 自增uid
            $studentService = new StudentService();
            $Student = D('Student');
            $sid = $studentService->autoAdd();
            if (empty($sid)) {
                return $this->setError('用户注册失败');
            }
            $student = $Student->getById($sid);
            if (empty($student) || empty($student['id'])) {
                return $this->setError('获取用户注册信息失败');
            }
            $uid = intval($student['id']);
            $weixinService->BeStudent($openid, $uid);
        }
        session('uid', $uid);
    }

}