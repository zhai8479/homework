<?php
/**
 *博客接口.
 * 发布 release
 * 获取 detail
 * 获取列表 list
 * 删除 delete
 * 修改 update
 * User: ZT
 * Date: 2017/8/28/0028
 * Time: 18:08
 */
require_once __DIR__ . '/../lib/link.php';
require_once __DIR__ . '/../lib/global_function.php';

// 获取接口名称
$action = get_action();


// 发布博客操作
if ($action == 'release') {
// 登陆状态判断
    $user_id = null;
    $is_login = get_login_status($db, $user_id);    // 获取用户的登陆状态
    if ($is_login == false) {
        return json([], '用户未登录', -1);
    } else {
// 执行操作

        // 获取表单数据:
        $content = empty($_POST['content']) ? null : trim($_POST['content']);
        $title = empty($_POST['title']) ? null : trim($_POST['title']);
        if (empty($content)) return json([], '内容必须输入', -1);
        if (empty($title)) return json([], '标题必须输入', -1);
        $result = $db->exec("insert into `blog` (`user_id`,`content`, `title`) values ('$user_id','$content','$title')");

        if ($result == 1) {
            return json([], '发布成功');
        } else {
            return json([$db->errorInfo()], '发布失败', -1);
        }
    }
}

//获取博客信息 detail
if ($action == 'detail') {

    // 根据 blog_id 获取博客信息
    $blog_id = empty($_POST['blog_id']) ? null : trim($_POST['blog_id']);
    if (empty($blog_id)) return json([], 'blog_id必须传入', -1);
    if (!is_numeric($blog_id)) return json([], 'blog_id必须为参数', -1);

    // 执行查询
    $result = $db->query("select `id`, `title`, `content` from `blog` where `id` = $blog_id");
    if ($result) {
        $detail = $result->fetch($db::FETCH_ASSOC);
        return json(['item' => $detail]);
    } else {
        return json([$db->errorInfo()], '数据库错误', -1);
    }
}

//  获取博客列表 list
if ($action == 'list') {
    //执行查询
    $result1 = $db->query("select `id`, `title`, `release_time` from `blog` where 'is_delete' = '0'");
    $title = $result->fetchAll();
    if ($result1 == 1) {
        return json(['list' => $title], '获取成功');
    } else {
        return json([$db->errorInfo()], '获取失败', -1);
    }
}

// 根据 blog_id 删除博客信息 delete
if ($action == 'delete') {
// 登陆状态判断
    $user_id = null;
    $is_login = get_login_status($db, $user_id);    // 获取用户的登陆状态
    if ($is_login == false) {
        return json([], '用户未登录', -1);
    } else {
// 执行操作

        // 根据 blog_id 获取博客信息
        $blog_id = empty($_POST['blog_id']) ? null : trim($_POST['blog_id']);
        if (empty($blog_id)) return json([], 'blog_id必须传入', -1);
        if (!is_numeric($blog_id)) return json([], 'blog_id必须为参数', -1);

        // 执行删除
        $result = $db->query("update `blog` set `is_delete` = '0' where`id` = '$blog_id'");
        if ($result) {
            return json([], '删除成功');
        } else {
            return json([$db->errorInfo()], '数据库错误', -1);
        }
    }
}

// 根据 blog_id 修改博客信息 update
if ($action == 'update') {

// 登陆状态判断

    $user_id = null;
    $is_login = get_login_status($db, $user_id);    // 获取用户的登陆状态
    if ($is_login == false) {
        return json([], '用户未登录', -1);
    } else {
// 执行操作

        // 根据 blog_id 获取博客信息
        $blog_id = empty($_POST['blog_id']) ? null : trim($_POST['blog_id']);
        if (empty($blog_id)) return json([], 'blog_id必须传入', -1);
        if (!is_numeric($blog_id)) return json([], 'blog_id必须为参数', -1);
        // 获取表单数据:
        $content = empty($_POST['content']) ? null : trim($_POST['content']);
        $title = empty($_POST['title']) ? null : trim($_POST['title']);
        if (empty($content)) return json([], '内容必须输入', -1);
        if (empty($title)) return json([], '标题必须输入', -1);

        // 执行修改
        $result = $db->query("update `blog` set `title` = '$title' AND `content`='$content'  where`id` = $blog_id");
        if ($result) {
            return json([], '修改成功');
        } else {
            return json([$db->errorInfo()], '数据库错误', -1);
        }
    }
}
return json([$_SERVER], '无效的接口', -1);

