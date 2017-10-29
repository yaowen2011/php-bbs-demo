<?php
$subject = "<img src='1.jpg' alt='图片名' />123 >";
//
//$content=$v['content'];
//$newstr = preg_replace("/<img.+?\/>/", "", $content);
// $newstr = preg_replace("/<img.+\/?\>/", "", $content);

$pattern = "/<img(.*?)>/";  //这个问号是   src='1.jpg' alt='图片名' /
//$pattern = "/<img(.*)>/";   //这个问号是 src='1.jpg' alt='图片名' />123
preg_match($pattern, $subject, $matches);
print_r($matches);

$ret = preg_replace("/<img.*>/", 'xxx', $subject);
print_r($ret);