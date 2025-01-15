<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SoBangLai = $_POST['SoBangLai'];
    $NgayCapDoi = $_POST['NgayCapDoi'];
    
    $sql = "DELETE FROM CapDoiBangLai WHERE SoBangLai = ? AND NgayCapDoi = ?";
    $params = array($SoBangLai, $NgayCapDoi);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    echo "success";
}
?>