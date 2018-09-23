<?php
	// 授权轻应用
	require "classes/yb-globals.inc.php";

	//配置文件
	require_once 'config/config.php';
	
	//初始化
	$api = YBOpenApi::getInstance()->init($config['AppID'], $config['AppSecret'], $config['CallBack']);
	$iapp  = $api->getIApp();
	
	try {
	   //轻应用获取access_token，未授权则跳转至授权页面
	   $info = $iapp->perform();
	} catch (YBException $ex) {
	   echo $ex->getMessage();
	}
	
	
	$token = $info['visit_oauth']['access_token'];//轻应用获取的token
?>