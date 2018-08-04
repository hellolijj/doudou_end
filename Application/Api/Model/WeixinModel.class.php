<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 上午11:58
 */

namespace Api\Model;

class WeixinModel extends BaseModel {

    public static $USER_TYPE_UNREGISTER = 0;
    public static $USER_TYPE_STUDENT = 1;
    public static $USER_TYPE_TEACHER = 2;
    public static $USER_TYPE = [0 => '未注册', 1 => '学生', 2 => '教师',];
    public static $USER_TYPE_WITH_ENGLISH = [0 => 'un_register', 1 => 'student', 2 => 'teacher',];
    protected $fields = array('id', 'openid', 'uid', 'type', 'nick', 'avatar', 'gmt_create', '_type' => array('id' => 'int', 'openid' => 'varchar', 'uid' => 'int', 'type' => 'tinyint', 'nick' => 'varchar', 'avatar' => 'varchar', 'gmt_create' => 'bigint', 'gmt_modified' => 'bigint',));

    protected $_validate = array(array('openid', 'require', '获取微信参数失败'), array('openid', '', '微信帐号已经绑定！', self::MODEL_INSERT, 'unique'), array('uid', 'require', '用户uid为空'), array('type', 'number', '用户类型错误'), array('avatar', 'url', '头像字段必须为url地址', self::EXISTS_VALIDATE), array('type', array(0, 1, 2), '用户类型只能 学生、教师', self::EXISTS_VALIDATE, 'in'),);

    protected $_auto = array(array('gmt_create', 'time', self::MODEL_INSERT, 'function'), array('type', 0, self::MODEL_INSERT),);

    public function getByOpenid ($openid)
    {
        if (empty($openid)) {
            return NULL;
        }
        return $this->where(['openid' => $openid])->find();
    }

    public function addAsPasser($openid) {
        $data = ['openid' => $openid, 'uid' => 0, 'type' => 0, 'gmt_create' => time(), 'gmt_modified' => time()];
        if (FALSE == $this->getByOpenid($openid)) {
            M('Weixin')->add($data);
            $cache_key = 'pingshifen_weixin_items_by_openid' . $openid;
            S($cache_key, NULL);
        }
    }

    public function updateInfo($openid, $data) {
        if (!$openid || count($data) == 0) {
            return FALSE;
        }
        $data['gmt_modified'] = time();
        $save_result = M('Weixin')->where(['openid' => $openid])->save($data);
        if (!$save_result) {
            return FALSE;
        }
        $cache_key = 'pingshifen_weixin_items_by_openid' . $openid;
        S($cache_key, NULL);
        return TRUE;
    }

}