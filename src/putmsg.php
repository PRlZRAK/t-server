<?php
function putmsg($pdo, $data)
{
    if (isset($data["img"])) {
        $stmt = $pdo->prepare("INSERT INTO chats ( user1_id, user2_id, msg, dtime,img) VALUES (?, ?, ?, ?, ?)");
        $res = $stmt->execute(array($data["id_from"], $data["id_to"], $data["msg"], $data["dtime"], $data["img"]));
    } else {
        $stmt = $pdo->prepare("INSERT INTO chats ( user1_id, user2_id, msg, dtime) VALUES (?, ?, ?, ?)");
        $res = $stmt->execute(array($data["id_from"], $data["id_to"], $data["msg"], $data["dtime"]));
    }
    $stmt = $pdo->prepare("INSERT IGNORE INTO mychats (my_id, user_id)VALUES(?, ?)");
    $res = $stmt->execute(array($data["id_from"], $data["id_to"]));
    $res = $stmt->execute(array($data["id_to"], $data["id_from"]));
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
