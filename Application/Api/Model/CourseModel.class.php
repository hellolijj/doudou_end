<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/16
 * Time: 下午10:12
 */

namespace Api\Model;

class CourseModel extends BaseModel {

    public static $STATUS_IN_USE = 1;
    public static $STATUS_LOCKED = 2;
    public static $STATUS_INVALID = 0;


    /*
     * 罗列所有的正在使用的课程
     */
    public function getCourseByUid ($uid, $page, $page_size)
    {
        if (!$uid || !is_numeric($uid)) {
            return ['success' => FALSE, 'message' => 'uid参数错误'];
        }
        $where = ['uid' => $uid, 'status' => self::$STATUS_IN_USE,];
        $page = $page ? $page : 1;
        $page_size = $page_size ? $page_size : 20;
        $list_in_use = $this->cache(60)->where($where)->order('gmt_create desc')->limit($page_size)->page($page)->select();
        return $list_in_use;
    }

    public function countCourseByUid ($uid)
    {
        $where = ['uid' => $uid, 'status' => self::$STATUS_IN_USE,];
        $count = $this->cache(60)->where($uid)->count();
        if (!$count) {
            return 0;
        }
        return $count;
    }

}