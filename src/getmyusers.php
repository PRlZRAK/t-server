<?php
/*
функция возвращает логин и ид всех
юзеров с кем имеется переписка
*/
function getmyusers($pdo, $data)
{
    $stmt = $pdo->prepare("SELECT id, login, (SELECT COUNT(*) FROM chats 
    WHERE user2_id = mychats.my_id AND user1_id = mychats.user_id AND show_msg = 0) 
    as 'cnt', online FROM mychats, users WHERE mychats.my_id = ? AND users.id = mychats.user_id  ORDER BY dtime DESC");
    $stmt->execute(array($data['id']));
    $users = array();
    $ksum = 0;
    while ($row = $stmt->fetch()) {
        $users[] = $row;
        $ksum += $row['id'] * 10 + $row['cnt'] + $row["online"] * 100;
    }
    if ($data["ksum"] == $ksum) {
        $ret["status"] = 2;
        $ret["msg"] = "Новых сообщений нет";
        return json_encode($ret);
    }
    $ret["users"] = $users;
    $ret["ksum"] =  $ksum;
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
