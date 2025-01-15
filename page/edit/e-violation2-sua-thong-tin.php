<?php
//connect
require '../../db.php';
// connect
$OldBLX = $_SESSION['OldBLX'];
$OldVioDate = $_SESSION['OldVioDate'];
unset($_SESSION['OldBLX']);
unset($_SESSION['OldVioDate']);
$SoBangLai = $_POST['input-sobanglai'];
$NgayViPham = $_POST['input-ngayvipham'];
$MoTaViPham = $_POST['input-motavipham'];
$MucPhat = $_POST['input-mucphat'];
    # sửa thông tin doanh nghiệp
    $update = "UPDATE LichSuViPham SET SoBangLai = ?, NgayViPham = ?, MoTaViPham = ?, MucPhat = ? 
                WHERE SoBangLai = ? AND NgayViPham = ?";
    $params = array($SoBangLai, $NgayViPham, $MoTaViPham, $MucPhat, $OldBLX, $OldVioDate);
    $stmt = sqlsrv_query($conn, $update, $params);
    if ($stmt === false) {
        $_SESSION['error'] = "Bằng lái không tồn tại";
    }
header("Location: e-violation.php");
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
exit();
?>