<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../class/admin2.php';
require_once ROOT . '/../class/admin3.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
if ($type < 3) {
	echo "你没有权限，快快走开！";
	return;
}

$admin3 = new admin3($yb_uid);
if (isset($_POST['yb_uid']) && isset($_POST['type'])) {
	$state = $admin3->add_manager($_POST['yb_uid'], $_POST['type']);
	if ($state) {
		echo "成功设置易班账号为{$yb_uid}的用户为第{$_POST['type']}类管理员";
	}
}

if (isset($_GET['delete'])) {
	$state = $admin3->cancel_manager($_GET['delete']);
	if ($state) {
		echo "成功取消了易班账号为{$_GET['delete']}的管理员身份";
	}
}
