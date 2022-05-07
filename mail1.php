<?php
$to      = 'yaa52@mail.ru';
$subject = 'yaa';
$message = 'hello';
$headers = 'From: robot@tuktuk.su' . "\r\n" .
    'Reply-To: robot@tuktuk.su' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>