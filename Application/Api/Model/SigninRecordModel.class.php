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

    public static $STATUS_REPLACE = 2;   // 代签
    public static $STATUS_LEAVE = 3;     // 请假
    public static $STATUS_ABSENCE = 4;   // 缺到

    public function add ($cid, $sid, $uid, $latitude, $longitude)
    {
        $data = ['cid' => $cid, 'sid' => $sid, 'uid' => $uid, 'latitude' => $latitude, 'longitude' => $longitude, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('Signin_record')->add($data);

        $cache_key = 'pingshifen_signin_record_by_signin_id_' . $sid;
        S($cache_key, NULL);
    }

    public function add_with_status($cid, $sid, $uid, $status) {
        $data = ['cid' => $cid, 'sid' => $sid, 'uid' => $uid, 'latitude' => 0, 'longitude' => 0, 'status' => $status, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('Signin_record')->add($data);
        $cache_key = 'pingshifen_signin_record_by_signin_id_' . $sid;
        S($cache_key, NULL);
    }

    public function listBySid ($sid, $page = 1, $page_size = 20)
    {
        if (!$sid) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        $cache_key = 'pingshifen_signin_record_by_signin_id_' . $sid;
        $cache_value = S($cache_key);
        if ($cache_value) {
            $signin_record_items = json_decode(S($cache_key), TRUE);
            return ['success' => TRUE, 'data' => $signin_record_items];
        }
        $signin_record_items = $this->where(['sid' => $sid])->select();
        if ($signin_record_items) {
            S($cache_key, json_encode($signin_record_items), 3600);
        }
        return ['success' => TRUE, 'data' => $signin_record_items];
    }

    /*
     * return count
     */
    public function countBySid ($sid)
    {
        if (!$sid) {
            return 0;
        }
        return intval(M('Signin_record')->where(['sid' => $sid])->count());
    }


    /*
     *
     */

    public function getByUidAndSid ($uid, $sid)
    {
        if (!$uid || !$sid) {
            return FALSE;
        }

        $cache_key = 'pingshifen_signin_record_by_uid_' . $uid . '_sid_' . $sid;
        $cache_value = S($cache_key);
        if ($cache_value) {
            return json_decode(S($cache_key), TRUE);
        }
        $signin_record_item = $this->where(['uid' => $uid, 'sid' => $sid])->find();
        if ($signin_record_item) {
            S($cache_key, json_encode($signin_record_item));
        }
        return $signin_record_item;
    }
}