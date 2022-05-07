<?php
function getuser($pdo, $data)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($data["id"]));
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        $row['status'] = 0;
        $row['msg'] = "ok";
        if (is_null($row["avatar"]))
            $row["avatar"] = 0;
        else
            $row["avatar"] = 1;
        return json_encode($row, JSON_UNESCAPED_UNICODE);
    }
    $row['status'] = 1;
    $row['msg'] = "Нет такого юзера";
}
