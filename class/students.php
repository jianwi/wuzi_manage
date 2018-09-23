<?php
/**
 * 学生类
 */
class students extends tools {
	public $yb_uid;
	public $date;
	function __construct($yb_uid) {
		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
		$this->yb_uid = $yb_uid;
	}

// 检查用户是否注册
	public function check_is_sign() {
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$sql = "select * from user where yb_uid='{$yb_uid}'";
		$row1 = $db->query($sql);
		$row = $row1->rowCount();
		if ($row == 0) {
			return false;
		} else {
			return $row;
		}

	}

//用户信息写入数据库
	public function writeu($yb_uid, $yb_name, $yb_headimg, $yb_school) {
		$db = $this->pdos();
		$sql = "select * from user where yb_uid='{$yb_uid}'";
		$row1 = $db->query($sql);
		$row = $row1->rowCount();
		if ($row == 0) {
			$db->exec('set names utf8');
			$sql = "insert into user (yb_name,yb_uid,yb_headimg,yb_school) values('{$yb_name}','{$yb_uid}','{$yb_headimg}','{yb_school}')";
			$result = $db->exec($sql);
			return "success writeu";
		} else {
			return "fail,user hava exist in table";
		}
	}
//添加订单

	public function add_order($text) {
		$db = $this->pdos();
		$date = $this->date;
		$sql = "insert into order (yb_uid,goods,date,state) values('{$yb_uid}','{$text}','{$date}','1')";
		$state = $db->exec($sql);
		return $state;
	}

// 确认收货
	public function confirm_order($oid) {
		$db = $this->pdos();
		$sql = "update order set state='4' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
	}
// 查看物资
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
			echo "<input type='number' name='{$name}' value='0'>";
			echo "</td>";
		}
	}

// 查看，处理订单
	public function look_mine() {
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$sql = "select * from order where yb_uid='{$yb_uid}'";
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
			if ($state == 2) {
				echo "</td><td>";
				echo "<a href='?confirm={$oid}'>确认收货</a>";
				echo "</td>";
			} elseif (state == 1) {
				echo "</td><td>";
				echo "<a href='?cancel={$oid}'>取消订单</a>";
				echo "</td>";
			}
		}

		return;
	}
}
