<?php
$cfg = [
    'host'=>'localhost:3306',
    'user'=>'root',
    'pwd'=>'',
    'db'=>'messageboard'
];
global $link;
$link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['db']);
if ( ! $link) {
    throw new \Exception('数据库错误信息：' . mysqli_error($link));
}
mysqli_query($link, 'SET names utf8');


