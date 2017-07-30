<?php

$ip = gethostbyname('');
function udpGet($sendMsg = '', $ip = '0.0.0.0', $port = '9000'){
    $handle = stream_socket_client("udp://{$ip}:{$port}", $errno, $errstr);
    if( !$handle ){
        die("ERROR: {$errno} - {$errstr}\n");
    }
    fwrite($handle, $sendMsg."\n");
    $result = fread($handle, 1024);
    fclose($handle);
    return $result;
}


$text = array(
	'api-key' => '',
	'type' => 'ping',
	'port' => '8001',
 'password'=> 'timepass'
	);

$text = json_encode($text);

$result = udpGet($text,$ip);

echo $result . "\n";
