<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

if ($newPassword != $confirmPassword) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: reset_password.php");
    exit();
}

require 'db.php';

$email = $_SESSION['email'];

$sql = "UPDATE Administrators SET Pass = ? WHERE Gmail = ?";
$params = array($newPassword, $email);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
$_SESSION = array();
session_unset();
session_destroy();

header("Location: login_main.php");
exit();
?>
