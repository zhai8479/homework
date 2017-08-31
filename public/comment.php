<?php
/**
 * 评论 comment
 * 发布 release_comment
 * 删除 delete_comment
 * User: ZT
 * Date: 2017/8/30/0030
 * Time: 21:59
 */
require_once __DIR__ . '/../lib/link.php';
require_once __DIR__ . '/../lib/global_function.php';

// 获取接口名称
//$action = empty($_SERVER['action'])?'':trim($_SERVER['action']);
$action = empty($_SERVER['HTTP_ACTION'])?'':trim($_SERVER['HTTP_ACTION']);
$uid = empty($_SERVER['HTTP_UID'])?null:trim($_SERVER['HTTP_UID']);
$token = empty($_SERVER['HTTP_TOKEN'])?null:trim($_SERVER['HTTP_TOKEN']);

function json($data = [], $msg = 'success', $code = 0, $exit = true)
{
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

// 执行操作
// 发布操作
if ($action == 'release_comment') {

    // 获取表单数据:
    $content = empty($_POST['content'])?null:trim($_POST['content']);
    if (empty($content)) return json([], '内容必须输入', -1);
    $result = $db->exec("insert into `comment` `content` values ('$content')");

    if ($result == 1) {
        return json([], '发布成功');
    } else {
        return json([$db->errorInfo()], '发布失败', -1);
    }
}
