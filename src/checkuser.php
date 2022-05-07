<?php
function checkuser($pdo, $data)
{
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE login = ? AND phone = ? AND email = ? LIMIT 1");
    $stmt->execute(array($data["login"], $data["phone"], $data["email"]));
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        $row["status"] = 0;
        $row["msg"] = "ok";
        return json_encode($row);
    }
    $row["status"] = 1;
    $row["msg"] = "User with such data does not exist#Пользователь с таким данными не существует";
    return json_encode($row);
}
