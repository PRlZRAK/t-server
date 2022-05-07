<?php
/*
Функция удаляет чат с пользователем
*/
function deluser($pdo, $data)
{
    $stmt = $pdo->prepare("DELETE FROM mychats WHERE my_id = ? AND user_id = ?");
    $stmt->execute(array($data['myid'], $data['userid']));
    $stmt->execute(array($data['userid'], $data['myid']));
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
