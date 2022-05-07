<?php
function login($pdo, $data)
{
    if (isset($data["phone"])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ? LIMIT 1");
        $res = $stmt->execute(array($data["phone"]));
    } else if (isset($data["mail"])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $res = $stmt->execute(array($data["mail"]));
    } else if (isset($data["login"])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? LIMIT 1");
        $res = $stmt->execute(array($data["login"]));
    } else return json_encode(array('status' => 1, 'msg' => 'Параметр не login, email или phone'), JSON_UNESCAPED_UNICODE);
    $row = $stmt->fetch();
    if (isset($row['id'])) {
        if (isset($data["dtime"])) {
            $stmt = $pdo->prepare("UPDATE users SET online = '1', dtime = ? WHERE id = ?");
            $res = $stmt->execute(array($data["dtime"], $row['id']));
        }
        if (is_null($row["avatar"]))
            $row["avatar"] = 0;
        else
            $row["avatar"] = 1;
        $row['status'] = 0;
        $row['msg'] = "ok";
    } else {
        $row['status'] = 1;
        $row['msg'] = "Логин(телефон или почта) не найден";
    }

    return json_encode($row, JSON_UNESCAPED_UNICODE);
}
