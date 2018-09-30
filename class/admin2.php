<?php
/**
 * 第二类管理员,审核订单
 */
class admin2 extends admin1 {
	public $yb_uid;
	function __construct($yb_uid) {
		$this->yb_uid = $yb_uid;
	}
// 处理订单，显示未处理的订单。
	public function look_new_orders() {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from `order` left join user on order.yb_uid=user.yb_uid where state='待审核' order by oid desc";
		$result = $db->query($sql);
		foreach ($result as $value) {
			$oid = $value['oid'];
			$goods = $value['goods'];
			$goods = json_decode($goods);
			$date = $value['date'];
			$date2 = $value['date2'];
			$state = $value['state'];
			$name = $value['yb_name'];
			$xueyuan = $value['xueyuan'];
			$describe = $value['describe'];

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
				echo "个</br>";
			}
			echo "</td><td>";
			echo "$describe";
			echo "</td><td>";
			echo date("y/m/d H:i", $date);
			echo "</td><td>";
			echo $state;
			echo "</td><td>";
			echo "<a href='action/check.php?check_y={$oid}'>审核通过</a>";
			echo "</td><td>";
			echo "<a href='action/check.php?check_n={$oid}'>不通过</a>";
			echo "</td></tr>";

		}
	}

//审核订单
	public function check_order_y($oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "update `order` set state='通过' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
// 拒绝订单
	public function check_order_n($oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "update `order` set state='不准' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
}