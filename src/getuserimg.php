<?php
function getuserimg($pdo, $data)
{
    $stmt = $pdo->prepare("SELECT id, avatar FROM users WHERE id = ?");
    $stmt->execute(array($data["id"]));
    $row = $stmt->fetch();
    if (isset($row['avatar'])) {
        $row['status'] = 0;
        $row['msg'] = "ok";
    } else {
        $row['status'] = 1;
        $row['msg'] = "no image";
    }
    return json_encode($row, JSON_UNESCAPED_UNICODE);
}
