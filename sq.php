<?php
/**
 * 轻应用授权
 * 在首页把用户数据写进数据库，全局文件的用户信息从数据库中获取
 */
if (!isset($_GET['yb_uid'])) {
	echo '<meta http-equiv="refresh" content="0;URL=http://f.yiban.cn/iapp271598">';
	// echo (' <meta http-equiv="refresh" content="0;url=http://f.yiban.cn/iapp200981">');
}
require "classes/yb-globals.inc.php";

//配置文件
require_once 'config/yb_token.php';
//初始化

$api = YBOpenApi::getInstance()->init($config['AppID'], $config['AppSecret'], $config['CallBack']);

$iapp = $api->getIApp();

try {
	//轻应用获取access_token，未授权则跳转至授权页面
	$info = $iapp->perform();
} catch (YBException $ex) {
	echo $ex->getMessage();
}

// 获取token，保存cookie
$token = $info['visit_oauth']['access_token']; //轻应用获取的token
$api->bind($token);

$userAll = $api->request("user/me"); //读取api

// 解析数组
$yb_username = $userAll["info"]["yb_username"]; //用户名
$yb_headimg = $userAll["info"]["yb_userhead"]; //头像，49位，string
$yb_school = $userAll["info"]["yb_schoolname"]; //学校名
// $yb_birth = $userAll["info"]["yb_regtime"]; //易班注册时间
// $yb_wx = $userAll["info"]["yb_money"]; //网新
// $yb_sex = $userAll["info"]["yb_sex"]; //一个字符，m
$yb_uid = $userAll["info"]["yb_userid"]; //id

session_start();
$_SESSION['yb_uid'] = $yb_uid;
$_SESSION['token'] = $token;
$_SESSION['yb_headimg'] = $yb_headimg;
$_SESSION['yb_school'] = $yb_school;

?>