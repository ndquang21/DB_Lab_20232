<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $OldCCCD = $_SESSION['OldCCCD'];
    unset($_SESSION['OldCCCD']);
    $CCCD = $_POST['input-cccd'];
    $HoTen = $_POST['input-hoten'];
    $SDT = $_POST['input-sodienthoai'];
    $DiaChi = $_POST['input-diachi'];
    $NgaySinh = $_POST['input-ngaysinh'];
    $GioiTinh = $_POST['input-gioitinh'];
}
    # sửa thông tin người sở hữu
    $update = " UPDATE NguoiSoHuu SET SoCCCD = ?, HoTen = ?, SoDienThoai = ?, DiaChi = ?, NgaySinh = ?, GioiTinh = ? WHERE SoCCCD = ?";
    $params = array($CCCD, $HoTen, $SDT, $DiaChi, $NgaySinh, $GioiTinh, $OldCCCD);
    $stmt = sqlsrv_prepare($conn, $update, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);
    } else {
        $_SESSION['error'] = "Không thể thay đổi";
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header('location:e-driver.php');
exit();
?>