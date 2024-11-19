<?php 
include('../server/connection.php');

if (isset($_POST['create_product'])) {

    // Lấy dữ liệu từ form
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['category_id'];
    $product_color = $_POST['product_color'];
    $product_stock = $_POST['product_stock'];

    // Kiểm tra dữ liệu
    if (empty($product_name) || empty($product_description) || empty($product_price) || empty($product_category) || empty($product_color) || empty($product_stock)) {
        die("One or more required fields are empty.");
    }

    // Các hình ảnh của sản phẩm
    $product_image1 = $_FILES['product_image1']['tmp_name'];
    $product_image2 = $_FILES['product_image2']['tmp_name'];
    $product_image3 = $_FILES['product_image3']['tmp_name'];
    $product_image4 = $_FILES['product_image4']['tmp_name'];

    // Đặt tên cho các hình ảnh
    $image_name1 = $product_name . "1.jpeg";
    $image_name2 = $product_name . "2.jpeg";
    $image_name3 = $product_name . "3.jpeg";
    $image_name4 = $product_name . "4.jpeg";

    // Di chuyển hình ảnh vào thư mục
    move_uploaded_file($product_image1, "../assets/images/" . $image_name1);
    move_uploaded_file($product_image2, "../assets/images/" . $image_name2);
    move_uploaded_file($product_image3, "../assets/images/" . $image_name3);
    move_uploaded_file($product_image4, "../assets/images/" . $image_name4);

    // Thêm sản phẩm vào bảng products
    $stmt = $conn->prepare("INSERT INTO products 
        (product_name, product_description, product_price, product_image, product_image2, product_image3, product_image4, product_category, product_color, product_stock)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('sssssssssi', 
        $product_name, 
        $product_description, 
        $product_price, 
        $image_name1, 
        $image_name2, 
        $image_name3, 
        $image_name4, 
        $product_category, 
        $product_color,
        $product_stock
    );

    if ($stmt->execute()) {
        $product_id = $stmt->insert_id;

        // Xử lý thông tin về kích thước và số lượng
        $size_ids = $_POST['size_ids'];
        $stocks = $_POST['stocks'];

        foreach ($size_ids as $index => $size_id) {
            $stock = $stocks[$index];

            $stmt_size = $conn->prepare("INSERT INTO product_sizes (product_id, size_id, stock) VALUES (?, ?, ?)");
            if (!$stmt_size) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt_size->bind_param('iii', $product_id, $size_id, $stock);
            if (!$stmt_size->execute()) {
                die("Error occurred while adding size and stock information: " . $stmt_size->error);
            }
        }

        echo "<script>
            alert('Product has been created successfully.');
            window.location.href = 'products.php';
        </script>";
        exit;
    } else {
        die("Error occurred: " . $stmt->error);
    }
}
?>
