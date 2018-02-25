<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/23
 * Time: 下午2:37
 */

namespace Api\Model;

class QuestionModel extends BaseModel {

    public function getByCid ($cid)
    {
        if (!$cid) {
            return FALSE;
        }
        $cache_key = 'pingshifen_question_by_id_' . $cid;
        $question_item = json_decode(S($cache_key), TRUE);
        if (!$question_item) {
            $question_item = $this->where(['cid' => $cid])->find();
            S($cache_key, json_encode($question_item), 3600);
        }
        return $question_item;
    }


}