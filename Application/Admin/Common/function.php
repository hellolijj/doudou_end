<?php

function email() {
    $mail = new SaeMail();
    $ret = $mail->quickSend( '1217046214@qq.com', //接受者邮箱
        '邮件标题',   //邮件标题
        '邮件发送成功',   //邮件内容
        'hello_lijj@qq.com' , //发送方邮箱
        'hello_lijj',             //发送方邮箱密码
        'smtp.qq.com',
        465);

    //发送失败时输出错误码和错误信息
    if ($ret === false)
        var_dump($mail->errno(), $mail->errmsg());
    else
        echo '发生成功';


}