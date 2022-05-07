<?php
// phpmailer files
header("Access-Control-Allow-Origin: *");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Values that the user sends
$name = $_POST['name'];
$email = $_POST['email'];
$text = $_POST['text'];
$file = $_FILES['myfile'];

// Mail creation
$title = "Mail Header";
$body = "
<h2>New mail</h2>
<b>Name:</b> $name<br>
<b>Email:</b> $email<br><br>
<b>Message:</b><br>$text
";

// Settings PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    // $mail->Host       = 'smtp.gmail.com'; // SMTP server
    $mail->Host       = 'smtp.mail.ru'; // SMTP server
    // $mail->Username   = 'your_login'; // Login your email
    $mail->Username   = 'tuktuk01@internet.ru'; // Login your email
    $mail->Password   = 'TTOG2y_rtpi4'; // Password your email
    $mail->SMTPSecure = 'ssl';
    //$mail->SMTPSecure = 'tls';
    $mail->Port       = 465;
    $mail->setFrom('tuktuk01@internet.ru', 'Sender is name'); // Mail address itself and sender's name

    // Receiver of mail
    $mail->addAddress('yaa52@mail.ru');
   // $mail->addAddress('yaa@srpu.ru'); // One more, if you need

    // Attach files to a message
    if (!empty($file['name'][0])) {
        for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
            $filename = $file['name'][$ct];
            if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
                $rfile[] = "File $filename attached";
            } else {
                $rfile[] = "Failed to attach the file $filename";
            }
        }
    }

    // Sending a message
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Checking for poisoning
    if ($mail->send()) {
        $result = "success";
    } else {
        $result = "error";
    }
} catch (Exception $e) {
    $result = "error";
    $status = "Message was not sent. Cause of the error: {$mail->ErrorInfo}";
}

// Display result
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
