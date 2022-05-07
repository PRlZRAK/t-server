<?php
/*
отключаем юзера
*/
function useroff($pdo, $data)
{
   // var_dump($data);
    $stmt = $pdo->prepare("UPDATE users SET online = '0' WHERE id = ?");
    $res = $stmt->execute(array($data["id"]));
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
