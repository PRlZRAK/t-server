<?php
function checkshow($pdo, $data)
{
    $stmt = $pdo->prepare("UPDATE users SET show_" . $data['param'] . " = ? WHERE id = ?");
    $res = $stmt->execute(array($data["val"], $data["id"]));
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
