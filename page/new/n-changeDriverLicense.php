<?php
//connect
require '../../db.php';
// connect
$SoGPLX = $_POST['input-sobanglai'];
$NgayCapDoi = $_POST['input-ngaycapdoi'];
$LyDoDoi = $_POST['input-lydo'];  
               
$select = " SELECT SoBangLai
            FROM BangLaiXe
            WHERE SoBangLai = ?";
$params = array($SoGPLX);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === true) {         //trong csdl có số gplx này
    #cho phép thêm
    $insert = " INSERT INTO CapDoiBangLai (SoBangLai, NgayCapDoi, LyDoDoi) VALUES (?,?,?)";
    $params = array($SoGPLX, $NgayCapDoi, $LyDoDoi);
    $stmt = sqlsrv_prepare($conn, $insert, $params);
    if ($stmt) {
        sqlsrv_execute($stmt);

    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}else {
    $_SESSION['error'] = "Bằng lái không tồn tại";
    header("Location:n-changeDriverLicense_html.php");
    exit();
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location:n-changeDriverLicense_html.php");
exit();
?>