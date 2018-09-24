<meta charset="utf-8">
<?php
/**
 * 学生类
 */
class students extends tools {
	public $yb_uid;
	public $date;
	public $name;
	public $xueyuan;
//构造函数
	function __construct($yb_uid) {
		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
		$this->yb_uid = $yb_uid;
		$db = $this->pdos();
		$sql = "select yb_name from user where yb_uid='{$yb_uid}'";
		$name1 = $db->query($sql);
		$name = $name1->fetchColumn(0);
		$this->name = $name;
		$sql = "select xueyuan from user where yb_uid='{$yb_uid}'";
		$xueyuan1 = $db->query($sql);
		$xueyuan = $xueyuan1->fetchColumn(0);
		$this->xueyuan = $xueyuan1;
	}

//添加订单

	public function add_order($text) {
		$db = $this->pdos();
		$yb_uid = $this->yb_uid;
		$date = $this->date;
		$db->exec("set names utf8");
		$sql = "INSERT INTO `order`(`goods`, `yb_uid`, `date`, `state`, `date2`) VALUES ('{$text}','{$yb_uid}','{$date}','待审核','{$date}')";
		$state = $db->exec($sql);

		// var_dump($yb_uid);
		// var_dump($text);
		// var_dump($date);
		// var_dump($state);
		return $state;
	}

// 确认收货
	public function confirm_order($oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "update `order` set state='已确认' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
//取消订单
	public function cancel_order($oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select state from `order` where oid='{$oid}'";
		$result1 = $db->query($sql);
		$result = $result1->fetchColumn(0);
		if ($result == "待审核") {
			$sql = "delete from `order` where oid='{$oid}'";
			$state = $db->exec($sql);
			return $state;} else {
			return false;
		}
	}

// 查看物资
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
			echo $count;
			echo "</td><td>";
			echo $date1;
			echo "</td><td>";
			echo $date2;
			echo "</td><td>";
			echo "<input type='number' name='{$name}' value='0'>";
			echo "</td>";
		}
	}

// 查看，处理订单
	public function look_mine() {
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from `order` where yb_uid='{$yb_uid}'";
		$data = $db->query($sql);
		foreach ($data as $value) {
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
			if ($state == "已审核") {
				echo "</td><td>";
				echo "<a href='action/user_order.php?confirm={$oid}'>确认收货</a>";
				echo "</td>";
			} elseif ($state == "待审核") {
				echo "</td><td>";
				echo "<a href='action/user_order.php?cancel={$oid}'>取消订单</a>";
				echo "</td>";
			}
			echo "</tr>";
		}

		return;
	}
}
