<?php
function edituser($pdo, $data)
{
    if (isset($data["img"])) {
        $data["img"] = imgCrop($data); // если это закоментировать картинки будут прямоугольными
        $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->execute(array($data["img"], $data["id"]));
    } else if (isset($data["fio"])) {
        $stmt = $pdo->prepare("UPDATE users SET fio = ? WHERE id = ?");
        $stmt->execute(array($data["fio"], $data["id"]));
    } else if (isset($data["password"])) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute(array($data["password"], $data["id"]));
    } else if (isset($data["login"])) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute(array($data["login"]));
        $row = $stmt->fetch();
        if (isset($row['id'])) {
            $row1['status'] = 1;
            $row1['msg'] = "This login is already taken#Этот логин уже занят";
            return json_encode($row1, JSON_UNESCAPED_UNICODE);
        }
        $stmt = $pdo->prepare("UPDATE users SET login = ? WHERE id = ?");
        $stmt->execute(array($data["login"], $data["id"]));
    } else if (isset($data["phone"])) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
        $stmt->execute(array($data["phone"]));
        $row = $stmt->fetch();
        if (isset($row['id'])) {
            $row1['status'] = 1;
            $row1['msg'] = "This phone is already taken#Этот телефон уже занят";
            return json_encode($row1, JSON_UNESCAPED_UNICODE);
        }
        $stmt = $pdo->prepare("UPDATE users SET phone = ? WHERE id = ?");
        $stmt->execute(array($data["phone"], $data["id"]));
    } else if (isset($data["email"])) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute(array($data["email"]));
        $row = $stmt->fetch();
        if (isset($row['id'])) {
            $row1['status'] = 1;
            $row1['msg'] = "This mail is already taken#Эта почта уже занята";
            return json_encode($row1, JSON_UNESCAPED_UNICODE);
        }
        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute(array($data["email"], $data["id"]));
    } else {
        $row1['status'] = 1;
        $row1['msg'] = "I don't know what to edit#не знаю что редактировать";
        return json_encode($row1, JSON_UNESCAPED_UNICODE);
    }
    $row1['status'] = 0;
    $row1['msg'] = "ok";
    return json_encode($row1, JSON_UNESCAPED_UNICODE);
}
