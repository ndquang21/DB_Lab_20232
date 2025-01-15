<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SoBangLai = $_POST['SoBangLai'];

    $sql = "DELETE FROM BangLaiXe WHERE SoBangLai = ?";
    $params = array($SoBangLai);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    echo "success";
}
?>