<?php
/**
 * Created by PhpStorm.
 * User: xuxianqiong
 * Date: 2021/5/26
 * Time: 下午4:41
 */

require"vendor/autoload.php";

$redis=new  \XxqRedis\XxqRedis(['host'=>'172.168.7.12']);
$redis->set('test',111,1000);
//var_dump($redis->get('test'));
