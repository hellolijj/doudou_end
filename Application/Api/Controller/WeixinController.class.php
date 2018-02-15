<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/3
 * Time: 上午10:48
 */


namespace Api\Controller;

use Api\Service\WeixinService;
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
        $rawData = htmlspecialchars(I("rawData"));
        $signature = I("signature");
        $encryptedData = I("encryptedData");
        $iv = I("iv");
        $wxHelper = NEW  \Weixin\Xiaochengxu\WXLoginHelper();
        $data_result = $wxHelper->checkLogin($code, $rawData, $signature, $encryptedData, $iv);
        if ($data_result['success'] === FALSE) {
            $this->ajaxReturn(['success' => FALSE, 'message' => $data_result['message']]);
        }
        $data = $data_result['data'];
        $data['avatar'] = $data['avatarUrl'];    //解决命名大小写问题
        $data['nickname'] = $data['nickName'];
        S($data['session3rd'], json_encode($data), 3600);  // 此缓存用于后面的验证是否登陆
        $save_result = $this->save_weixin_user($data);
        if ($save_result['success'] === FALSE) {
            $this->ajaxReturn(['success' => FALSE, 'message' => $save_result['message']]);
        }
        // session缓存
        session('openid', $data['openId']);
        $data['session_id'] = session_id();
        $this->ajaxReturn(['success' => TRUE, 'data' => $data]);
    }


    /*
     * 跟客户端保持check_3rdsession相同,,实际上就是检查是否登陆
     */
    public function check_3rdsession ()
    {
        $post_session3rd = I('rd3_session');
        $local_session3rd = session('session3rd');
        if (empty($local_3rdsession)) {
            session('session3rd', NULL);
            $this->ajaxReturn(['success' => FALSE, 'data' => FALSE, 'message' => '服务端数据过期']);
        }
        if (!session('openid')) {
            $this->ajaxReturn(['success' => FALSE, 'data' => FALSE, 'message' => 'openid数据失效']);
        }
        if ($post_session3rd && $post_session3rd != $local_session3rd) {
            session('session3rd', NULL);
            $this->ajaxReturn(['success' => FALSE, 'data' => FALSE, 'message' => '客户端端数据过期']);
        }
        if ($post_session3rd && $post_session3rd == $local_session3rd) {
            $this->ajaxReturn(['success' => TRUE, 'data' => TRUE]);
        } else {
            $this->ajaxReturn(['success' => FALSE, 'data' => FALSE, 'message' => '未知的错误']);
        }
    }

    /*
     * 获取用户手机号码
     */
    public function get_user_tel ()
    {
        $post_3rdsession = I('rd3_session');
        $encryptedData = I('encryptedData');
        $iv = I('iv');
        $wxHelper = NEW  \Weixin\Xiaochengxu\WXLoginHelper();
        $data = $wxHelper->getUserTel($post_3rdsession, $encryptedData, $iv);
        if ($data['success'] === FALSE) {
            $this->ajaxReturn(['success' => FALSE, 'message' => $data['message']]);
        }
        $this->ajaxReturn(['success' => TRUE, 'data' => $data]);
    }

    /*
     * 保存每个登陆访问的用户信息
     * @return true 保持功能 array 包含返回提示信息
     */
    private function save_weixin_user ($user_info = '')
    {
        if (!is_array($user_info) || !$user_info['openId']) {
            return ['success' => FALSE, 'message' => '无效的openid'];
        }
        $openid = $user_info['openId'];
        $is_register = $this->is_register($openid);
        if (FALSE === $is_register) {
            $data = ['openid' => $user_info['openId'], 'nickname' => $user_info['nickName'], 'gender' => intval($user_info['gender']), 'country' => $user_info['country'], 'province' => $user_info['province'], 'city' => $user_info['city'], 'avatar' => $user_info['avatarUrl'], 'gmt_create' => time(), 'gmt_modified' => time(),];
            M('Weixin')->add($data);
            return ['success' => TRUE];
        } elseif (is_array($is_register)) {
            return ['success' => FALSE, 'message' => $is_register['message']];
        }
    }

    /*
     * 判断是否注册
     * @ return true 注册 false 未注册 array 错误的原因
     */
    private function is_register ($openid = '')
    {
        if (!$openid) {
            return ['success' => FALSE, 'message' => '参数为空'];
        }
        $weixinService = new WeixinService();
        $weixin_user_result = $weixinService->getByOpenid($openid);
        if ($weixin_user_result['success'] === FALSE && $weixin_user_result['code'] === WeixinService::$ERROR_NO_REGISTER) {
            return FALSE;
        }
        if ($weixin_user_result['success'] === TRUE) {
            return TRUE;
        }
        return ['success' => FALSE, 'message' => '未知的原因'];;
    }

}