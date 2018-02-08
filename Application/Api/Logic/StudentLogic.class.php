<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午4:05
 */

namespace Api\Logic;


class StudentLogic extends BaseLogic {

    public $OP_TYPE = ['get', 'set'];

    public function __construct ()
    {
    }

    public function info ()
    {
        $uid = session('uid');
        if (!$uid) {
            $this->setError('无效的openid');
        }
        $info = D('Student')->getById($uid);
        return $this->setSuccess($info, '学生用户信息');
    }

    /*
     * 默认update name
     */
    public function name ()
    {
        $name = I('name');
        if (!$name) {
            return $this->setError('不能设置为空');
        }
        $uid = intval(session('uid'));
        $Student = D('Student');
        $data = ['id' => $uid, 'name' => $name,];
        if (!$Student->save($data)) {
            return $this->setError(NULL, $Student->getError());
        } else {
            return $this->setSuccess(NULL, '修改成功');
        }
    }

    /*
     * set number
     */
    public function numberSet ()
    {
        $number = intval(I('number'));
        if ($number <= 0) {
            return $this->setError('number参数错误');
        }
        $uid = intval(session('uid'));
        $Student = D('Student');
        $data = ['id' => $uid, 'number' => $number,];
        if (!$Student->save($data)) {
            return $this->setError(NULL, $Student->getError());
        } else {
            return $this->setSuccess(NULL, '修改成功');
        }
    }

    /*
     * set number
     */
    public function sexSet ()
    {
        $sex = I('sex');

        $uid = intval(session('uid'));
        $Student = D('Student');
        $data = ['id' => $uid, 'sex' => 2,  //todo 使用model中文映射
        ];
        if (!$Student->save($data)) {
            return $this->setError(NULL, $Student->getError());
        } else {
            return $this->setSuccess(NULL, '修改成功');
        }
    }

}