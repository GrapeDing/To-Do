<?php

header('content-type:text/html;charset=utf-8');
mysql_set_charset('utf8');
require_once("config.php");

$link = mysql_connect($localhost,$USERNAME,$DBPASS);
mysql_query("set names 'utf8'",$link);
mysql_select_db($DBNAME);

$id = $_POST['id'];
$tagid = $_POST['tagid'];
$uid = $_POST['uid'];
$info = $_POST['info'];
$state = $_POST['state'];
$createtime = $_POST['createtime'];
$alerttime = $_POST['alerttime'];
$sort = $_POST['sort'];

$sql = "update todolist set tagid=$tagid,uid=$uid,info='{$info}',state=$state,createtime=$createtime,alerttime=$alerttime,sort=$sort where id=$id";

$result = mysql_query($sql);
if ($result) {
    $result = 0;
}else{
    $result = 1;
}
$arr = array(
		'result' => $result
	);
$strr = json_encode($arr);
mysql_close($link);
echo($strr);

?>
