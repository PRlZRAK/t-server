<?php

/****************************************************************
 * сервер huprum										        *
 * 04.05.2021												*
 * Автор: Янчук А (yaa)											*
 ****************************************************************/
header("Access-Control-Allow-Origin: *");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('src/db.php');
require_once("src/login.php");
require_once("src/getusers.php");
require_once("src/getmyusers.php");
require_once("src/getchat.php");
require_once("src/registr.php");
require_once("src/putmsg.php");
require_once("src/deluser.php");
require_once("src/useroff.php");
require_once("src/getimg.php");
require_once("src/edituser.php");
require_once("src/getuser.php");
require_once("src/getuserimg.php");
require_once("src/checkshow.php");
require_once("src/checkuser.php");
require_once("src/imgcrop.php");


$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

//var_dump($data);
if (isset($data['action'])) {
    $pdo = new db();
    switch ($data['action']) {
        case 'login':
            printj(login($pdo, $data));
            return;
        case 'get_users':
            printj(getUsers($pdo, $data));
            return;
        case 'get_chat':
            printj(getChat($pdo, $data));
            return;
        case 'registr':
            printj(registr($pdo, $data));
            return;
        case 'put_msg':
            printj(putmsg($pdo, $data));
            return;
        case 'get_my_users':
            printj(getmyusers($pdo, $data));
            return;
        case 'del_user':
            printj(deluser($pdo, $data));
            return;
        case 'user_off':
            printj(useroff($pdo, $data));
            return;
        case 'get_img':
            printj(getimg($pdo, $data));
            return;
        case 'edit_user':
            printj(edituser($pdo, $data));
            return;
        case 'get_user':
            printj(getuser($pdo, $data));
            return;
        case 'get_user_img':
            printj(getuserimg($pdo, $data));
            return;
        case 'check_show':
            printj(checkshow($pdo, $data));
            return;
        case 'check_user':
            printj(checkuser($pdo, $data));
            return;
    }
}
printj(json_encode(array("status" => 1, "msg" => "Неверный запрос")));
function printj($str)
{
    print "<#" . $str . "#>";
}
