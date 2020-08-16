<?php
/**
 * 第二类管理员,审核订单
 */
class admin2 extends admin1 {
	public $yb_uid;
	function __construct($yb_uid) {

		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
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
			// echo "</td><td>";
			// echo $name;
			echo "</td><td>";
			echo $xueyuan;
			echo "</td><td>";
			// $goods0=""
			// foreach ($goods as $key => $value) {
			// 	$goods0+=$key;
			// 	$goods0+=":";
			// 	$goods0+=$value;
			// 	$goods0+="个</br>";
			// }
			// echo "</td><td>";
			// echo "$describe";
			// echo "</td><td>";
			echo date("y/m/d H:i", $date);
			echo "</td><td>";
			echo $state;
			echo "</td><td>";
			echo "<a href='action/detail.php?oid={$oid}'>查看详情</a>";
			// echo "</td><td>";
			// echo "<a href='action/check.php?check_n={$oid}'>不通过</a>";
			// echo "</td></tr>";

		}
	}
// 全部订单
	public function look_all_orders() {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from `order` left join user on order.yb_uid=user.yb_uid order by oid desc";
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
			// $goods0=""
			// foreach ($goods as $key => $value) {
			// 	$goods0+=$key;
			// 	$goods0+=":";
			// 	$goods0+=$value;
			// 	$goods0+="个</br>";
			// }
			// echo "</td><td>";
			// echo "$describe";
			// echo "</td><td>";
			echo date("y/m/d H:i", $date);
			echo "</td><td>";
			echo date("y/m/d H:i", $date2);
			echo "</td><td>";
			echo $state;
			echo "</td><td>";
			echo "<a href='action/detail.php?oid={$oid}'>查看详情</a>";
			// echo "</td><td>";
			// echo "<a href='action/check.php?check_n={$oid}'>不通过</a>";
			// echo "</td></tr>";

		}
	}

//审核订单
	public function check_order_y($oid) {
		$db = $this->pdos();
		$date = time();
		$db->exec("set names utf8");
		$sql = "update `order` set state='通过' where oid='{$oid}'";
		$state = $db->exec($sql);
		$sql = "update `order` set date2='{$date}' where oid='{$oid}'";
		$state = $db->exec($sql);
		$yb_uid = $this->yb_uid;
		$text = "审核了订单号为{$oid}的订单";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}
// 拒绝订单
	public function check_order_n($oid) {
		$db = $this->pdos();
		$date = time();
		$db->exec("set names utf8");
		$sql = "update `order` set state='不准' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
		$sql = "update `order` set date2='{$date}' where oid='{$oid}'";
		$state = $db->exec($sql);

		$text = "拒绝了订单号为{$oid}的订单";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
	}
//删除订单
	public function cancel_order($oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select state from `order` where oid='{$oid}'";
		$result1 = $db->query($sql);
		$result = $result1->fetchColumn(0);
		if ($result == "待审核") {
			$sql = "delete from `order` where oid='{$oid}'";
			$state = $db->exec($sql);

			$text = "删除了订单号为{$oid}的订单";
			$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
			$db->exec($sql);
			return $state;} else {
			return false;
		}
	}
//写意见，发通知
	public function yijian($context, $oid, $token, $yb_uid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "update `order` set yijian='{$context}' where oid='{$oid}'";
		$state = $db->exec($sql);

		$state2 = $this->post_text($token, $yb_uid, $context);
		$state1 = json_decode($state2);
		echo "</br>消息发送状态:  " . $state1->status;
		return $state;

	}

}