<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午1:22
 */

namespace Api\Service;

class StudentService extends BaseService {

    public function __construct ()
    {
        parent::__construct();
    }


    public function bind ($name, $tel, $school, $number, $enter_year, $head_img, $sex)
    {
        $data = ['name' => $name, 'tel' => $tel, 'school' => $school, 'number' => $number, 'enter_year' => $enter_year, 'head_img' => $head_img, 'sex' => $sex, 'gmt_create' => time(), 'gmt_modified' => time(),];
        $openid = session('openid');
        $weixinService = new WeixinService();
        if (!$weixinService->is_bind($openid, 'student')) {
            $uid = M('Student')->add($data);
            $weixinService->BeStudent($openid, $uid);
            return TRUE;
        }
        return FALSE;
    }


}