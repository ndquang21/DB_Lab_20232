<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $OldLicense = $_SESSION['OldLicense'];
    unset($_SESSION['OldLicense']);
    $SoBangLai = $_POST['input-sobanglai'];
    $NgayCap = $_POST['input-ngaycap'];
    $NoiCap = $_POST['input-noicap'];
    $NgayHetHan = $_POST['input-ngayhethan'];
    $LoaiBang = $_POST['input-loaibang'];
    $SoCCCD = $_POST['input-cccd'];
    $MaSoDoanhNghiep = $_POST['input-masodoanhnghiep'];
}
$select = "SELECT SoCCCD FROM NguoiSoHuu WHERE SoCCCD = ?";                 // kiểm tra FOREIGN KEY
    $params = array($SoCCCD);
    $stmt = sqlsrv_query($conn, $select, $params);

    if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
    }
    if (sqlsrv_has_rows($stmt) === true) {         //trong csdl có số cccd này thì tiếp tục kiểm tra masodoanhnghiep
        $select = "SELECT MaSoDoanhNghiep FROM CoSoDaoTaoCapBang WHERE MaSoDoanhNghiep = ?";
        $params = array($MaSoDoanhNghiep);
        $stmt = sqlsrv_query($conn, $select, $params); 
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_has_rows($stmt) === true) {  //trong csdl có ma so doanh nghiep nay
            # sửa thông tin bằng lái xe
            $update = " UPDATE BangLaiXe SET SoBangLai = ?, NgayCap = ?, NoiCap = ?, NgayHetHan = ?, LoaiBang = ?, SoCCCD = ? , MaSoDoanhNghiep = ? 
                        WHERE SoBangLai = ?";
            $params = array($SoBangLai, $NgayCap, $NoiCap, $NgayHetHan, $LoaiBang, $SoCCCD, $MaSoDoanhNghiep, $OldLicense);
            $stmt = sqlsrv_prepare($conn, $update, $params);
            if ($stmt) {
                sqlsrv_execute($stmt);
            } else {
                die(print_r(sqlsrv_errors(), true));
            }
            }else {
                $_SESSION['error'] = "Doanh nghiệp không tồn tại.";
                header("Location: e-driverLicense.php");
                exit();
            }    
        }else {
            $_SESSION['error'] = "Người dùng không tồn tại.";
            header("Location: e-driverLicense.php");
            exit();
        }
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header("Location: e-driverLicense.php");
exit();
?>