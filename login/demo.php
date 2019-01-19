<?php

include_once "wxBizDataCrypt.php";
$js_code=$_POST["code"];
$encryptedData=$_POST["encryptedData"];
$signature=$_POST["signature"];
$rawData=$_POST["rawData"];
$iv = $_POST["iv"];

$appid = 'wx130ed755dff1fc5e';
$appSecret="bae7438220c14f72da2eb277af8bf156";

$str = file_get_contents('https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appSecret.'&js_code='.$js_code.'&grant_type=authorization_code');
$str=json_decode($str);
/*print_r($str);*/
$sessionKey=$str->session_key;

$signature2=sha1($rawData.$sessionKey);
if($signature!=$signature2){
	$arr=array("code"=>3);
    exit(json_encode($arr));
}

$pc = new WXBizDataCrypt($appid, $sessionKey);
$errCode = $pc->decryptData($encryptedData, $iv, $data );
if ($errCode == 0) {
    print($data);
} else {
    print($errCode);
}
