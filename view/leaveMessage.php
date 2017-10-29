<?php
include_once ROOT_DIR . '/view/common/header.php';
?>
<link rel="stylesheet" href="../public/css/leaveMessage.css">
<!--main-->
<div class="main">
    <div class="w">
        <!--        <div class="tips">留言页面</div>-->
        <div class="msg">
            <form class="msg-form" action="">
                <input type="hidden" name="name" value="<?php echo $_SESSION['name']?>">
                <ul>
                    <li><label>类别</label>
                        <div class="input">
                            <select name="category">
                                <?php
                                foreach($data['rowList'] as $v) {
                                    $option = <<<EOD
                            <option value="{$v['category_id']}">{$v['name']}</option>
EOD;
                                    echo $option;
                                }

                                ?>

                            </select>
                        </div>

                    </li>
                    <li><label>标题</label>
                        <div class="input">
                            <input name="comment_title" type="text">
                        </div>
                    </li>
                    <li><label>内容</label>
                        <div class="input">
                            <textarea name="content" cols="70" rows="10"></textarea>
                        </div>
                    </li>
                    <li><label></label>
                        <div class="input">
                            <input class="msg-btn" type="button" value="提交">
                        </div>
                    </li>
                </ul>
            </form>
        </div>

    </div>
</div>
<!--<script src="../public/js/jquery-1.12.4.js"></script>-->
<script charset="utf-8" src="../public/js/editor/kindeditor-min.js"></script>
<script charset="utf-8" src="../public/js/editor/lang/zh_CN.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true,
            afterBlur: function(){this.sync();}
        });
    });
</script>
<script>
    $(document).ready(function () {
        //点击提交表单
        $(".msg-btn").on('click', function () {
            //todo check

            $.ajax({
                type: "post",
                data: $(".msg-form").serialize(),
                dataType: "json",
                url: "index.php?a=handler&m=leaveMessage",
                success: function (data) {
                    //
                    if (data.status === 0) {
//                        location.href = "index.php?category_id=";
                        location.href = "index.php";
                    } else {
                        //location.href = "";
                    }
                }
            })
        })
    })
</script>
</body>
</html>
