<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
// require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$token = $_SESSION['token'];

$uid = isset($_GET['uid']) ? $_GET['uid'] : "";
$content = isset($_POST['content']) ? $_POST['content'] : "";
$yb_headimg = $_SESSION['yb_headimg'];
// $token=$_SESSION['token'];
// echo "$token";
// echo "$yb_headimg";

$tools = new tools($yb_uid);
$type = $tools->check_user($yb_uid);

if ($type < 0) {
	echo "你没有权限，快快走开！";
	return;
}
$students = new students($yb_uid);
require_once '../html/chat.html';
if (!isset($_POST['content'])) {
	return;
}
$state = $students->post_text($token, $uid, $content);
$state = json_decode($state);
echo "发送状态 : " . $state->status;
