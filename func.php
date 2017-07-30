<?php 

function udpGet($sendMsg = '', $ip = '127.0.0.1', $port = '4000'){
    $handle = stream_socket_client("udp://{$ip}:{$port}", $errno, $errstr);
    if( !$handle ){
        die("ERROR: {$errno} - {$errstr}\n");
    }
    fwrite($handle, $sendMsg."\n");
    $result = fread($handle, 1024);
    fclose($handle);
    return $result;
}

function ping()
{
    $return = udpGet('ping');
    if ( substr_count($return, 'stat') === 1)
    {
       $return = str_replace('stat:','',$return);
    }
    $return = json_decode($return, true);
    if(empty($return))
    {
        return NULL;
    }
    return $return;
}

function add($port, $password)
{
    $text = 'add: {"server_port":' . $port . ',"password":"' . $password . '"}';
    $return = udpGet($text);
    if ($return === 'ok')
    {
       return TRUE;
    }
    else
    {
       return FALSE;
    }
}

function remove($port)
{
    $text = 'remove: {"server_port":' . $port . '}';
    $return = udpGet($text);
    if ($return === 'ok')
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function purge($port)
{
    $local = json_decode(file_get_contents('data/local.json'),true);
    $port = (string)$port;
    if(empty($local) OR !isset($local[$port]))
    {
        return FALSE;
    }
    unset($local[$port]);
    file_put_contents('data/local.json', json_encode($local));
    return TRUE;
}