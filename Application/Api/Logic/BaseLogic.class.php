<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Api\Logic;

/**
 * 文档模型逻辑层公共模型
 * 所有逻辑层模型都需要继承此模型
 */
class BaseLogic{
    public $result = ['success' => FALSE, 'message' => '', 'data' => NULL, 'is_openid' => FALSE,];

    public function __construct ()
    {
        $openidInid = $this->openidInit();
        if (is_array($openidInid)) {
            return $openidInid;
        }

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

        $user_info = json_decode(S($openid), TRUE);
        if (!count($user_info)) {
            $user_info = M('Weixin')->getByOpenid($openid);
            if (is_null($user_info)) {
                return ['success' => FALSE, 'message' => '你还没有注册'];
            }
            S($openid, json_encode($user_info), 3600);
        }
    }
}