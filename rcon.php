<?php
require('func.php');

$return = ping();
if($return === NULL)
{
   exit();
}
$temp = json_decode(file_get_contents('data/temp.json'),true);
$local = json_decode(file_get_contents('data/local.json',true));
if(!isset($temp))
{
   file_put_contents('data/temp.json', json_encode($return));
   exit();
}
if(!isset($local))
{
    file_put_contents('data/local.json', json_encode($return));
    exit();
}
foreach ($return as $key => $value) {
    // 增加值
    if(isset($temp[$key]) && (int)$return[$key] > (int)$temp[$key])
    {
        $add = (int)$return[$key] - (int)$temp[$key];
        if(!isset($local[$key]))
        {
            $local[$key] = 0;
        }
        $local[$key] += $add;
    }
}
file_put_contents('data/temp.json', json_encode($return));
file_put_contents('data/local.json', json_encode($local));