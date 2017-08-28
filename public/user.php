<?php
/**
 * 用户接口
 * 注册 register
 * 登陆 login
 * 获取自己信息 get_self_info
 * 获取用户信息 get_user_info
 * User: ZT
 * Date: 2017/8/26
 * Time: 22:26
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

// 执行操作

if ($action == 'register') {
    // 注册操作

    // 获取表单数据k
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // todo 数据验证...

    if($user_name==""||$password=="")            //判断输入是否为空
    {
        echo "用户名或密码为空，请输入用户名和密码进行注册.";
        echo "<a href=\"index.php\">确定</a>";
        exit ();
    }

    //  验证用户名是否被使用
    function name($user_name)
    {
        if (empty($user_name)) return false; //是否已存在
        return true;
    }

    //  password 处理成密文

    $pwd = $_POST['password'];
    $hash = password_hash($pwd, PASSWORD_DEFAULT);

    /**解密是
    if (password_verify($pwd,$hash)) {
    echo "密码正确";
} else {
    echo "密码错误";
}
     */

    $result = $db->exec("insert into users values (null, '$user_name', '$password', null, null)");
    if ($result == 1) {
        return json([], '注册成功');
    } else {
        return json([$db->errorInfo()], '注册失败', -1);
    }
}
    // todo 登陆操作

   //获取自己信息 get_self_info

if ($action == 'get_self_info'){

    //验证POST值是否存在
    if(!empty($_POST['id'])){
        $en=$_POST['id'];
    }else{
        echo "输入为空";
        exit();
    }

   //执行查询
    $result1 = $db->query( "select * from users where user_name = $en");
    if ($result1 == 1) {
        return json([], '读取成功');
    } else {
        return json([$db->errorInfo()], '读取失败', -1);
    }
}

//获取用户信息 get_user_info
if ($action == 'get_user_info'){

    //通过id获取相关信息
    $id = $_POST['id'];

    //验证POST值是否存在
    if(!empty($_POST['id'])){
        $en=$_POST['id'];
    }else{
        echo "输入为空";
        exit();
    }

    //执行查询
    $result1 = $db->query( "select * from users where id = $id");

    if ($result1 == 1) {
        return json([], '读取成功');
    } else {
        return json([$db->errorInfo()], '读取失败', -1);
    }
}