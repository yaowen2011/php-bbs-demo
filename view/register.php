<?php
include_once ROOT_DIR . '/view/common/header.php';
?>
<link rel="stylesheet" href="../public/css/register.css">
<!--main-->
<div class="main">
    <div class="w">
        <!--        <div class="tips">注册页面</div>-->
        <div class="reg">
            <form id="reg-form" class="reg-form" action="index.php?a=handler&m=register">
                <ul>
                    <li><label>姓名</label>
                        <input class="input" name="name" type="text">
                        <span class="warn"></span>
                    </li>
                    <li><label>密码</label>
                        <input class="input" name="password" type="password">
                        <span class="warn"></span>
                    </li>
                    <li><label>确认密码</label>
                        <input class="input" name="repassword" type="password">
                        <span class="warn"></span>
                    </li>
                    <li><label>性别</label>
                        <p class="input">
                            男<input name="sex" type="radio" value="1" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                            女<input name="sex" type="radio" value="0">
                        </p>
                        <span class="warn"></span>
                    </li>
                    <li><label>手机号码</label>
                        <input class="input" name="phonenumber" type="text">
                        <span class="warn"></span>
                    </li>
                    <li><label>头像</label>
                        <input class="input" name="profile" type="file">
                        <span class="warn"></span>
                    </li>
                    <li><label></label>
                        <input class="reg-btn input" type="button" value="立即注册">
                        <span class="warn"></span>
                    </li>
                </ul>
            </form>
        </div>

    </div>
</div>
<!--<script src="../public/js/jquery-1.12.4.js"></script>-->
<script>

    $(document).ready(function () {
        //check 有没有同名
        //todo 增加转圈圈显示
        $("input[name=name]").on('blur', function () {
            var $this = $(this);
            $.ajax({
                type: 'post',
                url: 'index.php?a=handler&m=checkRegName',
                data: {
                    name: $this.val()
                },
                success: function (data) {
                    if (data.status !== 0) {
                        $this.siblings('.warn').text('该用户名已被注册');
                    } else {
                        $this.siblings('.warn').text('');
                    }
                }
            });
        })

        //check 密码长度
        $("input[name=password]").on('blur', function () {
            var $this = $(this);
            if (!/^\w{3,8}$/.test($this.val())) {
                $this.siblings('.warn').text('密码长度3到8位');
            } else {
                $this.siblings('.warn').text('');
            }
        })

        //check两次密码是否一致
        $("input[name=repassword]").on('blur', function () {
            var $this = $(this);
            if ($this.val()!='' && ($this.val() !== $("input[name=password]").val())) {
                $this.siblings('.warn').text('两次密码不一致');
            } else {
                $this.siblings('.warn').text('');
            }
        })


        //手机号
        $("input[name=phonenumber]").on("blur", function () {
            var $this = $(this);
            if (!/^1\d{10}$/.test($this.val())) {
                $this.siblings('.warn').text('手机号格式不对');
            } else {
                $this.siblings('.warn').text('');
            }
        })



        //点击注册
        var isLocked = false;//默认没锁
        $(".reg-btn").on('click', function () {
            //触发校验
            $("input[name=name]").trigger('blur');
            $("input[name=password]").trigger('blur');
            $("input[name=repassword]").trigger('blur');
            $("input[name=phonenumber]").trigger('blur');

            //check
            var sex = $("input[name=sex]:checked").val();
            if (typeof sex === "undefined") {
                return;
            }

            if ($("input[name=profile]").val() === '') {
                $("input[name=profile]").siblings('.warn').text('请选择文件');
            } else {
                $("input[name=profile]").siblings('.warn').text('');
            }

            //检查是否有warn的text 还有不为空的 !important
            var allChecked = true;
            $('.warn').each(function (idx, ele) {
                if ($(ele).text() !== '') {
                    allChecked = false;
                }
            })
            if (allChecked === false) return;

            if (isLocked) {
                showTips("请等文件上传完，再操作");
                return false;
            }

            var form = new FormData(document.getElementById('reg-form'));
            $.ajax({
                type: "post",
                data: form,
                dataType: "json",
                url: "index.php?a=handler&m=register",
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    isLocked = true;
                },
                success: function (data) {
                    //
                    if (data.status === 0) {
                        location.href = "index.php";
                    } else {
                        //location.href = "";
                    }
                },
                complete: function () {
                    isLocked = false;
                }
            })
        })
    })
</script>
</body>
</html>
