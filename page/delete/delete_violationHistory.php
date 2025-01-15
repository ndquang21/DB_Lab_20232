<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SoBangLai = $_POST['SoBangLai'];
    $NgayViPham = $_POST['NgayViPham'];
    
    $sql = "DELETE FROM LichSuViPham WHERE SoBangLai = ? AND NgayViPham = ?";
    $params = array($SoBangLai, $NgayViPham);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    echo "success";
}
?>