<?php
@mysql_set_charset('utf8');
require_once 'config.php';

$uid = $_POST['uid'];
$keyword = $_POST['keyword'];//返回当天 00：00 时刻的时间戳；今天或明天或某一天

$link = @mysql_connect($localhost,$USERNAME,$DBPASS);
mysql_query("set names 'utf8'",$link);
@mysql_select_db($DBNAME);

$sql1 ="select count(*) from todolist where  (uid = $uid and info like '%{$keyword}%' )";
$sql2 ="select * from todolist where (uid = $uid and info like '%{$keyword}%' ) order by sort asc,alerttime desc ";
$result = mysql_query($sql1);

$total_num = 0;
$arr = array();
$total_num=mysql_result($result,0);
$arr['total_num'] = $total_num;
$arr['result'] = 0;

if($total_num != 0 ){
    $result = mysql_query($sql2);
    $arr['result'] = 1;// 0 OK,1 NG
    $arrListInfo = array();
    $arr['list'] =$arrListInfo;

    $arrListInfoTemp = array();

    if($result && mysql_num_rows($result)){
            $arr['result'] = 0;
            while ($row =mysql_fetch_assoc($result)){
                $arrTemp = array(
                    'id' => $row['id'],
                    'tagid' => $row['tagid'],
                    'uid' => $row['uid'],
                    'info' => $row['info'],
                    'state' => $row['state'],
                    'createtime' => $row['createtime'],
                    'alerttime' => $row['alerttime'],
                    'sort' => $row['sort']
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