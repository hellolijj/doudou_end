<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/1/27
 * Time: 上午12:14
 */

return array(

    /* 数据库配置 */
    'DB_DEPLOY_TYPE' => 1, // 设置分布式数据库支持
    'DB_RW_SEPARATE'=> true,
    'DB_TYPE' => 'mysql', // 数据库类型

    'DB_HOST' => 'w.rdc.sae.sina.com.cn,r.rdc.sae.sina.com.cn', // 服务器地址
    'DB_NAME' => 'app_pingshif', // 数据库名
    'DB_USER' => 'zwmzjymjk1', // 用户名
    'DB_PWD' => 'km3wi1h2w0j5k4xiw1xh5hiz5l1514ik0l3ihl1x',  // 密码
    'DB_PORT' => '3306', // 端口


//    'DB_HOST' => 'kbvaybcarhcv.mysql.sae.sina.com.cn,lgobeqojbmjb.mysql.sae.sina.com.cn', // 服务器地址
//    'DB_PORT' => 10059,
//    'DB_NAME' => 'app_pingshif', // 数据库名
//    'DB_USER' => 'admin', // 用户名
//    'DB_PWD' =>  '123456',  // 密码


    'DB_PREFIX' => 'pingshifen_', // 数据库表前缀
    /* 文件上传路径 */
    'APP_ROOT' => 'https://pingshifen.applinzi.com/', 'UPLOAD_DIR' => 'img/', 'UPLOAD_ROOT' => 'http://pingshif-img.stor.sinaapp.com/',

);