<?php

header('content-type:text/html;charset=utf-8');
@mysql_set_charset('utf8');
require_once 'config.php';

$link = mysql_connect($localhost,$USERNAME,$DBPASS);
mysql_query("set names 'utf8'",$link);
mysql_select_db($DBNAME);

$num = 8;//客户端传入要产生多少个随机数;
$start = 1; //起始数,根据数据库首id
$end = 20;//产生随机数的范围,根据数据库总条数
$connt = 0;
while($connt<$num){
    $a[]=rand($start,$end);//产生随机数
    $ary=array_unique($a);
    $connt=count($ary);
}

$idtotal = '';
$n=0;
foreach ($ary as $temp){
    if ($n==7){
        $idtotal = $idtotal."id = $temp";
    }else{
    $idtotal = $idtotal."id = $temp".' or ';
    }
    $n++;
}


$sql1 ="select count(*) from recommand where ($idtotal and state = 0)";
//echo $sql1;
$sql2 ="select * from recommand where ($idtotal and state = 0)";

$arr = array();
$result = mysql_query($sql1);
$total_num = 0;
$total_num=mysql_result($result,0);
$arr['total_num'] = $total_num;
$arr['result'] = 0;

if($total_num != 0 ){
    $result = mysql_query($sql2);
    $arr['result'] = 1;// 0 OK,1 NG

    if($result && mysql_num_rows($result)){
        $arr['result'] = 0;
        while ($row =mysql_fetch_assoc($result)){
            $arrTemp = array(
                'id' => $row['id'],
                'content' => $row['content'],
                'sort' => $row['sort'],
                'state' => $row['state'],
				'nickname' => $row['nickname'],
                'headpic' => $row['headpic'],
                'createdate' => $row['createdate']
            );
            $arrListInfoTemp[] = $arrTemp;
    
        }
        $arr['list'] =$arrListInfoTemp;
    }
}

$strr = json_encode($arr);
mysql_close($link);
echo($strr);

?>