<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/3
 * Time: 上午10:48
 */


namespace Api\Controller;

use Think\Controller;

/**
 * 微信控制器
 * 处理与微信相关的逻辑
 */
class WeixinController extends Controller {
    //系统首页
    public function index ()
    {


    }

    /*
     * 微信网页授权登陆： 跳转到微信授权网页
     */

    public function start ()
    {
        header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1530ad1155dda9ad&redirect_uri=http://psf.gailvlunpt.com/index.php?s=/Api/Weixin/oauth&response_type=code&scope=snsapi_base&state=1#wechat_redirect');
    }

    /*
     * 微信网页认证 跳转页面
     */
    public function oauth ()
    {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx1530ad1155dda9ad&secret=3fea03b8dd35b465c31b1c37e659cb66&code=' . $code . '&grant_type=authorization_code';
            $content = file_get_contents($url);
            $de_json = json_decode($content, TRUE);
            $openid = $de_json['openid'];
            session('openid', $openid);
            header("Location: http://psf.gailvlunpt.com/#/my/index?openid=" . $openid);
        } else {
            echo "NO CODE";
        }
    }

    public function getOpenid ()
    {
        $openid = session('openid');
        if ($openid) {
            $this->ajaxReturn(['success' => TRUE, 'data' => $openid]);
        } else {
            $this->ajaxReturn(['success' => FALSE, 'data' => NULL]);
        }
    }


    /*
     * 小程序的授权登陆接口
     */
    public function login ()
    {

        $code = I("code");
        $rawData = I("rawData", '', 'stripslashes');
        $signature = I("signature");
        $encryptedData = I("encryptedData");
        $iv = I("iv");
        $wxHelper = NEW  \Weixin\Xiaochengxu\WXLoginHelper();
        $data = $wxHelper->checkLogin($code, $rawData, $signature, $encryptedData, $iv);
        $this->ajaxReturn($data);

    }

    public function checkLogin ()
    {

    }


}