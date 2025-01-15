<?php
//connect
require '../../db.php';
$SoBangLai = $_POST['input-sobanglai'];
$NgayViPham = $_POST['input-ngayvipham'];
$MoTaViPham = $_POST['input-motavipham'];
$MucPhat = $_POST['input-mucphat'];                    

$select = " SELECT SoBangLai
            FROM BangLaiXe
            WHERE SoBangLai = ?";
$params = array($SoBangLai);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === true) {         //trong csdl có số bằng lái này
    $insert = "INSERT INTO LichSuViPham (SoBangLai, NgayViPham, MoTaViPham, MucPhat) VALUES (?,?,?,?)";
    $params = array($SoBangLai, $NgayViPham, $MoTaViPham, $MucPhat);
    $stmt = sqlsrv_prepare($conn, $insert, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);

    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}else {
    $_SESSION['error'] = "Bằng lái không tồn tại";
    header("Location:n-violation_html.php");
    exit();
}
header("Location:n-violation_html.php");
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>