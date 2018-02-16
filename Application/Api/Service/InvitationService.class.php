<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/14
 * Time: 上午8:55
 */

namespace Api\Service;


class InvitationService extends BaseService {

    public static $SYSTEM_INVITION_CODE = ['ZJGSU', 'IEEE', '20180205'];

    /*
     * 根据邀请码，获取邀请人。如果获取不到，则说明无效的邀请码
     * @return 校验成功 获取 uid or return false
     */
    public function getInvitor ($invitation_code)
    {
        if (in_array($invitation_code, self::$SYSTEM_INVITION_CODE)) {
            return BaseService::$SYSTEM_UID;
        } else {
            return FALSE;
        }
    }

    /*
     * 添加邀请记录
     */
    public function add ($uid, $invitation_code, $invitor_uid)
    {
        $data = ['uid' => $uid, 'invitation_code' => $invitation_code, 'invitor_uid' => $invitor_uid, 'gmt_create' => time(), 'gmt_modified' => time(),];
        M('invitation')->add($data);
    }
}