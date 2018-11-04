<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../class/admin2.php';
// require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$token = $_SESSION['token'];
$check = $_POST['check'];
$oid = $_POST['oid'];
$yijian = $_POST['yijian'];
$uid = $_POST['uid'];

$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
if ($type < 2) {
	echo "你没有权限，快快走开！";
	return;
}

$admin2 = new admin2($yb_uid);
if ($check == 1) {
	$state = $admin2->check_order_y($oid);
	if ($state) {
		echo "已审核通过oid为{$oid}的订单。";
	}
}
if ($check == 0) {
	$state = $admin2->check_order_n($oid);
	if ($state) {
		echo "已拒绝oid为{$oid}的订单。";
	}
}
$state2 = $admin2->yijian($yijian, $oid, $token, $uid);
if ($state2) {
	echo "</br>更新了您对此订单的意见";
}
