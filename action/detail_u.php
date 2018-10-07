<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
// require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$yb_headimg = $_SESSION['yb_headimg'];
// $token=$_SESSION['token'];
// echo "$token";
// echo "$yb_headimg";

$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);
$tz = "";
$xiugai = "";

$oid = $_GET['oid'];
$students = new students($yb_uid);
$db = $students->pdos();
$db->exec("set names utf8");
$sql = "select * from `order` left join user on order.yb_uid=user.yb_uid where oid='{$oid}'";
$result = $db->query($sql);
foreach ($result as $values) {
	$goods = $values['goods'];
	$goods = json_decode($goods);
	$goods0 = "";
	foreach ($goods as $key => $value) {
		$goods0 .= $key;
		$goods0 .= ":";
		$goods0 .= $value;
		$goods0 .= "个</br>";
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
if ($type > 0) {
	$tz = "<a href='chat.php?uid={$uid}'>发送通知</a>";
} else {
	$describe = "<textarea name='describe' cols='30' rows='3'>{$describe}</textarea>";
	$xiugai = "<input type='submit' value='提交修改'>";
}

require_once '../html/detail_u.html';

if (!isset($_POST['describe'])) {
	return;
}
$content = $_POST['describe'];
$state = $students->change_describe($content, $oid);
if ($state) {
	echo "更新订单成功。刷新页面即可看到最新结果";
}