<?php 
include('header.php'); 

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    
    // Chuẩn bị câu truy vấn để xóa danh mục
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    
    // Thực thi câu truy vấn
    if ($stmt->execute()) {
        echo "<script>
                alert('Category has been deleted successfully.');
                window.location.href = 'categories.php'; // Quay lại trang danh sách categories
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error occurred, try again.');
                window.location.href = 'categories.php'; // Quay lại trang danh sách categories
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Invalid access.');
            window.location.href = 'categories.php'; // Quay lại trang danh sách categories
          </script>";
    exit;
}

$conn->close();
?>
