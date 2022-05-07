<?php
/*
функция возвращает логин и ид всех
юзеров системы в виде джейсон массива
*/
function getUsers($pdo, $data)
{
    $stmt = $pdo->prepare("SELECT id, login FROM users");
    $stmt->execute();
    $users = array();
    while ($row = $stmt->fetch()) {
        $users[] = $row;
        $last_id = $row["id"];
    }
    if ($data["last_user_id"] == $last_id) {
        $ret["status"] = 2;
        $ret["msg"] = "Нет новых пользователей";
        return json_encode($ret);
    }
    $ret["users"] = $users;
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
