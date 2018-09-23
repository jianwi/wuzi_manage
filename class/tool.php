<?php

class tools {
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