<?php
/**
 * 第一类管理员，发布删除权限
 */

class admin1 extends students {
	public $yb_uid;
	public $date;
	function __construct($yb_uid) {
		$this->yb_uid = $yb_uid;
		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
	}
//查看产品
	public function look_goods() {
		$db = $this->pdos();
		$db->exec("set names utf8");
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
			echo date("y-m-d H:i", $date1);
			echo "</td><td>";
			echo date("y-m-d H:i", $date2);
			echo "</td><td>";
			echo "<input type='number' name='{$id}' value='{$count}'>";
			echo "</td><td>";
			echo "<a href='action/goods_delete.php?id={$id}'>删除</a>";
			echo "</td></tr>";
		}
	}
// 查看所有订单
	public function look_all_orders() {
		// $i = $n - 10;
		$db = $this->pdos();
		$db->exec("set names utf8");
		// $sql = "select * from `order` left join user on order.yb_uid=user.yb_uid order by oid desc limit {$i},{$n}";
		$sql = "select * from `order` left join user on order.yb_uid=user.yb_uid order by oid desc";
		$result = $db->query($sql);
		$data = $db->query($sql);
		foreach ($data as $value) {
			$oid = $value['oid'];
			$goods = $value['goods'];
			$goods = json_decode($goods);
			$date = $value['date'];
			$date2 = $value['date2'];
			$state = $value['state'];
			$name = $value['yb_name'];
			$xueyuan = $value['xueyuan'];

			echo "<tr><td>";
			echo $oid;
			echo "</td><td>";
			echo $name;
			echo "</td><td>";
			echo $xueyuan;
			echo "</td><td>";
			foreach ($goods as $key => $value) {
				echo $key;
				echo ":";
				echo $value;
				echo "个\n";
			}
			echo "</td><td>";
			echo date("y/m/d-H:i", $date);
			echo "</td><td>";
			echo date("y/m/d-H:i", $date2);
			echo "</td><td>";
			echo $state;
			echo "</td></tr>";
		}
	}

//添加产品
	public function add_goods($name, $count) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$date = $this->date;
		$sql = "insert into goods (name,count,date1,date2) values('{$name}','{$count}','{$date}','{$date}')";
		$state = $db->exec($sql);
		return $state;
	}
// 删除产品
	public function delete_goods($id) {
		$db = $this->pdos();
		$sql = "delete from `goods` where id='{$id}'";
		$state = $db->exec($sql);
		return $state;
	}
//改变数量2
	public function change_count($data) {
		$db = $this->pdos();
		$date = $this->date;
		$states = 0;
		foreach ($data as $key => $value) {
			$sql = "update goods set count='{$value}' where id='{$key}'";
			$state = $db->exec($sql);
			if ($state == 1) {
				$sql = "update goods set date2 ='{$date}' where id='{$key}'";
				$db->exec($sql);
			}
			$states = $state + $states;
		}

		return $states;
	}
}