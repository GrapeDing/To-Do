<?php
header('content-type:text/html;charset=utf-8');
mysql_set_charset('utf8');
require_once("config.php");

$link = mysql_connect($localhost,$USERNAME,$DBPASS);
mysql_query("set names 'utf8'",$link);
mysql_select_db($DBNAME);

$uid = $_POST['uid'];
$year = $_POST['year'];
$mon = $_POST['mon'];
$month = 'month'.$mon;
$data = 0;
$sql = "select {$month} from calendar where (uid = $uid and year = '{$year}' ) ";
$r = mysql_query($sql);

if($r == true){
    if(mysql_num_rows($r)){
        $data=mysql_result($r,0);
        $result = 0;
    }else{
        $result = 2;
    }
}else{
    $result = 1;//0 OK ,1 NG
}

$arr = array(
    'result' => $result,
    'data' => $data
);

$strr = json_encode($arr);
mysql_close($link);
echo($strr);
?>
