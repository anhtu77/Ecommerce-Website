<?php 

session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    if (isset($_SESSION['logged_in']) && $_SESSION['role'] === 'admin') {
        // Hủy session của admin
        unset($_SESSION['logged_in']);
        unset($_SESSION['role']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        
        // Chuyển hướng đến trang đăng nhập
        header('location: ../login.php');
        exit;
    }
}

?>
