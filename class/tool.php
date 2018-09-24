<?php

class tools {

	public $yb_uid;
	public $date;
	function __construct($yb_uid) {
		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
		$this->yb_uid = $yb_uid;
	}

//初始化pdo

	function pdos() {
		$dsn = "mysql:dbname=bdm285551132_db;host=bdm285551132.my3w.com;port=3306";
		$username = "bdm285551132";
		$passwd = "54dudashen";

		try {
			$db = new PDO($dsn, $username, $passwd);
		} catch (PDOException $e) {
			die("couldn't connect to the database" . $e);
		}
		return $db;
	}

//加载类
	function load_class($file) {

		require_once ROOT . '/class/' . $file . '.php';
	}
//检验是否注册
	public function check_is_sign() {
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$sql = "select * from user where yb_uid='{$yb_uid}'";
		$row1 = $db->query($sql);
		$row = $row1->rowCount();
		if ($row == 0) {
			return false;
		} else {
			return true;
		}

	}
//用户信息写入数据库
	public function writeu($yb_uid, $yb_name, $xueyuan, $yb_school) {
		$db = $this->pdos();
		$sql = "select * from user where yb_uid='{$yb_uid}'";
		$row1 = $db->query($sql);
		$row = $row1->rowCount();
		if ($row == 0) {
			$db->exec('set names utf8');
			$sql = "insert into user (yb_name,yb_uid,yb_school,xueyuan) values('{$yb_name}','{$yb_uid}','{$yb_school}','{$xueyuan}')";
			$result = $db->exec($sql);
			return true;
		} else {
			return false;
		}
	}
//检验用户类型
	public function check_user($yb_uid) {
		$db = $this->pdos();
		$sql = "select type from manage where yb_uid='{$yb_uid}'";
		$result = $db->query($sql);
		$result1 = $result->rowCount();
		if ($result1 == 0) {
			return $result1;
		} elseif ($result1 > 0) {
			foreach ($result as $value) {
				var_dump($value);
				echo "<br>sss";
				$result = $value[0];
				return $value;
			}
			if ($result == 1) {
				return 1;
			}
			if ($result == 2) {
				return 2;
			}
			return false;
		}
	}
}