<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$admin1 = new admin1($yb_uid);

if (isset($_GET['hide'])) {
	$id = $_GET['hide'];

	$state = $admin1->show_or_hide($id, 1);
	if ($state) {
		echo "成功设置id为{$id}的产品为隐藏状态";
	}
	return;

}

if (isset($_GET['show'])) {
	$id = $_GET['show'];
	if ($admin1->show_or_hide($id, 0)) {
		echo "成功让id为{$id}的产品显示";
	}

}
