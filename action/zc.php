<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$yb_name = $_POST['name'];
$xueyuan = $_POST['xueyuan'];
$phone = $_POST['phone'];
$yb_school = $_SESSION['yb_school'];
$yb_headimg = $_SESSION['yb_headimg'];
$yb_school = $_SESSION['yb_school'];
echo "$yb_name";
echo "$xueyuan";
$students = new tools($yb_uid);
$w = $students->writeu($yb_uid, $yb_name, $xueyuan, $yb_school, $phone);
if ($w) {
	echo "注册成功";
} else {
	echo "注册失败";
}
