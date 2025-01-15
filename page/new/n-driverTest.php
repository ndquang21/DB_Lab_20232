<?php
// Connect
include '../../db.php';

if(isset($_POST['submit-btn'])){
    $CCCD = $_POST['input-cccd'];
    $NgayThi = $_POST['input-ngaythi'];
    $LoaiBang = $_POST['input-loaibang'];
    $DiemLyThuyet = $_POST['input-diemlt'];
    $DiemThucHanh = $_POST['input-diemth'];
}

$select = "SELECT SoCCCD FROM NguoiSoHuu WHERE SoCCCD = ?";
$params = array($CCCD);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt)) { 
    $check = "SELECT * FROM LichSuDaoTaoSatHach WHERE SoCCCD = ? AND LoaiBang = ? AND KetQua = N'Đạt'";
    $params = array($CCCD, $LoaiBang);
    $sql = sqlsrv_query($conn, $check, $params);
    
    if (sqlsrv_has_rows($sql)) {
        $_SESSION['error'] = "Người này đã qua bài thi";
        header("Location: n-driverTest_html.php");
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        exit();
    }

    $insert = "INSERT INTO LichSuDaoTaoSatHach (SoCCCD, NgayThi, LoaiBang, DiemLyThuyet, DiemThucHanh) VALUES (?, ?, ?, ?, ?)";
    $params = array($CCCD, $NgayThi, $LoaiBang, $DiemLyThuyet, $DiemThucHanh);
    $stmt = sqlsrv_prepare($conn, $insert, $params);

    if ($stmt) {
        if (sqlsrv_execute($stmt) === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
} else {
    $_SESSION['error'] = "Không tồn tại người này";
    header("Location: n-driverTest_html.php");
    exit();
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header("Location: n-driverTest_html.php");
exit();
?>