<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午4:36
 */

namespace Api\Model;
class SigninRecordModel extends BaseModel {

    // todo page page_size 暂时不做



    public function add ($cid, $sid, $uid, $latitude, $longitude)
    {
        $data = ['cid' => $cid, 'sid' => $sid, 'uid' => $uid, 'latitude' => $latitude, 'longitude' => $longitude, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('Signin_record')->add($data);

        // todo 加入后改变缓存数据
        $cache_key = 'pingshifen_signin_record_by_signin_id_' . $sid;
        S($cache_key, NULL);
    }

    public function listBySid ($sid, $page = 1, $page_size = 20)
    {
        if (!$sid) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        $cache_key = 'pingshifen_signin_record_by_signin_id_' . $sid;
        $signin_record_items = json_decode(S($cache_key), TRUE);
        if (!$signin_record_items || count($signin_record_items) == 0) {
            $signin_record_items = $this->where(['sid' => $sid])->page($page)->limit($page_size)->select();
            S($cache_key, json_encode($signin_record_items), 3600);
        }
        return ['success' => TRUE, 'data' => $signin_record_items];
    }

    public function countBySid ($sid)
    {
        if (!$sid) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        return intval(M('Signin_record')->where(['sid' => $sid])->count());
    }
}