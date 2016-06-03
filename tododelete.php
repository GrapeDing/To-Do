<?php

    header('content-type:text/html;charset=utf-8');
    mysql_set_charset('utf8');
    require_once("config.php");
    
    $link = mysql_connect($localhost,$USERNAME,$DBPASS);
    mysql_query("set names 'utf8'",$link);
    mysql_select_db($DBNAME);

    $id = $_POST['id'];
    $timearr = getdate($_POST['alerttime']);
    $mday = $timearr['mday'];
    $mon = $timearr['mon'];
    $year = $timearr['year'];
    $month = 'month'.$mon;
    $uid = $_POST['uid'];
    $num = $_POST['num'];
    $temp = 0xFFFFFFFF ^ (1 << ($mday-1));
    
    $result = 1;
    $sql = "DELETE FROM todolist WHERE id = '{$id}'";
    $r1 = mysql_query($sql);

    if($r1){
        $result = 0;
        if($num == 1){
            $sql ="select {$month} from calendar where uid = '{$uid}' and year='{$year}'";
            $r = mysql_query($sql);
            if($r && mysql_num_rows($r)){
                $old=mysql_result($r,0);
                $new = $old & $temp;
                $sql3 = "update calendar set {$month} = $new where uid = '{$uid}' and year='{$year}'";
                $r=mysql_query($sql3);
            }
        }
    }

    $arr = array(
		'result' => $result
	);

    $strr = json_encode($arr);
    mysql_close($link);
    echo($strr);

?>
