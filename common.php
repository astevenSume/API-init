<?php
/*
    *手动写入日志
    * $msg 日志消息
    * $log_path 日志在logs文件下的分类文件夹
    */
function debug_log($msg,$log_path=''){
    $log_path = empty($log_path)?'logs/':'logs/'.$log_path.'/';
    $filepath = $log_path.'debug-'.date('Y-m-d').'.php';
    $message = '';
    $date_fmt = 'Y-m-d H:i:s';

    file_exists($log_path) OR mkdir($log_path,0755,true);
    if( ! is_dir($log_path) ){
        return FALSE;
    }

    //$message
    if( ! file_exists($filepath)){
        $newfile = TRUE;
        $message .= "<?php echo 'basepath or exit'; ?>\n\n";
    }

	
    if( ! $fp = @fopen($filepath,'ab')){
        return FALSE;
    }

    $date = date($date_fmt);

    $message .=$date." ip:".get_ip()."--->\n  ".$msg."\n";
    flock($fp,LOCK_EX);

    for ($written = 0,$length = strlen($message); $written < $length; $written += $result){
        if( ($result = fwrite($fp,substr($message,$written))) === FALSE){
            break;
        }
    }

    flock($fp,LOCK_UN);
    fclose($fp);

    if(isset($newfile) && $newfile === TRUE){
        chmod($filepath, 0644);
    }
    return is_int($result);

}
/*
不同环境下获取真实的IP
*/
function get_ip(){
    //判断服务器是否允许$_SERVER
    if(isset($_SERVER)){    
        if(isset($_SERVER[HTTP_X_FORWARDED_FOR])){
            $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
        }elseif(isset($_SERVER[HTTP_CLIENT_IP])) {
            $realip = $_SERVER[HTTP_CLIENT_IP];
        }else{
            $realip = $_SERVER[REMOTE_ADDR];
        }
    }else{
        //不允许就使用getenv获取  
        if(getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
        }else{
              $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}   

//核对token
function allowEntry($data)
{
	
	$token=strtoupper($data['token']);
	unset($data['token']);
	$stringA = "";
	ksort($data);
	foreach($data as $k=>$v)
	{
		$stringA .= $k . '=' . $v . "&";
	}
	$stringSignTemp = $stringA . "key=438ef0e870aebca19ed8996fa027dd3d";

	$culate_token = strtoupper(md5($stringSignTemp));
	debug_log('stringSignTemp : ' . $stringSignTemp);
	if ($culate_token==$token)
	{
		return true;
	}
	return false;
}