<?php
//var_dump($_SERVER);
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
$a = isset($_GET['a']) ? trim($_GET['a']) : 'index';
$m = isset($_GET['m']) ? trim($_GET['m']) : 'indexPage';

try {
    //数据库
    include_once ROOT_DIR . '/lib/conn.php';
    require_once (ROOT_DIR . '/control/'. $a . '.php');
    $action = new $a($link);
    $action->$m();

} catch (\Exception $e) {
    $data = [
        'status'=>1,
        'msg'=>$e->getMessage()
    ];
    exit(json_encode($data));
}
