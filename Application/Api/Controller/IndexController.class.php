<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Api\Controller;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends BaseController {

    //系统首页
    public function index ()
    {
        echo "豆豆云主助教后台接口首页";
        echo date('Y-m-d H:i:s', time());
    }


    // 爬取排名明星粉丝数据
    public function craw() {
        $reqi_url = 'http://node.video.qq.com/x/api/doki_rank_detail?starids=150054,1320228&fantuans=150054,1320228';
        $reqi_contents = file_get_contents($reqi_url);
        $reqi_contents = json_decode($reqi_contents, TRUE);
        $yangyunqing_value = intval($reqi_contents[150054]['stFanTuanScoreInfo']['ddwPopularity']);
        $xiaozhan_value = intval($reqi_contents[1320228]['stFanTuanScoreInfo']['ddwPopularity']);

        return ['sunnee' => $yangyunqing_value, 'xz' => $xiaozhan_value];
    }

    public function shishi() {
        $data = $this->craw();
        echo "sunnee:" . $data['sunnee'] . "<br/>";
        echo 'xz:' . $data['xz'] ."\n";
    }

    public function inserdb() {

        $value = $this->craw();
        $xz_value = $value['xz'];
        $sunnee_value = $value['sunnee'];
        if (!$xz_value) {
            $xz_value = 0;
        }
        if (!$sunnee_value) {
            $sunnee_value = 0;
        }

        $xz_last_value = 0;
        $sunnee_last_value = 0;

        $last_value = M('crew_mingxing')->order('id desc')->limit(1)->select();


        if ($last_value) {
            $xz_last_value = $last_value[0]['xz'];
            $sunnee_last_value = $last_value[0]['sunnee'];
        }

        $data = [
            'time' => date('md H:i', time()),
            'xz' => $xz_value,
            'sunnee' => $sunnee_value,
            'gap' => $sunnee_value -  $xz_value,
            'xz_incre' => $xz_value - $xz_last_value,
            'sunnee_incre' => $sunnee_value - $sunnee_last_value,
            'gmt_create' => time(),
        ];

        M('crew_mingxing')->add($data);
    }

    public function get() {
        $data = M('crew_mingxing')->order('id desc')->limit(20)->select();

        $this->assign('list', $data)->display('showdata');


    }

}