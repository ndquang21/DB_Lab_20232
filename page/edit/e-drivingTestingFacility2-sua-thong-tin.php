<?php
//connect
require '../../db.php';
// connect
$OldDN = $_SESSION['OldDN'];
unset($_SESSION['OldDN']);
$MaSoDoanhNghiep = $_POST['input-masodoanhnghiep'];
$TenCoSo = $_POST['input-tencoso'];
$DiaChi = $_POST['input-diachi'];
$DanhGia = $_POST['input-danhgia'];

    # sửa thông tin doanh nghiệp
    $update = " UPDATE CoSoDaoTaoCapBang SET MaSoDoanhNghiep = ?, TenCoSo = ?, DiaChi = ?, DanhGia = ? WHERE MaSoDoanhNghiep = ?";
    $params = array($MaSoDoanhNghiep, $TenCoSo, $DiaChi, $DanhGia, $OldDN);
    $stmt = sqlsrv_prepare($conn, $update, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);
    } else {
    $_SESSION['error'] = "Có lỗi xảy ra";
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location: e-drivingTestingFacility.php");
exit();
?>