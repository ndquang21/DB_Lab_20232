<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaSoDoanhNghiep = $_POST['MaSoDoanhNghiep'];

    $sql = "DELETE FROM CoSoDaoTaoCapBang WHERE MaSoDoanhNghiep = ?";
    $params = array($MaSoDoanhNghiep);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    echo "success";
}
?>