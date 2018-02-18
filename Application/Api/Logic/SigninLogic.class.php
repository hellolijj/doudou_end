<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/18
 * Time: 下午8:58
 */

namespace Api\Logic;

use Api\Model\WeixinModel;

class SigninLogic extends UserBaseLogic {

    public function __construct ()
    {
        echo "helo";
    }

    /*
     * 教师发起点名
     */
    public function create ()
    {
        if ($this->user_type != WeixinModel::$USER_TYPE_TEACHER) {
            return $this->setError('非教师用户不能发起点名');
        }


    }
}