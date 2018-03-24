<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 上午12:14
 */

return array(

    'APP_NAME' => 'pingshifen', 'API_LIST' => ['SCHOOL', 'STUDENT', 'WEIXIN', 'TEACHER', 'MY', 'COURSE', 'SIGNIN', 'QUESTION'],

    /* 数据库配置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'pingshifen', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '',  // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'pingshifen_', // 数据库表前缀

    'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), // 数据库兼容大小写

    /* 文件上传路径 */
    'APP_ROOT' => 'http://127.0.0.1/pingshifen/', 'UPLOAD_DIR' => 'Uploads/Picture/', 'UPLOAD_ROOT' => 'http://127.0.0.1/pingshifen/Uploads/Picture/',

    /* 公众号的相关配置 */
    'APP_ID' => 'wx7af4d4e3dc78c624', 'APP_SECRET' => '5d70813a51f658c26a922e7eae0c9196', 'APP_LOGO' => 'http://pingshif-img.stor.sinaapp.com/2018-02-21/logo01222_1979.jpg',

    'SHOW_PAGE_TRACE' => TRUE, 'LOG_RECORD' => TRUE, // 开启日志记录

    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR,SQL', // 只记录EMERG ALERT CRIT ERR 错误
);