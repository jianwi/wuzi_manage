<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$students = new students($yb_uid);
if (isset($_GET['cancel'])) {
	$state = $students->cancel_order($_GET['cancel']);
	if ($state) {
		echo "取消订单" . $_GET['cancel'] . "成功";
	} else {
		echo "取消失败，已确认的订单，或已审核的订单不支持取消";
	}
}
if (isset($_GET['confirm'])) {
	$state = $students->confirm_order($_GET['confirm']);
	if ($state) {
		echo "确认订单" . $_GET['confirm'] . "成功";
	}

}
