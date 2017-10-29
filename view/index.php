<?php
    include_once ROOT_DIR . '/view/common/header.php';
?>

<!--main-->
<div class="main">

    <?php

    if ($data['rowList']) {
        echo '<ul class="clearfix box w">';
        foreach ($data['rowList'] as $v) {
            $v['content'] = preg_replace("/<img.+?>/", '', $v['content']);
            $li = <<<EOD
            <a href="index.php?m=info&comment_id={$v['comment_id']}">            
                <li class="fl">
                    <h3 class="msg-title">{$v['comment_title']}</h3>
                    <div class="msg-content">{$v['content']}</div>
                    <div class="msg-author clearfix">
                        <span class="fl">作者：{$v['name']}</span>
                        <span class="fr"><img src="..{$v['profile']}" alt=""></span>
                    </div>
                </li>
            </a>
EOD;
            echo $li;
        }

        echo '</ul>';
    } else {
        $main = <<<EOD
        <div class="w">
            <div class="tips">还没有留言，请增加哦~</div>
        </div>
EOD;
        echo $main;
    }
    ?>



</div>
</body>
</html>
