<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 上午11:58
 */

namespace Api\Model;

class WeixinModel extends BaseModel {
    protected $fields = array('id', 'openid', 'uid', 'type', 'nick', 'avater', 'gmt_create', '_type' => array('id' => 'int', 'openid' => 'varchar', 'uid' => 'int', 'type' => 'tinyint', 'nick' => 'varchar', 'avater' => 'varchar', 'gmt_create' => 'bigint', 'gmt_modified' => 'bigint',));

    protected $_validate = array(array('openid', 'require', '获取微信参数失败'), array('openid', '', '微信帐号已经绑定！', self::MODEL_INSERT, 'unique'), array('uid', 'require', '用户uid为空'), array('type', 'number', '用户类型错误'), array('avater', 'url', '头像字段必须为url地址', self::EXISTS_VALIDATE), array('type', array(0, 1, 2), '用户类型只能 学生、教师', self::EXISTS_VALIDATE, 'in'),);

    protected $_auto = array(array('gmt_create', 'time', self::MODEL_INSERT, 'function'), array('type', 0, self::MODEL_INSERT),);

    public function getByOpenid ($openid)
    {
        if (empty($openid)) {
            return NULL;
        }
        return $this->where(['openid' => $openid])->find();
    }

    public function say ()
    {
        echo 'sa';
    }

}