<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/28
 * Time: 下午1:49
 */

namespace Api\Model;

class QuestionSetModel extends BaseModel {


    public function listAll ()
    {

        $cache_key = 'pingshifen_question_set';
        $set_items = json_decode(S($cache_key), TRUE);
        if (!$set_items || count($set_items) == 0) {
            $set_items = $this->select();
            S($cache_key, json_encode($set_items), 3600);
        }
        return $set_items;
    }
}