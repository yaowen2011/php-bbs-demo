<?php?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言板</title>
    <link rel="stylesheet" href="../public/css/reset.css">
    <link rel="stylesheet" href="../public/css/index.css">
    <script src="../public/js/jquery-1.12.4.js"></script>
</head>
<body>
<!--头部-->
<div class="header">
    <div class="w clearfix">
        <div class="box-l fl">
            <a href="index.php">网络留言板</a>
        </div>
        <div class="box-r fr">
            <div class="user">
                <?php
                if (! $_SESSION)
                    $user = <<<EOD
                        <a href="index.php?m=login">登录</a>
                        <a href="index.php?m=register">注册</a>
EOD;
                else {
                    $user = <<<EOD
                <span>欢迎您</span>
                <a href="#">{$_SESSION['name']}</a>
                <a href="index.php?a=index&m=leaveMessage">我要留言</a>
                <a href="index.php?a=handler&m=logout">退出</a>
EOD;
                }

                echo $user;
                ?>

            </div>
        </div>
    </div>
</div>

<!--banner-->
<div class="banner">
    <div class="w">
        <img src="../public/images/banner.jpg" alt="">
    </div>
</div>

<!--nav-->
<div class="nav">
    <div class="w">
        <ul class="clearfix">
            <?php
//            $categoryList
            foreach ($GLOBALS['categoryList'] as $v) {
                $li = <<<EOD
            <li class="fl"><a href="index.php?category_id={$v['category_id']}">{$v['name']}</a></li>
EOD;
                echo $li;
            }
            ?>
        </ul>
    </div>

</div>


<!--显示提示-->
<div class="msg-tips off">

</div>
<script>
    //显示提示
    function showTips(tips) {
        $(".msg-tips").text(tips).stop(true).fadeIn(300).delay(2000).fadeOut(300);
    }
</script>