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
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'w.rdc.sae.sina.com.cn,r.rdc.sae.sina.com.cn', // 服务器地址
    'DB_NAME' => 'app_pingshif', // 数据库名
    'DB_USER' => 'zwmzjymjk1', // 用户名
    'DB_PWD' => 'km3wi1h2w0j5k4xiw1xh5hiz5l1514ik0l3ihl1x',  // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'pingshifen_', // 数据库表前缀


    /* 文件上传路径 */
    'APP_ROOT' => 'https://pingshifen.applinzi.com/', 'UPLOAD_DIR' => 'img/', 'UPLOAD_ROOT' => 'http://pingshif-img.stor.sinaapp.com/',

    /* debug 日志*/
    'LOG_RECORD'           => true, // 进行日志记录
    'LOG_EXCEPTION_RECORD' => true, // 是否记录异常信息日志
    'LOG_LEVEL'            => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL', // 允许记录的日志级别
    'DB_FIELDS_CACHE'      => false, // 字段缓存信息
    'DB_DEBUG'             => true, // 开启调试模式 记录SQL日志
    'TMPL_CACHE_ON'        => false, // 是否开启模板编译缓存,设为false则每次都会重新编译
    'TMPL_STRIP_SPACE'     => false, // 是否去除模板文件里面的html空格与换行
    'SHOW_ERROR_MSG'       => true, // 显示错误信息
    'URL_CASE_INSENSITIVE' => false, // URL区分大小写

);