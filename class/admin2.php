<?php
/**
 * 第二类管理员,审核订单
 */
class admin2 extends tools {

	public $yb_uid;
	function __construct($yb_uid) {
		$this->yb_uid = $yb_uid;
	}
// 处理订单，显示未处理的订单。
	public function look_new_orders() {
		$db = $this->pdos();
		$sql = "select * from order where state=1";
		$result = $db->query($sql);
		foreach ($result as $value) {

			$oid = $value['oid'];
			$goods = $value['goods'];
			$date = $value['date'];
			$date2 = $value['date2'];
			$state = $value['state'];

			echo "<tr><td>";
			echo $oid;
			echo "</td><td>";
			echo $goods;
			echo "</td><td>";
			echo $date;
			echo "</td><td>";
			echo $date2;
			echo "</td><td>";
			echo $state;
			echo "</td><td>";
			echo "<a href='?check_y={$oid}'>审核</a>";
			echo "</td><td>";
			echo "<a href='?check_n={$oid}'>拒绝</a>";
			echo "</td>";

		}
	}
// 查看所有订单
	public function look_all_orders() {
		$sql = "select * from order";
		$result = $db->query($sql);
		foreach ($result as $value) {

			$oid = $value['oid'];
			$goods = $value['goods'];
			$date = $value['date'];
			$date2 = $value['date2'];
			$state = $value['state'];

			echo "<tr><td>";
			echo $oid;
			echo "</td><td>";
			echo $goods;
			echo "</td><td>";
			echo $date;
			echo "</td><td>";
			echo $date2;
			echo "</td><td>";
			echo $state;
			echo "</td>";
		}
	}

//审核订单
	public function check_order_y($oid) {
		$db = $this->pdos();
		$sql = "update order set state='2' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
// 拒绝订单
	public function check_order_n($oid) {
		$db = $this->pdos();
		$sql = "update order set state='3' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
}