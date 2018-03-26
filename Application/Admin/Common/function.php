<?php

function email() {

    $mail = new \SaeMail();

    $ret = $mail->quickSend("1217046214@qq.com", "邮件标题", "邮件内容", "hello_lijj@qq.com", "hello_lijj");

    //发送失败时输出错误码和错误信息
    if ($ret === false) {
        var_dump($mail->errno(), $mail->errmsg());
    }

    $mail->clean(); //重用此对象
    $ret = $mail->quickSend("1217046214@qq.com", "邮件标题", "邮件内容", "hello_lijj@qq.com", "hello_lijj", "smtp.sina.com", 25); //指定smtp和端口

    //发送失败时输出错误码和错误信息
    if ($ret === false) {
        var_dump($mail->errno(), $mail->errmsg());
    }

    echo '发送成功';

}