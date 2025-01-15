<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $CCCD = $_POST['input-cccd'];
    $HoTen = $_POST['input-name'];
    $SDT = $_POST['input-phonenumber'];
    $NgaySinh = $_POST['input-birthday'];
    $GioiTinh = $_POST['input-gender'];
    $DiaChi = $_POST['input-address'];                       
}
if ($GioiTinh == "selectsex"){
    $GioiTinh = " ";
}

$select = " SELECT SoCCCD
            FROM NguoiSoHuu
            WHERE SoCCCD = ?";
$params = array($CCCD);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === false) {         //trong csdl chưa có số cccd này
    #thêm người sở hữu
    $insert = " INSERT INTO NguoiSoHuu (SoCCCD, HoTen, SoDienThoai, DiaChi, NgaySinh, GioiTinh) VALUES (?,?,?,?,?,?)";
    $params = array($CCCD, $HoTen, $SDT, $DiaChi, $NgaySinh, $GioiTinh);
    $stmt = sqlsrv_query($conn, $insert, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}else {
    $_SESSION['error'] = "Người sở hữu đã tồn tại";
    header("Location:n-driver_html.php");
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    exit();
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location:n-driver_html.php");
exit();
?>