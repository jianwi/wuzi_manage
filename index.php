<?php
require_once 'sq.php';
require_once 'class/tool.php';
$tools = new tools();
$state = $tools->check_user();
echo "<br>" . $state;
var_dump($state);
if ($state == 0) {
	echo "第一次写入";
	$tools->write_user;
}else{
	echo 123;
}
