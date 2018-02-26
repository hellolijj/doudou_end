<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/20
 * Time: 下午6:10
 */

namespace Api\Service;

class SigninRecordService extends BaseService {

    /*
     * 判断是否签到
     * return true || false || array
     */
    public function is_signined ($uid, $sid)
    {
        if (!$uid || !$sid) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        $cache_key = 'signin_record_uid_' . $uid . '_sid_' . $sid;
        $signin_record = M('Signin_record')->cache($cache_key, 60)->where(['uid' => $uid, 'sid' => $sid])->find();
        if (!$signin_record) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function signin_record_add_info (&$signin_records)
    {
        $uids = result_to_array($signin_records, 'uid');
        $where['id'] = ['in', implode(',', $uids)];
        $student_arr = M('Student')->where($where)->select();
        $student_arr = result_to_map($student_arr, 'id');


        foreach ($signin_records as &$signin_record) {
            $uid = $signin_record['uid'];
            if ($uid) {
                $signin_record['name'] = $student_arr[$uid]['name'];
                $signin_record['head_img'] = $student_arr[$uid]['head_img'];
                $signin_record['number'] = $student_arr[$uid]['number'];
                $signin_record['gmt_create_format'] = date('H:i:s', $signin_record['gmt_create']);
            }
        }
    }


    /*
     * 未签到名单
     */
    public function no_sign_records ($sign_id)
    {

        /*SELECT *
        FROM  `pingshifen_class`
        LEFT JOIN pingshifen_signin_record ON pingshifen_class.uid = pingshifen_signin_record.uid
                AND pingshifen_signin_record.sid =13
        WHERE pingshifen_signin_record.uid IS NULL
                AND pingshifen_class.cid =140523
        LIMIT 0 , 30*/

        if (!$sign_id) {
            return ['success' => FALSE, 'message' => '参数错误'];
        }
        $cid = D('Signin')->getCidById($sign_id);
        $cid = intval($cid);
        $Class = M('Class');
        $no_signin_record = $Class->join('pingshifen_signin_record ON pingshifen_class.uid = pingshifen_signin_record.uid and pingshifen_signin_record.sid = ' . $sign_id, 'left')->where(['pingshifen_signin_record.uid' => ['EXP', 'IS NULL'], 'pingshifen_class.cid' => $cid,])->select();

        return $no_signin_record;
    }
}