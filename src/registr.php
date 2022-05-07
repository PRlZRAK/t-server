<?php
function registr($pdo, $data)
{
    $par_array = array("login" => 2, "phone" => 3, "email" => 4);
    foreach ($par_array as $par_name => $status) {
        if (isset($data[$par_name])) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE $par_name = ? LIMIT 1");
            $res = $stmt->execute(array($data[$par_name]));
            $row = $stmt->fetch();
            if (isset($row['id'])) {
                $ret["status"] = $status;
                $ret["msg"] = "A user with this $par_name = $data[$par_name] already exists#Пользователь с таким $par_name = $data[$par_name] уже есть";
                return json_encode($ret);
            }
        } else {
            $ret["status"] = $status;
            $ret["msg"] = "Missing parameter $par_name#Отсутствует параметр $par_name";
            return json_encode($ret);
        }
    }
    $stmt = $pdo->prepare("INSERT INTO users ( login, phone, email, password) VALUES (?, ?, ?, ?)");
    $res = $stmt->execute(array($data["login"], $data["phone"], $data["email"], $data["password"]));
    $ret["status"] = 0;
    $ret["msg"] = "ok";
    return json_encode($ret);
}
