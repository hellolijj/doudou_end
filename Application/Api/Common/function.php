<?php


function check_num_ids ($ids)
{
    if (empty($ids) || !is_array($ids)) {
        return FALSE;
    }
    foreach ($ids as $id) {
        if (!is_numeric($id)) {
            return FALSE;
        }
    }
    return TRUE;
}

/*
 * 是数字返回 TRUE
 */
function check_num_id ($id)
{
    if (empty($id) || !is_numeric($id)) {
        return FALSE;
    }

    return TRUE;
}

function is_register ()
{

}