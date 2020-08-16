<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
// require_once ROOT . '/../class/admin2.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$token = $_SESSION['token'];

$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
if ($type < 1) {
	echo "你没有权限，快快走开！";
	return;
}

$admin1 = new admin1($yb_uid);
if (isset($_GET['y'])) {
	$state = $admin1->check_order_y($_GET['y']);
	if ($state) {
		echo "已审核通过oid为{$_GET['y']}的订单。";
	}
}
if (isset($_GET['n'])) {
	$state = $admin1->check_order_n($_GET['n']);
	if ($state) {
		echo "已拒绝oid为{$_GET['n']}的订单。";
	}
}

return;

$state2 = $admin2->yijian($yijian, $oid, $token, $uid);
if ($state2) {
	echo "</br>更新了您对此订单的意见";
}