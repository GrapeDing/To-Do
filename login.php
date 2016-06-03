<?php
    header('content-type:text/html;charset=utf-8');
	mysql_set_charset('utf8');
    require_once("config.php");
    
    $link = mysql_connect($localhost,$USERNAME,$DBPASS);
    mysql_query("set names 'utf8'",$link);
    mysql_select_db($DBNAME);
    
    $uuid = $_POST['uuid'];

    $result = 1;//0 OK ,1 NG
    
    $sql ="select * from user where uuid = '{$uuid}'";
    $r = mysql_query($sql);
    
    if($r == true){
        if(mysql_num_rows($r)){
            $row = mysql_fetch_assoc($r); 
            $result = 0;
            $id = $row['id'];
            $sql3 = "UPDATE `user` SET `lastlogin` = now() WHERE `id` = '{$row['id']}'";
            $r3 = mysql_query($sql3);
            
        }else{
            $sql = "INSERT INTO user  (uuid) VALUES ('{$uuid}')";     
            $r = mysql_query($sql);
            $id = mysql_insert_id();
            
            $sql3 = "UPDATE `user` SET `lastlogin` = now() WHERE `id` = '$id'";
            $r3 = mysql_query($sql3);
            
            if($r == true ){
                $result = 0;
            }else{
                $result = 1;//0 OK ,1 NG
            }
        }
        
    }else{
        $result = 1;//0 OK ,1 NG
    }
    
	$arr = array(
		'result' => $result,
        'id' => $id
	);

	$strr = json_encode($arr);
    mysql_close($link);
	echo($strr);
?>