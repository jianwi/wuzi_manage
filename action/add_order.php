<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
session_start();
$yb_uid = $_SESSION['yb_uid'];
$students = new students($yb_uid);

$data = $_POST;
$goods = "";
foreach ($data as $key => $value) {
	if ($value == 0) {
		continue;
	}
	$goods .= "{$key}x{$value}\n";
}

echo "$goods";
$state = $students->add_order($goods);
if ($state) {
	echo "提交成功";
}