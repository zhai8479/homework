<?php
/**
 *博客接口.
 * User: ZT
 * Date: 2017/8/28/0028
 * Time: 18:08
 */
require_once __DIR__ . '/../lib/link.php';

// 获取接口名称
//$action = empty($_SERVER['action'])?'':trim($_SERVER['action']);
$action = empty($_POST['action'])?'':trim($_POST['action']);

function json ($data = [], $msg = 'success', $code = 0, $exit = true) {
    $ret = json_encode(
        [
            'data' => $data,
            'msg' => $msg,
            'code' => $code
        ],
        JSON_UNESCAPED_UNICODE
    );
    if ($exit) {
        exit($ret);
    } else {
        return $ret;
    }
}