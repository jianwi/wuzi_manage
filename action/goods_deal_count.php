<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../class/admin2.php';
session_start();
$yb_uid = $_SESSION['yb_uid'];
$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
if ($type < 1) {
	echo "你没有权限，快快走开！";
	return;
}
$admin1 = new admin1($yb_uid);

$data = $_POST;
$goods = array();
foreach ($data as $key => $value) {
	$goods[$key] = $value;
}

$state = $admin1->change_count($goods);
echo "更新了{$state}个物料的数量";