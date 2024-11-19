<?php 
include('../server/connection.php');

if (isset($_POST['create_category'])) {
    // Lấy tên danh mục từ form
    $category_name = $_POST['category_name'];

    // Chuẩn bị câu lệnh SQL để chèn danh mục vào bảng `categories`
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");

    // Gắn tham số vào câu lệnh SQL
    $stmt->bind_param('s', $category_name);

    // Thực thi câu lệnh và kiểm tra kết quả
    if ($stmt->execute()) {
        echo "<script>
            alert('Category has been created successfully.');
            window.location.href = 'categories.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Error occurred, try again.');
            window.location.href = 'categories.php';
        </script>";
        exit;
    }
}
?>

<!-- HTML Form để nhập thông tin danh mục -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Thêm stylesheet nếu cần -->
</head>
<body>
    <div class="container">
        <h2>Create New Category</h2>
        <form action="create_category.php" method="POST">
            <label for="category">Category Name:</label>
            <input type="text" id="category" name="category_name" required><br>

            <button type="submit" name="create_category">Create Category</button>
        </form>
    </div>
</body>
</html>
