<?php
//connect
require '../../db.php';
// connect
$MaSoDoanhNghiep = $_POST['input-masodoanhnghiep'];
$TenCoSo = $_POST['input-tencoso'];
$DanhGia = $_POST['input-danhgia'];
$DiaChi = $_POST['input-diachi'];                       
$select = " SELECT MaSoDoanhNghiep
            FROM CoSoDaoTaoCapBang
            WHERE MaSoDoanhNghiep = ?";
$params = array($MaSoDoanhNghiep);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === false) {         //trong csdl chưa có mã số doanh nghiệp này
    # thực hiện thêm
    $insert = " INSERT INTO CoSoDaoTaoCapBang (MaSoDoanhNghiep, TenCoSo, DiaChi, DanhGia) VALUES (?,?,?,?)";
    $params = array($MaSoDoanhNghiep, $TenCoSo, $DiaChi, $DanhGia);
    $stmt = sqlsrv_prepare($conn, $insert, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);

    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}else {
    $_SESSION['error'] = "Doanh nghiệp này đã tồn tại";
    header("Location:n-drivingTestingFacility_html.php");
    exit();}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location:n-drivingTestingFacility_html.php");
exit();
?>