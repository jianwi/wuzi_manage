<?php
/**
 * 第三类管理员
 */
class admin3 extends tools {

	public $yb_uid;
	function __construct($yb_uid) {
		$this->yb_uid = $yb_uid;
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
				echo "工作站学生";
			} elseif ($type == 2) {
				echo "工作站老师";
			} elseif ($type == 3) {
				echo "vip";
				echo "</td><td>删不了我的</td></tr>";
				continue;
			}
			echo "</td><td>";
			echo "<a href='action/manager.php?delete={$id}'>取消管理</a>";
			echo "</td></tr>";
		}
	}

//添加管理员

	public function add_manager($yb_uid, $type) {
		$db = $this->pdos();
		$sql = "insert into manage (yb_uid,type) values ('{$yb_uid}','{$type}')";
		$state = $db->exec($sql);
		return $state;
	}
//取消管理员
	public function cancel_manager($yb_uid) {
		$db = $this->pdos();
		$sql = "delete  from manage where yb_uid='{$yb_uid}'";
		$state = $db->exec($sql);
		return $state;
	}
}