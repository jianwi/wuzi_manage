<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/admin1.php';
session_start();
$yb_uid = $_SESSION['yb_uid'];
$admin1 = new admin1($yb_uid);
