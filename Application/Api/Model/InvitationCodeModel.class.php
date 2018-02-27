<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/27
 * Time: 下午1:01
 */

namespace Api\Model;

class InvitationCodeModel extends BaseModel {

    public function getByUid ($uid, $field = '*')
    {
        if (!$uid) {
            return FALSE;
        }
        $cache_key = 'pingshifen_invitation_code_by_uid_' . $uid;
        $invitation_code_item = json_decode(S($cache_key), TRUE);
        if (!$invitation_code_item) {
            $invitation_code_item = $this->where(['uid' => $uid])->find();
            S($cache_key, json_encode($invitation_code_item), 3600);
        }
        return $invitation_code_item;

    }

    public function getByCode ($code)
    {
        if (!$code) {
            return FALSE;
        }
        $cache_key = 'pingshifen_invitation_code_by_code_' . $code;
        $invitation_code_item = json_decode(S($cache_key), TRUE);
        if (!$invitation_code_item) {
            $invitation_code_item = $this->where(['code' => code])->find();
            S($cache_key, json_encode($invitation_code_item), 3600);
        }
        return $invitation_code_item;

    }
}