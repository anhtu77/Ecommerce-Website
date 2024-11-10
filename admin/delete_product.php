<?php
session_start();
include('../server/connection.php');

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không có quyền admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('location: ../login.php');
    exit;
}

// Xử lý yêu cầu xóa sản phẩm
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Chuẩn bị và thực hiện câu truy vấn
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Sản phẩm đã được xóa thành công.');
                window.location.href = 'products.php';
              </script>";
    } else {
        echo "<script>
                alert('Đã xảy ra lỗi, vui lòng thử lại.');
                window.location.href = 'products.php';
              </script>";
    }
    
    // Đóng chuẩn bị truy vấn và kết nối cơ sở dữ liệu
    $stmt->close();
    $conn->close();
    exit;
}
?>
