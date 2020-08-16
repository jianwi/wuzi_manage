<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../class/admin1.php';
require_once ROOT . '/../class/admin2.php';
// require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$yb_headimg = $_SESSION['yb_headimg'];
// $token=$_SESSION['token'];
// echo "$token";
// echo "$yb_headimg";

$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);

if ($type < 2) {
	echo "你没有权限，快快走开！";
	return;
}
$oid = $_GET['oid'];
$admin2 = new admin2($yb_uid);
$db = $admin2->pdos();
$db->exec("set names utf8");
$sql = "select * from `order` left join user on order.yb_uid=user.yb_uid where oid='{$oid}'";
$result = $db->query($sql);
foreach ($result as $values) {
	$goods = $values['goods'];
	$goods = json_decode($goods);
	$goods0 = "";
	if (!empty($goods)) {
		foreach ($goods as $key => $value) {
			$goods0 .= $key;
			$goods0 .= ":";
			$goods0 .= $value;
			$goods0 .= "个</br>";
		}
	}
	$state = $values['state'];
	$date1 = $values['date'];
	$date = date("y/m/d H:i", $date1);
	$date2 = $values['date2'];
	$date2 = date("y/m/d H:i", $date2);
	$state = $values['state'];
	$name = $values['yb_name'];
	$xueyuan = $values['xueyuan'];
	$describe = $values['describe'];
	$uid = $values['yb_uid'];
	$yijian = $values['yijian'];

}
require_once '../html/detail.html';