<?php
include_once ROOT_DIR . '/view/common/header.php';
?>
<link rel="stylesheet" href="../public/css/info.css">
<!--main-->

<div class="main">
    <div class="w">

        <!--        <div class="tips">内容页面</div>-->
        <?php
        $edit = '';
        if ($_SESSION['name'] === $data['info']['name']) {
            $edit = <<<EOD
            <div class="edit">
                <span class="del-btn"><a href="index.php?a=handler&m=del&comment_id={$data['info']['comment_id']}" onclick="if(confirm('确定删除?')==false)return false;">删除</a></span>
                <span class="edit-btn"><a href="index.php?m=edit&comment_id={$data['info']['comment_id']}">修改</a></span>
            </div>
EOD;
        }

        $html = <<<EOD
        <div class="title">
            <h3>{$data['info']['comment_title']}</h3>
        </div>
        <div class="author">
            作者：<span class="txt">{$data['info']['name']}</span>
            发表时间：<span class="txt">{$data['info']['comment_time']}</span>
            {$edit}
        </div>
        <div class="content">
            {$data['info']['content']}
        </div>
EOD;
        echo $html;
        ?>

    </div>
</div>
<!--<script src="../public/js/jquery-1.12.4.js"></script>-->
</body>
</html>
