<?php
session_start();

if (!isset($_SESSION['verification_code']) || !isset($_SESSION['email']) || !isset($_SESSION['code_sent_time'])) {
    header("Location: forgot_password.php");
    exit();
}

$inputCode = $_POST['code'];
$verificationCode = $_SESSION['verification_code'];
$codeSentTime = $_SESSION['code_sent_time'];
$timeLimit = 900;

if (time() - $codeSentTime > $timeLimit) {
    $_SESSION['error'] = "Verification code has expired.";
    header("Location: forgot_password.html");
    exit();
}

if ($inputCode == $verificationCode) {
    header("Location: reset_password.php");
    exit();
} else {
    $_SESSION['error'] = "Incorrect verification code.";
    header("Location: verify_code.php");
    exit();
}
?>
