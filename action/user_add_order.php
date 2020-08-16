<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$students = new students($yb_uid);

$oid = $_GET['oid'];
$data = $_POST;
$goods = array();
foreach ($data as $key => $value) {
	if ($value == 0) {
		continue;
	}
	if ($key == "describe") {
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
if (count($goods) < 1) {
	echo "什么都没有提交";
	return;
}
$state = $students->add_order($goods, $oid);
if ($state) {
	echo "提交成功";
}