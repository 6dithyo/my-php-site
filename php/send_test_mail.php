<?php
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require __DIR__ . '/mail_config.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $config['host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['username'];
    $mail->Password   = $config['password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $config['port'];

    $mail->setFrom($config['from'], $config['fromName']);
    $mail->addAddress($config['username']); // ✅ FIXED

    $mail->isHTML(true);
    $mail->Subject = 'FitTrack Email Test';
    $mail->Body    = 'If you see this, email works 🎉';

    $mail->send();
    echo 'Email sent successfully';
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
