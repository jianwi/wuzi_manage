<?php
define('ROOT', __DIR__);
// 加载类
require_once 'sq.php';
require_once 'class/tool.php';
$tools = new tools($yb_uid);
$tools->load_class("students");
$tools->load_class("admin1");
$tools->load_class("admin2");
$tools->load_class("admin3");

$state = $tools->check_user($yb_uid);

if ($state == 0) {
	$is_sign = $tools->check_is_sign($yb_uid);
	if ($is_sign) {
		$students = new students($yb_uid);
		require_once 'html/students.html';
	} else {
		require_once 'html/zc.html';
	}
} elseif ($state == 1) {
	$admin1 = new admin1($yb_uid);
	require_once 'html/admin1.html';
} elseif ($state == 2) {
	$admin2 = new admin2($yb_uid);
	require_once 'html/admin2.html';
} elseif ($state == 3) {
	$admin3 = new admin3($yb_uid);
	require_once 'html/admin3.html';
}

// echo $tools->writeu($yb_uid, $yb_name, $yb_headimg, $yb_school);
