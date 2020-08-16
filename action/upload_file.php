<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
require_once ROOT . '/../config/back.html';

//会话信息
session_start();
$yb_uid = $_SESSION['yb_uid'];
$access_token = $_SESSION['token'];
// 对象
$students = new students($yb_uid);
// 文件信息
$name = $_FILES['file']["name"];
$temp = $_FILES['file']["tmp_name"];
$error = $_FILES['file']["error"];
// 上传文件，生成订单
if ($error > 0) {
	die("文件上传失败 $error");
} else {
	if (move_uploaded_file($temp, "/www/web/wz_jianwi_cn/public_html/upload_file/{$name}")) {
		$students->apply($temp, $name, $access_token);
		echo "文件上传成功，请等待审核";
	} else {
		die("文件上传失败，请修改文件名字试试");
	}

}