<?php
require('func.php');

$return = ping();
if($return === NULL)
{
   exit("ping didn't return any data.\n");
}

//$temp = json_decode(file_get_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json'),true);
$local = json_decode(file_get_contents('/root/shadowsocks-manager-api-php-extend/data/local.json',true));
//if(!isset($temp))
//{
//  file_put_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json', json_encode($return));
//   exit("temp file is not exsit.\n");
//}

if(!isset($local))
{
    exit("local file is not exsit.\n");
}
foreach ($return as $port => $traffic) 
{
    $port = (string)$port;
    $traffic = (int)$traffic;
    if(isset($local[$port]))
    {
        $local[$port]['traffic'] = $traffic;
    }
}

//file_put_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json', json_encode($return));
file_put_contents('/root/shadowsocks-manager-api-php-extend/data/local.json', json_encode($local));