<?php
set_time_limit(0);

require('func.php');
define("MY-API-KEY", "myapikey");

$server = 'udp://0.0.0.0:9000';
$socket = stream_socket_server($server, $errno, $errstr, STREAM_SERVER_BIND);
do
{
    $receive_msg = stream_socket_recvfrom($socket, 1024, 0, $peer);
    $receive = json_decode($receive_msg, true);

    if (!isset($receive))
    {
        $msg = array(
        'success' => FALSE,
        'message' => 'Fake Command'
            );
    	stream_socket_sendto($socket, json_encode($msg), 0, $peer);
    	continue;
    }

    if ($receive['api-key'] === constant("MY-API-KEY") && isset($receive['type']))
    {
        if ( $receive['type'] === 'ping' )
        {
        	$data = json_decode(file_get_contents('data/local.json'),true);
        	$msg = array(
            'success' => TRUE,
            'data' => $data
                );
            stream_socket_sendto($socket, json_encode($msg), 0, $peer);
        }

        if ( $receive['type'] === 'add' )
        {
        	$port = $receive['port'];
        	$password = $receive['password'];
        	$return = add($port,$password);
            $msg = array();
            if($return === TRUE)
            {
                $msg['success'] = TRUE;
            }
            else
            {
                $msg['success'] = FALSE;
            }
        	stream_socket_sendto($socket, json_encode($msg), 0, $peer);
        }

        if ( $receive['type'] === 'remove' )
        {
            $port = $receive['port'];
        	$return = remove($port);
            $msg = array();
            if($return === TRUE)
            {
                $msg['success'] = TRUE;
            }
            else
            {
                $msg['success'] = FALSE;
            }
        	stream_socket_sendto($socket, json_encode($msg), 0, $peer);
        }

        if( $receive['type'] === 'purge' )
        {
            $port = $receive['port'];
            $return = purge($port);
            $msg = array();
            if($return === TRUE)
            {
                $msg['success'] = TRUE;
            }
            else
            {
                $msg['success'] = FALSE;
            }
            stream_socket_sendto($socket, json_encode($msg), 0, $peer);
        }
    }
    else
    {
        $msg = array(
        'success' => FALSE,
        'message' => 'Bad request'
            );
        stream_socket_sendto($socket, json_encode($msg), 0, $peer);
    }
} while ($receive_msg !== FALSE);
