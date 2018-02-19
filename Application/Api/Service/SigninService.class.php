<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/18
 * Time: 下午10:47
 */

namespace Api\Service;

class SigninService extends BaseService {

    public function add ($uid, $cid, $title, $start_time, $end_time, $address, $latitude, $longitude, $radius)
    {
        $data = ['uid' => $uid, 'cid' => $cid, 'title' => $title, 'start_time' => $start_time, 'end_time' => $end_time, 'address' => $address, 'latitude' => $latitude, 'longitude' => $longitude, 'radius' => $radius, 'gmt_create' => time(), 'gmt_modified' => time(),];
        return M('Signin')->add($data);
    }
}