<?php
/*
* 接口只接收POST方式的数据
* -1000 非POST方式发送数据
* -2000 所有数据必须有请求way
* -3000 密钥错误，非法请求
*/
require 'database.php';
require 'common.php';

$pd=$_POST;

if (!allowEntry($pd)) exit('-3000');
$data=['way'=>'uinfo','mi'=>'test','token'=>'6D3C1B30A06AFC6925F14493BD363BBF'];
var_dump(allowEntry($data));

//增加
// $insert_data=['cname'=>'shaw','d'=>'bb'];
// $insert_id = $db->insert('yx_test')->cols($insert_data)->query();
// echo $insert_id;
//删除
// $row_count = $db->delete('yx_test')->where('id=2')->query();
// echo $row_count;
//修改
// $row_count = $db->query("UPDATE yx_test SET d='ddddd' WHERE id=1");
// echo $row_count;
//查找
//$data = $db->query("SELECT id,cname FROM yx_test WHERE id=1");
// print_r($data);
// print_r($db);

// $gid=$_GET['id'];
// echo $gid.'---';
// $pid=$_POST['id'];
// echo $pid;