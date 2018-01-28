<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 下午1:22
 */

namespace Api\Service;

class StudentService extends BaseService {

    public function __construct ()
    {
        parent::__construct();
    }


    public function register ()
    {


    }


    public function isStudent ()
    {
        $user_type = $this::$current_user_type;
        return $user_type == $this::$USER_TYPE_STUDENT;
    }


}