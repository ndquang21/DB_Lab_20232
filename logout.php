<?php
session_start();

session_unset();
session_destroy();

// Xóa cache
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

header("Location: ./login_main.php");
exit();
?>