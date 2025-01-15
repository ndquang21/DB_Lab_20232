<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SoCCCD = $_POST['SoCCCD'];

    // Kiểm tra và xóa bản ghi
    $sql = "DELETE FROM NguoiSoHuu WHERE SoCCCD = ?";
    $params = array($SoCCCD);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    echo "success";
}
?>
