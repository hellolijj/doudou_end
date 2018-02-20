<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午4:36
 */

namespace Api\Model;
class SigninRecordModel extends BaseModel {

    public function add ($cid, $sid, $uid, $latitude, $longitude)
    {
        $data = ['cid' => $cid, 'sid' => $sid, 'uid' => $uid, 'latitude' => $latitude, 'longitude' => $longitude, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('Signin_record')->add($data);

        // todo 加入后改变缓存数据
    }
}