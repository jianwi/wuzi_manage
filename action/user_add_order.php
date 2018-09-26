<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
session_start();
$yb_uid = $_SESSION['yb_uid'];
$students = new students($yb_uid);

$data = $_POST;
$goods = array();
foreach ($data as $key => $value) {
	if ($value == 0) {
		continue;
	}
	$goods[$key] = $value;
}
echo "我的订单\n";
foreach ($goods as $key => $value) {
	echo $key;
	echo ":";
	echo $value;
	echo "个\n";
}

$state = $students->add_order($goods);
if ($state) {
	echo "提交成功";
}