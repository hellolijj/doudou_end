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

function result_to_complex_map ($result, $field = 'id')
{
    $map = array();
    if (!$result || !is_array($result)) {
        return $map;
    }

    foreach ($result as $entry) {
        if (is_array($entry)) {
            if (isset($map[$entry[$field]])) {
                $map[$entry[$field]][] = $entry;
            } else {
                $map[$entry[$field]] = [$entry];
            }
        } else {
            if (isset($map[$entry->$field])) {
                $map[$entry->$field][] = $entry;
            } else {
                $map[$entry->$field] = [$entry];
            }
        }
    }
    return $map;
}

function result_to_map ($result, $field = 'id')
{
    $map = array();
    if (!$result || !is_array($result)) {
        return $map;
    }

    foreach ($result as $entry) {
        if (is_array($entry)) {
            $map[$entry[$field]] = $entry;
        } else {
            $map[$entry->$field] = $entry;
        }
    }
    return $map;
}

function result_to_array ($result, $field = 'id')
{
    $ary = array();
    if (!$result || !is_array($result)) {
        return $ary;
    }

    foreach ($result as $entry) {
        if (is_array($entry)) {
            $ary[] = $entry[$field];
        } elseif (is_object($entry)) {
            $ary[] = $entry->$field;
        }
    }
    return $ary;
}

