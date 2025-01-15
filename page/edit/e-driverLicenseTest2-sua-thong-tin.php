<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $OldDate = $_SESSION['NgayThi'];
    $OldID = $_SESSION['SoCCCD'];
    unset($_SESSION['NgayThi']);
    unset($_SESSION['SoCCCD']);
    $CCCD = $_POST['input-cccd'];
    $NgayThi = $_POST['input-ngaythi'];
    $LoaiBang = $_POST['input-loaibang'];
    $DiemLyThuyet = $_POST['input-diemlt'];
    $DiemThucHanh = $_POST['input-diemth'];
}
    # sửa thông tin bằng lái xe
    $update = " UPDATE LichSuDaoTaoSatHach SET SoCCCD = ?, NgayThi = ?, LoaiBang = ?, DiemLyThuyet = ?, DiemThucHanh = ? 
                WHERE SoCCCD = ? AND NgayThi = ?";
    $params = array($CCCD, $NgayThi, $LoaiBang, $DiemLyThuyet, $DiemThucHanh, $OldID, $OldDate);
    $stmt = sqlsrv_prepare($conn, $update, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);
    } else {
        $_SESSION['error'] = "Có lỗi khi thực hiện thay đổi";
    }

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location: e-driverLicenseTest.php");
exit();
?>