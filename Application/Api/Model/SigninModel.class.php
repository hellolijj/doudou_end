<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午4:36
 */

namespace Api\Model;
class SigninModel extends BaseModel {

    public function add ($uid, $cid, $title, $start_time, $end_time, $address, $latitude, $longitude, $radius)
    {
        $data = ['uid' => $uid, 'cid' => $cid, 'title' => $title, 'start_time' => $start_time, 'end_time' => $end_time, 'address' => $address, 'latitude' => $latitude, 'longitude' => $longitude, 'radius' => $radius, 'gmt_create' => time(), 'gmt_modified' => time(),];
        $cache_key = 'pingshifen_signin_by_cid_' . $cid;
        $signin_items = M('Signin')->where(['cid' => $cid])->page($page)->limit($page_size)->order('gmt_create desc')->select();
        S($cache_key, json_encode($signin_items));
        return M('Signin')->add($data);
    }

    public function listByCid ($cid, $page = 1, $page_size = 20)
    {
        if (!$cid) {
            return FALSE;
        }
        $cache_key = 'pingshifen_signin_by_cid_' . $cid;
        $signin_items = json_decode(S($cache_key), TRUE);
        if (!$signin_items || count($signin_items) == 0) {
            $signin_items = M('Signin')->where(['cid' => $cid])->page($page)->limit($page_size)->order('gmt_create desc')->select();
            S($cache_key, json_encode($signin_items));
        }
        return $signin_items;
    }


}