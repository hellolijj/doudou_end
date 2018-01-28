<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午10:00
 */

namespace Api\Logic;

class SchoolLogic extends BaseLogic {


    public function search ()
    {

        $s_name = I('s_name');
        $page = intval(I('page'));
        $page_size = intval(I('page_size'));
        if (!$s_name) {
            return $this->setError('参数为空');
        }
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 20 : $page_size;
        $where['name'] = ['LIKE', '%' . $s_name . '%'];
        $SCHOOL = D('School');
        $school_lists = $SCHOOL->listByPageWhere($where, $page, $page_size, 'id');
        $total_count = $SCHOOL->countByWhere($where);
        $this->hasMorePage($total_count, $page, $page_size);

        if ($school_lists) {
            return $this->setSuccess($school_lists, '获取学校成功');
        } else {
            return $this->setError('搜索结果为空');
        }
    }
    
    public function t() {
        echo 23;
    }
}