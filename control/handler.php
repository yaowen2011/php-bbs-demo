<?php
/**
 * 主要用来处理接口
 */
//include_once ROOT_DIR . '/lib/conn.php';
include_once ROOT_DIR . '/control/base.php';
class handler extends base {
    public function __construct($link)
    {
        parent::__construct($link);


    }

    /**
     * 检测是否重名
     */
    public function checkRegName() {
        if ( ! $_POST) {
            throw new \Exception("参数错误", 101);
        }

        $sql = sprintf("SELECT * FROM user WHERE name='%s'", trim($_POST['name']));
        $mysqliRet = mysqli_query($this->link, $sql);
        if ($mysqliRet->num_rows > 0) {
            throw new \Exception('该用户名已经注册过', 102);
        } else {
            $this->ajax(['status'=>0, 'msg'=>'ok']);
        }
    }

    /**
     * 注册页面处理
     */
    public function register() {
        if ( ! $_POST) {
            throw new \Exception("参数错误", 101);
        }
        //TODO check参数

        foreach ($_POST as $k=>$item) {
            $$k = trim($item);
        }

        $sql = sprintf("SELECT * FROM user WHERE name='%s'", $name);
        $mysqliRet = mysqli_query($this->link, $sql);
        if ($mysqliRet->num_rows > 0) {
            throw new \Exception('该用户名已经注册过', 102);
        }

        //上传文件
        $profile = $this->upload($_FILES['profile'], 1, ['image/gif', 'image/jpeg', 'image/jpg', 'image/png']);

        $sql = sprintf("INSERT INTO user SET
            user_id=null,
            name='%s',
            password='%s',
            sex='%d',
            phonenumber='%s',
            profile='%s'
        ", $name, md5($password), $sex, $phonenumber, $profile);
        $ret = mysqli_query($this->link, $sql);
        if ($ret) {
            //注册完，置为登录状态
            $this->setSession(mysqli_insert_id($this->link), $name);
            $data = ['status'=>0, 'msg'=>'ok'];
            $this->ajax($data);
        } else {
            throw new \Exception('错误sql=> ' . $sql, 103);
        }
    }

    /**
     * 退出登录
     */
    public function logout() {
        session_start();
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        session_destroy();
//        $this->ajax(['status'=>0, 'msg'=>'ok']);
        header('Location: /index.php');
    }

    /**
     * 登录处理
     */
    public function login() {
        if ( ! $_POST) {
            throw new \Exception('参数错误', 101);
        }

        foreach ($_POST as $k=>$item) {
            $$k = trim($item);
        }

        $sql = sprintf("SELECT * FROM user WHERE name='%s' AND password='%s'", $name, md5($password));
        $mysqliRet = mysqli_query($this->link, $sql);
        if ( ! $mysqliRet->num_rows) {
            throw new \Exception('用户名或密码错误', 102);
        } else {
            $row = mysqli_fetch_assoc($mysqliRet);
            $this->setSession($row['user_id'], $row['name']);
            $data = ['status'=>0, 'msg'=>'ok'];
            $this->ajax($data);
        }

    }

    /**
     * 留言处理
     */
    public function leaveMessage() {
        if ( ! $_POST) {
            throw new \Exception("参数错误", 101);
        }
        foreach ($_POST as $k=>$item) {
            $$k = trim($item);
        }
        $sql = sprintf("INSERT INTO comment SET
            comment_id=null,
            name='%s',
            comment_title='%s',
            content='%s',
            comment_time='%s',
            category='%d'
        ", $name, $comment_title, $content, date('Y-m-d H:i:s'), $category);
//        echo $sql;
        $ret = mysqli_query($this->link, $sql);
        if ($ret) {
            $ret = ['status'=>0, 'msg'=>$sql];
            $this->ajax($ret);
        } else {
            throw new \Exception('数据写入异常', 102);
        }
    }

    /**
     * 留言修改
     */
    public function editMessage() {
        if ( ! $_POST) {
            throw new \Exception("参数错误", 101);
        }
        foreach ($_POST as $k=>$item) {
            $$k = trim($item);
        }
        $sql = sprintf("UPDATE comment SET
            comment_title='%s',
            content='%s',
            comment_time='%s',
            category='%d'
            WHERE comment_id = %d
        ", $comment_title, $content, date('Y-m-d H:i:s'), $category), $_GET['comment_id'];
//        echo $sql;
        $ret = mysqli_query($this->link, $sql);
        if ($ret) {
            $ret = ['status'=>0, 'msg'=>$sql];
            $this->ajax($ret);
        } else {
            throw new \Exception('数据写入异常', 102);
        }
    }


    protected function setSession($uid, $name) {
//        session_start();
        $_SESSION['uid'] = $uid;
        $_SESSION['name'] = $name;
//        session_commit();
    }

    /**
     * 处理上传文件
     */
    protected function upload(array $file, $filesize, array $mimeCfg ) {
        //      判断是否是HTTP POST上传的
        if ( ! is_uploaded_file($file['tmp_name'])) {
            exit('<script>alert("上传失败0");location.href="./file01.php";</script>');
        }

        //      判断是否有错误
        if ( $file['error'] !== 0) {
            exit('<script>alert("上传失败1");location.href="./file01.php";</script>');
        }

        //      判断文件大小 最大1M
        if ($file['size'] >= 1024*1024*$filesize) {
            exit('<script>alert("上传文件大于1M");location.href="./file01.php";</script>');
        }
        //      获取文件扩展名
        $filename = $file['name'];
        $needle = strrpos($filename, '.');//方法二: strrchr()
        $ext = substr($filename, $needle);

        //      第三方扩展 fileinfo
        $fs = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fs, $file['tmp_name']);
        finfo_close($fs);
        if ( ! in_array($mime, $mimeCfg)) {
            exit('不支持的文件类型上传');
        }
        //      构建临时文件
        $filename =  '/public/upload/' . uniqid('test', true) . $ext;
        if ( ! move_uploaded_file($file['tmp_name'], ROOT_DIR . $filename)) {
            exit('移动文件失败');
        }

        return $filename;
    }
}