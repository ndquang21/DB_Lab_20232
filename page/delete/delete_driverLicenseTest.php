<?php
require '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SoCCCD = $_POST['SoCCCD'];
    $LoaiBang = $_POST['LoaiBang'];
    
    $sql = "DELETE FROM LichSuDaoTaoSatHach WHERE SoCCCD = ? AND LoaiBang = ?";
    $params = array($SoCCCD, $LoaiBang);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    echo "success";
}
?>