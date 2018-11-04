<?php

class tools {
	public $dsn;
	public $username;
	public $passwd;
	public $yb_uid;
	public $date;

// 构造函数
	function __construct($yb_uid) {

		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
		$this->yb_uid = $yb_uid;
	}

//初始化pdo

	function pdos() {

		// $dsn = $this->dsn;
		// $username = $this->username;
		// $passwd = $this->passwd;

		try {
			$db = new PDO(dsn, username, passwd);
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
	public function writeu($yb_uid, $yb_name, $xueyuan, $yb_school, $phone) {
		$db = $this->pdos();
		$sql = "select * from user where yb_uid='{$yb_uid}'";
		$row1 = $db->query($sql);
		$row = $row1->rowCount();
		if ($row == 0) {
			$db->exec('set names utf8');
			$sql = "insert into user (yb_name,yb_uid,yb_school,xueyuan,phone) values('{$yb_name}','{$yb_uid}','{$yb_school}','{$xueyuan}','{$phone}')";
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
			return 0;
		} elseif ($result1 > 0) {
			foreach ($result as $value) {
				// var_dump($value);
				// echo "<br>sss";
				$result = $value[0];
				return $result;
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
//发送消息
	function post_text($token, $yb_uid, $content) {
		$url = "https://openapi.yiban.cn/msg/letter";
		$data = array('access_token' => "{$token}", 'to_yb_uid' => "{$yb_uid}", 'content' => "{$content}");
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

}