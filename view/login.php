<?php
include_once ROOT_DIR . '/view/common/header.php';
?>
<link rel="stylesheet" href="../public/css/login.css">
<!--main-->
<div class="main">
    <div class="w">
        <!--        <div class="tips">登录页面</div>-->
        <div class="login">
            <form class="login-form" action="index.php?a=handler&m=login">
                <ul>
                    <li><label>用户名</label><input name="name" type="text"></li>
                    <li><label>密码</label><input name="password" type="password"></li>
                    <li><label></label><input class="login-btn" type="button" value="登录"></li>
                </ul>
            </form>
        </div>

    </div>
</div>
<!--<script src="../public/js/jquery-1.12.4.js"></script>-->
<script>
    $(document).ready(function () {
        //点击注册
        $(".login-btn").on('click', function () {
            //todo check

            $.ajax({
                type: "post",
                data: $(".login-form").serialize(),
                dataType: "json",
                url: "index.php?a=handler&m=login",
                success: function (data) {
                    //
                    if (data.status === 0) {
                        location.href = "index.php";
                    } else {
                        showTips(data.msg);
                        //location.href = "";
                    }
                }
            })
        })
    })
</script>
</body>
</html>
