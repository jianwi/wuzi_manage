<?php
/**
 * 第一类管理员，发布删除权限
 */
class admin1 extends tools {
	public $yb_uid;
	function __construct($yb_uid) {
		$this->yb_uid = $yb_uid;
	}
//查看产品
	public function look_goods() {
		$db = $this->pdos();
		$sql = "select * from goods";
		$data = $db->query($sql);

		foreach ($data as $value) {
			$id = $value['id'];
			$name = $value['name'];
			$count = $value['count'];
			$date1 = $value['date1'];
			$date2 = $value['date2'];

			echo "<tr><td>";
			echo $id;
			echo "</td><td>";
			echo $name;
			echo "</td><td>";
			echo $date1;
			echo "</td><td>";
			echo $date2;
			echo "</td><td>";
			echo "<input type='number' name='{$name}' value='{$count}'>";
			echo "</td>";
		}
	}

//添加产品
	public function add_goods($name, $count) {
		$db = $this->pdos();
		$sql = "insert into goods (name,count,date1,date2) values('{$name}','{$count}','{$date}','{$date}')";
		$state = $db->exec($sql);
		return $state;
	}
// 删除产品
	public function delete_goods($id) {
		$db = $this->pdos();
		$sql = "delete * from table where id='{$id}'";
		$state = $db->exec($sql);
	}
//改变数量
	public function change_count($id, $count) {
		$db = $this->pdos();
		$sql = "update goods set count='{$count}' where id='{$id}'";
		$state = $db->exec($sql);
		return $state;
	}
}