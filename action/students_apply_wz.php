<meta charset="utf-8">
<?php
define('ROOT', __DIR__);
require_once ROOT . '/../config/database.php';

require_once ROOT . '/../class/tool.php';
require_once ROOT . '/../class/students.php';
// require_once ROOT . '/../config/back.html';

session_start();
$yb_uid = $_SESSION['yb_uid'];
$students = new students($yb_uid);
$yb_headimg = $_SESSION['yb_headimg'];

if (!isset($_GET['oid'])) {return;}

$oid = $_GET['oid'];

?>


<!DOCTYPE html>
<html>
<head>
	<title>物资管理系统</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../main.css">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img id="headimg" src="<?php echo $yb_headimg; ?>"/><br>
<h3>欢迎使用陕科大易班物资管理系统 v2.0</h2>
<br>


<!-- 先把所有的信息发过来，，然后只保留不为零的数据 -->

<form method="post" action="user_add_order.php?oid=<?php echo $oid; ?>">

<table width="100%">

	<?php
$students->look_goods();
?>
</table>
<br>
<input type="submit" value="提交申请">
</form>

</section>
Powered by <a href="http://jianwi.cn">jianwi.cn</a>
</body>

<script>
		// 给每个id写上序号o，然后访问第o个goods_count元素。

		function add(n){
		var o=n.id;
		var input_n=document.getElementsByClassName(`${n.id}`)[0];
		if(parseInt(input_n.value)>=parseInt(input_n.max)){
			return;
		}
		input_n.value=parseInt(input_n.value)+1;


		}

		function reduce(n){
		var o=n.id;
		var input_n=document.getElementsByClassName(`${n.id}`)[0];
		if(parseInt(input_n.value)<=0){
			return;
		}
		input_n.value=parseInt(input_n.value)-1;
		}
	</script>
</html>
