<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../class/admin2.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
if ($type < 2) {
	echo "你没有权限，快快走开！";
	return;
}
$admin2 = new admin2($yb_uid);
if (isset($_GET['check_y'])) {
	$id = $_GET['check_y'];
	$state = $admin2->check_order_y($id);
	if ($state) {
		echo "已审核通过id为{$id}的订单。";
	}
}
if (isset($_GET['check_n'])) {
	$id = $_GET['check_n'];
	$state = $admin2->check_order_n($id);
	if ($state) {
		echo "已拒绝id为{$id}的订单。";
	}
}
