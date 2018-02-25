<?php
/**
 * Created by PhpStorm.
 * User: lijunjun
 * Date: 2018/2/24
 * Time: 上午10:55
 */

namespace Api\Model;

class QuestionCountModel extends BaseModel {


    public function initialize ($qid)
    {
        if (!$qid) {
            return FALSE;
        }
        $data = ['qid' => $qid, 'gmt_create' => time(), 'gmt_modified' => time(),];
        $this->add($data);
    }

    public function getByQid ($qid, $field = '*')
    {
        if (!$qid) {
            return ['success' => FALSE, 'message' => '参数不为空'];
        }
        $question_record_item = $this->where(['qid' => $qid])->find();
        return $question_record_item;
    }
}