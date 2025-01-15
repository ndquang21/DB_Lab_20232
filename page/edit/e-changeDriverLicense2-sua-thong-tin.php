<?php
// Kết nối cơ sở dữ liệu
require '../../db.php';
session_start();

if (isset($_POST['submit-btn'])) {
    $SoBangLaiCu = $_SESSION['licenseNum'];
    unset($_SESSION['licenseNum']);
    $SoBangLai = $_POST['input-sobanglai'];
    $NgayCapDoi = $_POST['input-ngaycapdoi'];
    $LyDoDoi = $_POST['input-lydo'];

    // Kiểm tra sự tồn tại của bằng lái xe mới
    $sql = "SELECT * FROM BangLaiXe WHERE SoBangLai = ?";
    $params = array($SoBangLai);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        // Sửa thông tin người sở hữu
        $update = "UPDATE CapDoiBangLai SET NgayCapDoi = ?, LyDoDoi = ?, SoBangLai = ? WHERE SoBangLai = ?";
        $params = array($NgayCapDoi, $LyDoDoi, $SoBangLai, $SoBangLaiCu);
        $stmt = sqlsrv_prepare($conn, $update, $params);
        
        // Kiểm tra nếu câu lệnh chuẩn bị thành công
        if ($stmt) {
            if (sqlsrv_execute($stmt) === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }
    } else {
        $_SESSION['error'] = "Không tồn tại bằng lái mới nhập";
        header("Location: e-changeDriverLicense.php");
        exit();
    }

    // Giải phóng tài nguyên và đóng kết nối
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    // Chuyển hướng sau khi hoàn thành
    header("Location: e-changeDriverLicense.php");
    exit();
} else {
    header("Location: e-changeDriverLicense.php");
    exit();
}
?>
