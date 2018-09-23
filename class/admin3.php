<?php
/**
 * 第三类管理员
 */
class admin3 extends tools {

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
		$sql = "delete * from manage where yb_uid='{$yb_uid}'";
		$state = $db->exec($sql);
		return $state;
	}
}