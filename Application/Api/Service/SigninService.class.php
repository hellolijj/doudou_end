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

    /*
     * 给课程分类 分为 正在进行已经过时的，还没有开始的
     */
    public function classfy_signin_items ($signin_items)
    {
        if (empty($signin_items)) {
            return ['success' => FALSE, 'message' => '传入的参数为空'];
        }
        $tid = $signin_items[0]['uid'];
        $teacher = D('Teacher')->cache('teacher_uid_' . $tid, 3600)->find($tid);
        $before_signin_items = [];  // 已经过期的点名
        $last_signin_items = [];   //点名过程中
        $after_signin_items = [];  // 还没有开始
        $ts = time();
        //        $ts = strtotime('2018-01-19 20:33');
        foreach ($signin_items as $signin_item) {
            $signin_item['teacher_head_img'] = $teacher['head_img'];
            $signin_item['start_time_format'] = date('Y/m/d H:i', $signin_item['start_time']);
            $signin_item['end_time_format'] = date('H:i', $signin_item['end_time']);
            if ($ts < intval($signin_item['start_time'])) {
                $before_signin_items[] = $signin_item;
            } elseif ($ts >= intval($signin_item['start_time']) && $ts <= intval($signin_item['end_time'])) {
                $last_signin_items[] = $signin_item;
            } elseif ($ts > intval($signin_item['end_time'])) {
                $after_signin_items[] = $signin_item;
            }
        }

        return ['success' => TRUE, 'data' => ['before_start' => $before_signin_items, 'is_doing' => $last_signin_items, 'is_done' => $after_signin_items,]];
    }

}