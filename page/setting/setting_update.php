<?php
require "../../db.php";
$gmail = $_SESSION['email'];
$curr_pass = $_POST['currentpass'];
$new_pass = $_POST['newpass'];
$confirm_Password = $_POST['confirmpass'];

$select = "SELECT * FROM Administrators WHERE Gmail = ? AND Pass = ?";
$params = array($gmail, $curr_pass);
$stmt = sqlsrv_query($conn, $select, $params);

if (sqlsrv_has_rows($stmt)) {
    if ($new_pass === $confirm_Password) {
        $select = "UPDATE Administrators SET Pass = ? WHERE Gmail = ?";
        $params = array($new_pass, $gmail);
        $stmt = sqlsrv_query($conn, $select, $params);
    }
    else {
        $_SESSION['error'] = "Mật khẩu xác nhận không trùng với mật khẩu mới";
        header("Location: setting.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Sai mật khẩu cũ.";
    header("Location: setting.php");
    exit();
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header("Location: setting.php");
exit();
?>