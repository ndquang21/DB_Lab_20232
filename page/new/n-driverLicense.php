<?php
//connect
require '../../db.php';
// connect
$SoBangLai = $_POST['input-sobanglai'];
$NgayCap = $_POST['input-ngaycap'];
$NoiCap = $_POST['input-noicap'];
$NgayHetHan = $_POST['input-ngayhethan'];
$LoaiBang = $_POST['input-loaibang'];
$SoCCCD = $_POST['input-cccd'];
$MaSoDoanhNghiep = $_POST['input-masodoanhnghiep'];

$select = "SELECT SoBangLai FROM BangLaiXe WHERE SoBangLai = ?";
$params = array($SoBangLai);
$stmt = sqlsrv_query($conn, $select, $params);      //kiểm tra PRIMARY KEY

if (sqlsrv_has_rows($stmt) === false) {    //nếu chưa có số bằng lái này trong csdl thì tiếp tục kiểm tra
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
            $check = "SELECT * FROM LichSuDaoTaoSatHach WHERE SoCCCD = ? AND LoaiBang = ? AND KetQua = N'Đạt'";
            $params = array($SoCCCD, $LoaiBang);
            $sql = sqlsrv_query($conn, $check, $params);
            
            if (!sqlsrv_has_rows($sql)) {
                $_SESSION['error'] = "Người này không qua bài thi hoặc chưa có bài thi";
                header("Location: n-driverLicense_html.php");
                sqlsrv_free_stmt($stmt);
                sqlsrv_close($conn);
                exit();
            }
            $insert = "INSERT INTO BangLaiXe (SoBangLai, NgayCap, NoiCap, NgayHetHan, LoaiBang, SoCCCD, MaSoDoanhNghiep) VALUES (?,?,?,?,?,?,?)";
            $params = array($SoBangLai, $NgayCap, $NoiCap, $NgayHetHan, $LoaiBang, $SoCCCD, $MaSoDoanhNghiep);
            $stmt = sqlsrv_query($conn, $insert, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }else {
            $_SESSION['error'] = "Doanh nghiệp không tồn tại.";
            header("Location: n-driverLicense_html.php");
            exit();
        }    
    }else {
        $_SESSION['error'] = "Người dùng không tồn tại.";
        header("Location: n-driverLicense_html.php");
        exit();
    }
}else {
    $_SESSION['error'] = "Đã tồn tại bằng lái.";
    header("Location: n-driverLicense_html.php");
    exit();
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location: n-driverLicense_html.php");
exit();
?>