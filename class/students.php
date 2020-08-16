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

//添加物资

	public function add_order($text, $oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$yb_uid = $this->yb_uid;
		$date = $this->date;
		$limit_goods = array();
		$goods = array();
		foreach ($text as $key => $value) {
			$sql = "select `count` from goods where name='{$key}'";
			$result1 = $db->query($sql);

			$result = $result1->fetchColumn(0);

			// var_dump($result);
			$result = $result - $value;
			if ($result < 0) {
				$limit_goods[$key] = $result;
				continue;
			}
			$goods[$key] = $result;
			continue;
		}
		if (count($limit_goods) > 0) {
			echo "存在物件缺货";
			// print_r($limit_goods);
			return false;
		}

		foreach ($goods as $key => $value) {
			// echo "123";
			$sql = "UPDATE `goods` SET  `count` =  '{$value}' WHERE `name` = '{$key}'";
			$db->exec($sql);
		}
		$text = json_encode($text);
		$text = addslashes($text);
		$db->exec("set names utf8");

		$sql = "UPDATE `order` SET `goods`= '{$text}',`date2`='{$date}',`state`='待审核' WHERE `oid`='{$oid}'";
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
			return false;
		}
		// 上一版本，取消订单后，物资数返回
		// $sql = "select goods from `order` where oid='{$oid}'";
		// $result1 = $db->query($sql);
		// $result = $result1->fetchColumn(0);

		// $result = json_decode($result);
		// foreach ($result as $key => $value) {
		// 	$sql = "select `count` from `goods` where `name`='{$key}'";
		// 	$result1 = $db->query($sql);
		// 	$count = $result1->fetchColumn(0);
		// 	$count = $value + $count;
		// 	// var_dump($count);
		// 	$sql = "update `goods` set `count`='$count' where `name`='{$key}'";
		// 	$state = $db->exec($sql);
		// }

		$sql = "delete from `order` where oid='{$oid}'";
		$state = $db->exec($sql);
		return $state;

	}
//修改活动介绍
	public function change_describe($content, $oid) {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select state from `order` where oid='{$oid}'";
		$result1 = $db->query($sql);
		$result = $result1->fetchColumn(0);
		if ($result == "已确认") {
			echo "更新失败，已确认的订单不支持修改";
			return false;
		}

		$sql = "update `order` set `describe`='{$content}' where `oid`='{$oid}'";
		$result1 = $db->exec($sql);
		return $result1;

	}

// 查看物资
	public function look_goods() {
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from goods order by id";
		$data = $db->query($sql);

		foreach ($data as $value) {
			$id = $value['id'];
			$name = $value['name'];
			$count = $value['count'];
			$date = $value['date1'];
			$date2 = $value['date2'];
			$hide = $value['hide'];
			if ($hide == 1) {
				continue;
			}
			$date3 = date("y/m/d", $date);
			echo <<<html
			<div class="showGoods">
        <div class="top">
            {$name}
        </div>
        <div class="desc">
        	id:{$id}
        	<br>
            产品数量：{$count}
            <br>
            发布日期：{$date3}
        </div>
        <input type="button" id="{$id}" onclick="reduce(this)" value="-">
        <input type="number" value="0" name='{$name}'  class="{$id}" min="0" max="{$count}">
        <input type="button" id="{$id}" onclick="add(this)" value="+">
    </div>
html;
			// echo "<tr><td>";
			// echo $id;
			// echo "</td><td>";
			// echo
			// echo "</td><td>";
			// echo $name;
			// echo "</td><td>";
			// echo date("y/m/d-H:i", $date);
			// // echo "</td><td>";
			// // echo date("y/m/d H:i", $date2);
			// echo "</td><td>";
			// echo "<input type='number' name='{$name}' value='0' min='0'>";
			// echo "</td></tr>";
		}
	}

// 查看，处理订单
	public function look_mine() {
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "select * from `order` where yb_uid='{$yb_uid}' order by oid desc";
		$data = $db->query($sql);
		foreach ($data as $value) {
			$oid = $value['oid'];
			$goods = $value['goods'];
			$goods = json_decode($goods);
			$date = $value['date'];
			$date2 = $value['date2'];
			$state = $value['state'];
			// var_dump($goods);
			echo "<tr><td>";
			echo "<a href='action/detail_u.php?oid={$oid}'>" . $oid . "(详)</a>";
			echo "</td><td>";
			// foreach ($goods as $key => $value) {
			// 	echo $key;
			// 	echo ":";
			// 	echo $value;
			// 	echo "个</br>";
			// }
			// echo "</td><td>";
			echo date("y/m/d H:i", $date2);
			echo "</td><td>";
			echo $state;
			if ($state == "通过") {
				echo "</td><td>";
				echo "<a href='action/user_deal_order.php?confirm={$oid}'>确认收货</a>";
				echo "</td>";
			} elseif ($state == "文件待审核" || $state == "初审不过") {
				echo "</td><td>";
				echo "<a href='action/user_deal_order.php?cancel={$oid}'>取消订单</a>";
				echo "</td>";
			} elseif ($state == "待选择物资") {
				echo "</td><td>";
				echo "<a href='action/students_apply_wz.php?oid={$oid}'>挑物资</a>";
				echo "</td>";
			}
			echo "</tr>";
		}

		return;
	}

// 申请，生成订单
	function apply($file_tmp, $file_name, $access_token) {
		$date = $this->date;
		$describe = "http://wz.jianwi.cn/upload_file/{$file_name}";
		// $file_tmp2 = "upload_file/{$file_name}";
		// $this->upload_file($file_tmp2, $file_name, $access_token);
		$yb_uid = $this->yb_uid;
		$db = $this->pdos();
		$db->exec("set names utf8");
		$sql = "INSERT INTO `order`(`yb_uid`, `date`, `state`, `date2`,`describe`) VALUES ('{$yb_uid}','{$date}','文件待审核','{$date}','{$describe}')";
		$state = $db->exec($sql);
		return $state;

	}
// 上传文件到服务器
	function upload_file($file_tmp, $file_name) {
		// var_dump($file_tmp);

		$b = move_uploaded_file($file_tmp, "/www/web/wz_jianwi_cn/public_html/upload_file");
		var_dump($b);
		return "http://wz.jianwi.cn/upload_file/{$file_name}";
	}

// 上传文件到资料库
	function upload_file_to_yiban($file_tmp, $file_name, $access_token) {

		$file_name = "wz_" . $file_name;
		$post_fields = [
			'access_token' => $access_token,
			'file_name' => "$file_name",
			'file_tmp' => "@{$file_tmp}",
			'share_type' => 5,
		];

		$url = "https://openapi.yiban.cn/data/upload";
		$ch = curl_init($url);
		$opt = [
			CURLOPT_RETURNTRANSFER => 1, //返回一个字符串，而不是直接输出
			CURLOPT_SSL_VERIFYPEER => false, //不验证证书
			// CURLOPT_SSL_VERIFYSTATUS => false, //不验证证书状态
			CURLOPT_POST => true, //使用post
			CURLOPT_POSTFIELDS => $post_fields,
		];

		curl_setopt_array($ch, $opt);
		$r = curl_exec($ch);
		curl_close($ch);
		return json_decode($r)->info->view_url;
	}
}