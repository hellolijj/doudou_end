<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午4:05
 */

namespace Api\Logic;

use Api\Service\StudentService;


class StudentLogic extends BaseLogic {

    public function __construct ()
    {
    }

    public function register ()
    {
        if (IS_AJAX) {
            return $this->setError('请求的接口不存在');
        }
        $studentService = new StudentService();
        if (!$studentService->isStudent()) {
            $data = I();
            $Student = D('student');
            if (!$Student->create($data)) {
                $this->setError($Student->getError());
            } else {
                $Student->add($data);
            }
        }
    }
}