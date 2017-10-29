<?php
class base {
    protected $link = null;

    function __construct($link)
    {
        $this->link = $link;
        session_start();
        $this->_checkSession();
    }

    public function render($filename, array $data = []) {
        require_once ROOT_DIR . "/view/$filename" . '.php';
    }

    public function ajax(array $data) {
        header('content-type:text/json;charset=utf-8');
        exit(json_encode($data));
    }

    protected function _checkSession() {
        if ( ! $_SESSION) {
            //header('Location: index.php');
        }
    }
}