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
if ($type < 1) {
	echo "你没有权限，快快走开！";
	return;
}
$admin1 = new admin1($yb_uid);
$name = $_POST['goods'];
$count = $_POST['count'];
$state = $admin1->add_goods($name, $count);
if ($state) {
	echo "添加成功<br>商品：{$name}<br>数量:{$count}";
}
