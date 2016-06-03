<?php
header('content-type:text/html;charset=utf-8');
mysql_set_charset('utf8');
require_once("config.php");

$link = mysql_connect($localhost,$USERNAME,$DBPASS);
mysql_query("set names 'utf8'",$link);
mysql_select_db($DBNAME);

$tagid = $_POST['tagid'];
$uid = $_POST['uid'];
$info = $_POST['info'];
$state = $_POST['state'];
$createtime = $_POST['createtime'];
$alerttime = $_POST['alerttime'];
$sort = $_POST['sort'];
$timearr = getdate($_POST['alerttime']);
$mday = $timearr['mday'];
$mon = $timearr['mon'];
$year = $timearr['year'];
$month = 'month'.$mon;
$temp = 1 << ($mday-1);

$sql1 = "insert into todolist(tagid,uid,info,state,createtime,alerttime,sort) values($tagid,$uid,'{$info}',$state,$createtime,$alerttime,$sort)";

$r = mysql_query($sql1);

$todoid = mysql_insert_id();

if ($r) {
    $result = 0;
    
    $sql ="select {$month} from calendar where uid = '{$uid}' and year='{$year}'";
    $r = mysql_query($sql);
    if($r && mysql_num_rows($r)){
        $old=mysql_result($r,0);
        $new = $old|$temp;
        $sql3 = "update calendar set {$month} = $new where uid = '{$uid}' and year='{$year}'";
        $r=mysql_query($sql3);
    }else{
        $sql1 = "insert into calendar(uid,year,{$month}) values('{$uid}','{$year}','{$temp}')";
        $r = mysql_query($sql1);
    }
    
}else{
    $result = 1;
}
$arr = array(
		'result' => $result,
        'id' => $todoid
	);
$strr = json_encode($arr);
mysql_close($link);
echo($strr);

?>
