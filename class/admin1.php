<?php
/**
 * 第一类管理员，发布删除权限
 */

class admin1 extends students {
	public $yb_uid;
	public $date;
	function __construct($yb_uid) {
		date_default_timezone_set("Asia/Shanghai");
		$date = time();
		$this->date = $date;
		$this->yb_uid = $yb_uid;
	}
//查看产品
	public function look_goods() {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from goods order by id";
		$data = $db->query($sql);

		foreach ($data as $value) {
			$id = $value['id'];
			$name = $value['name'];
			$count = $value['count'];
			$date1 = $value['date1'];
			$date2 = $value['date2'];
			$hide = $value['hide'];

			echo "<tr><td>";
			echo $id;
			echo "</td><td>";
			echo $name;
			echo "</td><td>";
			echo date("y/m/d", $date1);
			echo "</td><td>";
			echo date("y/m/d", $date2);
			echo "</td><td>";
			echo "<input type='number' style='width:3.6rem; text-align:center;' name='{$id}' value='{$count}' min='0'>";
			echo "</td><td>";

			if ($hide == 0) {
				echo "<a href='action/goods_hide.php?hide={$id}'>显</a>";
			} else {
				echo "<a href='action/goods_hide.php?show={$id}'>隐</a>";
			}
			echo "</td><td>";
			echo "<a href='action/goods_delete.php?id={$id}' style='background:yellow;color:red'  class='delete'>删</a>";
			echo "</td></tr>";
		}
	}

// 查看所有订单
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
			// echo $name;
			// echo "</td><td>";
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
			// echo date("y/m/d H:i", $date);
			// echo "</td><td>";
			echo date("y/m/d H:i", $date2);
			echo "</td><td>";
			echo $state;
			echo "</td><td>";
			echo "<a href='action/detail_u.php?oid={$oid}'>详情</a>";
			// echo "</td><td>";
			// echo "<a href='action/check.php?check_n={$oid}'>不通过</a>";
			// echo "</td></tr>";

		}
	}

//添加产品
	public function add_goods($name, $count, $hide) {
		$db = $this->pdos();
		$yb_uid = $this->yb_uid;
		$db->exec("set names utf8");
		$date = $this->date;
		$sql = "insert into goods (name,count,date1,date2,hide) values('{$name}','{$count}','{$date}','{$date}','{$hide}')";
		$state = $db->exec($sql);
		$text = "添加了{$count}个{$name}";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}
// 删除产品
	public function delete_goods($id) {
		$db = $this->pdos();
		$yb_uid = $this->yb_uid;
		$sql = "delete from `goods` where id='{$id}'";
		$state = $db->exec($sql);
		$date = $this->date;
		$text = "删除了id为{$id}的产品";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}
//改变数量
	public function change_count($data) {
		$db = $this->pdos();
		$yb_uid = $this->yb_uid;
		$date = $this->date;
		$states = 0;
		$text = "";
		foreach ($data as $key => $value) {
			$sql = "update goods set count='$value}' where id='{$key}'";
			$state = $db->exec($sql);
			if ($state == 1) {
				$sql = "update goods set date2 ='{$date}' where id='{$key}'";
				$db->exec($sql);

				$text .= "更改{$key}的数量为{$value}";
			}
			$states = $state + $states;
		}

		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);

		return $states;
	}
//显示/隐藏
	function show_or_hide($id, $show_or_hide) {
		$db = $this->pdos();
		$yb_uid = $this->yb_uid;
		$date = $this->date;

		$sql = "update   `goods` set hide= '{$show_or_hide}' where id='{$id}'";
		$state = $db->exec($sql);
		if ($state == 1) {
			$text = "修改{$id}的hide（隐藏）状态为{$show_or_hide}";
		}

		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);

		return $state;

	}

//审核订单
	public function check_order_y($oid) {
		$db = $this->pdos();
		$date = time();
		$db->exec("set names utf8");
		$sql = "update `order` set state='待选择物资' where oid='{$oid}'";
		$state = $db->exec($sql);
		$sql = "update `order` set date2='{$date}' where oid='{$oid}'";
		$state = $db->exec($sql);
		$yb_uid = $this->yb_uid;
		$text = "初审通过，订单号为{$oid}";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
		return $state;
	}
// 拒绝订单
	public function check_order_n($oid) {
		$db = $this->pdos();
		$date = time();
		$db->exec("set names utf8");
		$sql = "update `order` set state='初审不过' where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;
		$sql = "update `order` set date2='{$date}' where oid='{$oid}'";
		$state = $db->exec($sql);

		$text = "初审不过，订单号为{$oid}";
		$sql = "insert into `logs` (yb_uid,date,text) values('{$yb_uid}','{$date}','{$text}')";
		$db->exec($sql);
	}

}