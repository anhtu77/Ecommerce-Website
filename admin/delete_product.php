<?php
session_start(); 

include('../server/connection.php');

// Kiểm tra xem người dùng đã đăng nhập dưới quyền admin chưa
if (!isset($_SESSION['admin_logged_in'])) {
    header('location:login.php');
    exit;
}

// Kiểm tra nếu có tham số 'product_id' trong URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Kiểm tra giá trị của product_id (phải là số)
    if (!is_numeric($product_id)) {
        echo "<script>
                alert('Invalid product ID.');
                window.location.href = 'products.php';
              </script>";
        exit;
    }

    // Xóa các bản ghi trong bảng product_sizes có product_id tương ứng
    $stmt_sizes = $conn->prepare("DELETE FROM product_sizes WHERE product_id = ?");
    if (!$stmt_sizes) {
        die("Prepare failed: " . $conn->error);  // In lỗi nếu không chuẩn bị được câu truy vấn
    }
    $stmt_sizes->bind_param('i', $product_id);
    if (!$stmt_sizes->execute()) {
        echo "<script>
                alert('Error occurred while deleting related sizes.');
                window.location.href = 'products.php';
              </script>";
        exit;
    }

    // Câu lệnh SQL để xóa sản phẩm theo product_id
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);  // In lỗi nếu không chuẩn bị được câu truy vấn
    }

    // Gắn tham số vào câu truy vấn
    $stmt->bind_param('i', $product_id);

    // Thực thi câu truy vấn và kiểm tra kết quả
    if ($stmt->execute()) {
        echo "<script>
                alert('Product has been deleted successfully.');
                window.location.href = 'products.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error occurred, try again: " . $stmt->error . "');
                window.location.href = 'products.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('No product ID provided.');
            window.location.href = 'products.php';
          </script>";
    exit;
}
?>
