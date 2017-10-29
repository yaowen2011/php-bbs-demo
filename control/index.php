<?php
/**
 * 主要用来显示对应页面
 */
include_once ROOT_DIR . '/control/base.php';
class index extends base {

    public function __construct($link)
    {
        parent::__construct($link);
        global $categoryList;
        $categoryList = $this->getCategoryList();
    }

    /**
     * 默认显示首页
     */
    public function indexPage() {
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        if ($category_id > 0) {
            $sql = sprintf("SELECT * FROM comment WHERE category='%d'", $category_id);
        } else {
            $sql = sprintf("SELECT tbA.*, tbB.profile FROM comment as tbA 
                LEFT JOIN user as tbB
                ON 
                tbA.name = tbB.name
            ");
        }
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
//            throw new \Exception('数据配置出错', 102);
        }
        $rowList = mysqli_fetch_all($mysqliRet, MYSQLI_ASSOC);

        $data = [
            'rowList'=>$rowList
        ];
        $this->render('index', $data);
    }

    /**
     * 注册页面
     */
    public function register() {
        $this->render('register');
    }

    /**
     * 登录页面
     */
    public function login() {
        $this->render('login');
    }

    /**
     * 显示留言表单页面
     */
    public function leaveMessage() {
        $sql = sprintf("SELECT * FROM category ");
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
            throw new \Exception('数据配置出错', 102);
        }
//        mysqli_fetch_assoc($mysqliRet);
        $rowList = mysqli_fetch_all($mysqliRet, MYSQLI_ASSOC);


        $this->render('leaveMessage', ['rowList'=>$rowList]);
    }

    /**
     * 留言编辑
     */
    public function edit() {
        //todo  判断是否可以编辑

        $sql = sprintf("SELECT * FROM category ");
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
            throw new \Exception('数据配置出错', 102);
        }
//        mysqli_fetch_assoc($mysqliRet);
        $rowList = mysqli_fetch_all($mysqliRet, MYSQLI_ASSOC);

        $sql = sprintf("SELECT * FROM comment WHERE comment_id=%d", (int)$_GET['comment_id']);
        $mysqliRet = mysqli_query($this->link, $sql);
        $info = mysqli_fetch_assoc($mysqliRet);

        $this->render('editMessage', ['info'=>$info, 'rowList'=>$rowList]);
    }


    /**
     * 显示内容页面
     */
    public function info() {
        $comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;
        if ($comment_id <= 0) {
            throw new \Exception('参数错误', 101);
        }
        $sql = sprintf("SELECT * FROM comment WHERE comment_id=%d", $comment_id);
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
            throw new \Exception('数据配置出错', 102);
        }
        $info = mysqli_fetch_assoc($mysqliRet);
//        var_dump($info);
        $this->render('info', ['info'=>$info]);
    }

    protected function getCategoryList() {
        $sql = sprintf("SELECT * FROM category ");
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
            throw new \Exception('数据配置出错', 102);
        }

        return mysqli_fetch_all($mysqliRet, MYSQLI_ASSOC);
    }
}