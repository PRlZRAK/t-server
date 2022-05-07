<?php
/*
возврвращает массив 
*/
function getChat($pdo, $data)
{
    if ($data["last_chat_id"] == 0) {
        $stmt = $pdo->prepare("SELECT * FROM chats WHERE (user1_id = ? OR user1_id = ?) AND (user2_id = ? OR user2_id = ?) ORDER BY dtime");
        $stmt->execute(array($data["id"], $data["myid"], $data["id"], $data["myid"]));
    } else {
        $stmt = $pdo->prepare("SELECT * FROM chats WHERE (user1_id = ? OR user1_id = ?) AND (user2_id = ? OR user2_id = ?) AND id > ? ORDER BY dtime");
        $stmt->execute(array($data["id"], $data["myid"], $data["id"], $data["myid"], $data["last_chat_id"]));
    }
    $chat = array();
    // $last_id = 0;
    while ($row = $stmt->fetch()) {
        if (is_null($row["img"]))
            $row["img"] = 0;
        else
            $row["img"] = 1;
        $chat[] = $row;
        $last_id = $row["id"];
        if ($row['user2_id'] == $data["myid"] & $row['show_msg'] == 0) {
            $stmt2 = $pdo->prepare("UPDATE chats SET show_msg = 1 WHERE id = ?");
            $stmt2->execute(array($row["id"]));
        }
    }
    if ($data["last_chat_id"] == $last_id || count($chat) == 0) {
        $ret["status"] = 2;
        $ret["msg"] = "No new posts#Нет новых сообщений";
        return json_encode($ret);
    }
    $ret["chat"] = $chat;
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
