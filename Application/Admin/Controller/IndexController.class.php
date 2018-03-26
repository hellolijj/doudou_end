<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {
    public function index ()
    {
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>', 'utf-8');
    }

    public function email() {
        $mail = new \SaeMail();
        $ret = $mail->quickSend( '1217046214@qq.com', //接受者邮箱
            '邮件标题',   //邮件标题
            '邮件发送成功',   //邮件内容
            'hello_lijj@qq.com' , //发送方邮箱
            'hello_lijj',             //发送方邮箱密码
            'smtp.exmail.qq.com',
            465);

        //发送失败时输出错误码和错误信息
        if ($ret === false)
            var_dump($mail->errno(), $mail->errmsg());
        else
            echo '发生成功';
    }

    public function send() {
        email();
    }

}