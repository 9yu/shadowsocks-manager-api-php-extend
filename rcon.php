<?php
require('func.php');

$return = ping();
if($return === NULL)
{
   exit("ping didn't return any data.\n");
}
$temp = json_decode(file_get_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json'),true);
$local = json_decode(file_get_contents('/root/shadowsocks-manager-api-php-extend/data/local.json',true));
if(!isset($temp))
{
   file_put_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json', json_encode($return));
   exit("temp file is not exsit.\n");
}
if(!isset($local))
{
    exit("local file is not exsit.\n");
}
foreach ($return as $key => $value) {
    // 增加值
    if(isset($temp[$key]) && (int)$return[$key] > (int)$temp[$key])
    {
        $add = (int)$return[$key] - (int)$temp[$key];
        if(!isset($local[$key]))
        {
            exit("local port is not exsit.\n");
        }
        $local[$key]['traffic'] += $add;
    }
}
file_put_contents('/root/shadowsocks-manager-api-php-extend/data/temp.json', json_encode($return));
file_put_contents('/root/shadowsocks-manager-api-php-extend/data/local.json', json_encode($local));