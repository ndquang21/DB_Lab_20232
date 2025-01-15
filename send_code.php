<?php
require 'vendor/src/Exception.php';
require 'vendor/src/PHPMailer.php';
require 'vendor/src/SMTP.php';
require 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = $_POST['email'];

$sql = "SELECT * FROM Administrators WHERE Gmail = ?";
$params = array($email);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === false) {
    $_SESSION['error'] = "Email not found.";
    header("Location: forgot_password.php");
    exit();
}

$code = rand(100000, 999999);
$_SESSION['verification_code'] = $code;
$_SESSION['email'] = $email;
$_SESSION['code_sent_time'] = time();

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'hieu.dhm172808@gmail.com';                     //SMTP username
    $mail->Password   = 'sdsl zyoa qnmx ewiv';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to;

    //Recipients
    $mail->setFrom('hieu.dhm172808@gmail.com', 'Driver License Host');
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Your Verification Code';
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .all {
                margin-right: 350px;
                font-size: large;
                text-align: center;
            }
            * {
                background-color: black;
                color: white;
            }
            .code {
                text-align: center;
                border: 2px solid #dbbf20;
                padding-top: 0.5%;
                width: 90px;
                height: 30px;
                margin: 0 auto;
            }
        </style>
        <title>Verification Code</title>
    </head>
    <body>
        <div class="all">Your verification code is:</div>
        <h3 class="code">'.$code.'</h3>
        <div class="all">Your code is valid for 15 minutes</div>
    </body>
    </html>';
    $mail->AltBody = 'Your verification code is: ' . $code . '. Your code is valid for 15 minutes.';
    $mail->send();
    header("Location: verify_code.php");
} catch (Exception $e) {
    $_SESSION['error'] = "Failed to send verification code.";
    header("Location: forgot_password.php");
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
