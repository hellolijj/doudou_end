<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/13
 * Time: 下午10:46
 */

namespace Api\Logic;


use Api\Service\InvitationService;
use Api\Service\TeacherService;

class TeacherLogic extends BaseLogic {

    /**
     * @return array
     */
    public function bind ()
    {
        $name = I('name');
        $tel = intval(I('tel'));
        $school = I('school');
        $user_type = I('user_type');
        $invitation_code = I('invitation_code');

        // 参数检验
        if ($user_type !== 'teacher') {
            $this->setError('用户类型错误');
        }
        if (!$name || $tel < 0 || !$school) {
            $this->setError('参数不能为空');
        }

        // 邀请码校验
        $invationService = new InvitationService();
        $invitor_uid = $invationService->getInvitor($invitation_code);
        if (!$invitor_uid) {
            return $this->setError('无效的邀请码');
        }

        // 添加头像url 性别等参数 todo 使用crul抓取图像存到本地服务器
        $weixin_user = json_decode(S(session('openid')), TRUE);
        if (!count($weixin_user)) {
            $this->setError('微信缓存数据失效');
        }
        $head_img = $weixin_user['avatar'];
        $sex = $weixin_user['gender'];

        $teacherService = new TeacherService();
        $bind_result = $teacherService->bind($name, $tel, $school, $head_img, $sex);
        if (is_array($bind_result)) {
            return $bind_result;
        } elseif (is_numeric($bind_result)) {
            $uid = $this->setError($bind_result['message']);
            $invationService->add($uid, $invitation_code, $invitor_uid);
            return $this->setSuccess([], '绑定成功');
        } else {
            return $this->setError('绑定失败');
        }
    }
}

