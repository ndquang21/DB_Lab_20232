<?php
session_start();

$serverName = "MEMORY\\SQLEXPRESS"; 
$connectionInfo = array(
    "Database" => "BangLaiXe",
    "Uid" => "sa",
    "pwd" => "1234567890",
    "TrustServerCertificate" => "true",
    "CharacterSet"=> "UTF-8",
);
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>