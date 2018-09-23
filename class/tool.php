<?php

class tools {

//初始化pdo
	private function pdos() {

		require_once '../config/database.php';

		try {
			$db = new PDO($dsn, $username, $passwd);
		} catch (PDOException $e) {
			die("couldn't connect to the database" . $e);
		}

		return $db;
	}

//用户信息写入数据库
	public function write_user($yb_uid, $yb_name, $yb_headimg, $yb_school) {
		$db = $this->pdos();
		$sql = "insert into user (yb_name,yb_uid,yb_headimg,yb_school) values('{$yb_name}','{$yb_uid}','{$yb_headimg}')";
		$result = $db->exec($sql);
		unset($db);
	}

//检验用户类型
	public function check_user($yb_uid, $table) {
		$db = $this->pdos;
		$sql = "select * from {$table} where yb_uid='{$yb_uid}'";
		$row = $db->query($sql);
		$row = $row->rownCount();
		if ($row = 0) {
			return $type = 0;
		}
		$sql = "select type from manage where yb_uid='{$yb_uid}'";
		$result = $db->query($sql);
		foreach ($result as $value) {
			$result = $value[0];
		}
		if ($result = 1) {
			return 1;
		}
		if ($result = 2) {
			return 2;
		}

	}

//初始化

}