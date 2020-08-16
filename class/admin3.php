<?php
/**
 * 第三类管理员
 */
class admin3 extends tools {

	public $yb_uid;
	public $date;

	function __construct($yb_uid) {
		// require "/config/database.php";
		// $this->dsn = $dsn;
		// $this->username = $username;
		// $this->passwd = $passwd;
		$this->yb_uid = $yb_uid;

		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;

	}
// 查看管理
	public function look_manager() {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select manage.yb_uid,phone,yb_name,xueyuan,type from manage left join user on manage.yb_uid=user.yb_uid";
		$result = $db->query($sql);
		// var_dump($result);
		foreach ($result as $value) {
			$id = $value['yb_uid'];
			$phone = $value['phone'];
			$name = $value['yb_name'];
			$xueyuan = $value['xueyuan'];
			$type = $value['type'];
			echo "<tr><td>";
			echo $id;
			echo "</td><td>";
			echo $name;
			echo "</td><td>";
			echo "$phone";
			echo "</td><td>";
			if ($type == 1) {
				echo "学生";
			} elseif ($type == 2) {
				echo "老师";
			} elseif ($type == 3) {
				echo "vip";
				echo "</td><td>禁删</td></tr>";
				continue;
			}
			echo "</td><td>";
			echo "<a href='action/manager.php?delete={$id}'>取消管理</a>";
			echo "</td></tr>";
		}
	}

//添加管理员

	public function add_manager($yb_uid, $type) {
		$yb = $this->yb_uid;
		$db = $this->pdos();
		$date = $this->date;
		$db->exec("set names utf8");
		$sql = "insert into manage (yb_uid,type) values ('{$yb_uid}','{$type}')";
		$state = $db->exec($sql);

		$text = "添加{$yb_uid}为{$type}类管理员";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}
//取消管理员
	public function cancel_manager($yb_uid) {
		$yb = $this->yb_uid;
		$db = $this->pdos();
		$date = $this->date;
		$sql = "delete  from manage where yb_uid='{$yb_uid}'";
		$state = $db->exec($sql);

		$text = "取消{$yb_uid}的管理员身份";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}

//查看日志
	public function check_log($n) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "SELECT logs.id, logs.yb_uid, yb_name, logs.date, TEXT
FROM  `logs`
LEFT JOIN user ON logs.yb_uid = user.yb_uid
ORDER BY id DESC
LIMIT {$n}, 20";
		$result = $db->query($sql);
		foreach ($result as $value) {
			echo "<tr><td>";
			echo $value['id'];
			echo "</td><td>";
			echo ($value['yb_name']);
			echo "(" . $value['yb_uid'] . ")";
			echo "</td><td>";
			echo date("y/m/d H:i", $value['date']);
			echo "</td><td>";
			echo $value['TEXT'];
			echo "</td><td>";

		}

	}
}