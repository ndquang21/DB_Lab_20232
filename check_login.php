<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM Administrators WHERE Gmail = ? AND Pass = ?";
    $params = array($email, $password);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: index.php");
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        exit();
    } else {
        $_SESSION['error'] = "Wrong email or password";
        header("Location: login_main.php");
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        exit();
    }
}
?>