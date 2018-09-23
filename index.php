<?php
require_once 'sq.php';
require_once 'class/tool.php';
require_once 'class/students.php';
$yb_uid = $_SESSION['yb_uid'];
$tools = new students($yb_uid);
$is_sign = $tools->check_is_sign($yb_uid);
var_dump($is_sign);
// echo $tools->writeu($yb_uid, $yb_name, $yb_headimg, $yb_school);
$state = $tools->check_user($yb_uid);
// echo "$state";
var_dump($state);