<?php include('../server/connection.php');

if(isset($_POST['create_product'])) {

    // Lấy dữ liệu từ form
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['category_id'];
    $product_color = $_POST['product_color'];

    // Các hình ảnh của sản phẩm
    $product_image1 = $_FILES['product_image1']['tmp_name'];
    $product_image2 = $_FILES['product_image2']['tmp_name'];
    $product_image3 = $_FILES['product_image3']['tmp_name'];
    $product_image4 = $_FILES['product_image4']['tmp_name'];

    // Đặt tên cho các hình ảnh
    $image_name1 = $product_name."1.jpeg";
    $image_name2 = $product_name."2.jpeg";
    $image_name3 = $product_name."3.jpeg";
    $image_name4 = $product_name."4.jpeg";

    // Di chuyển hình ảnh vào thư mục
    move_uploaded_file($product_image1,"../assets/images/".$image_name1);
    move_uploaded_file($product_image2,"../assets/images/".$image_name2);
    move_uploaded_file($product_image3,"../assets/images/".$image_name3);
    move_uploaded_file($product_image4,"../assets/images/".$image_name4);

    // Thêm sản phẩm vào bảng products
    $stmt = $conn->prepare("INSERT INTO products 
        (product_name, product_description, product_price, product_image, product_image2, product_image3, product_image4, product_category, product_color)
        VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param('sssssssss', 
        $product_name, 
        $product_description, 
        $product_price, 
        $image_name1, 
        $image_name2, 
        $image_name3, 
        $image_name4, 
        $product_category, 
        $product_color
    );

    if ($stmt->execute()) {
        $product_id = $stmt->insert_id; // Lấy ID của sản phẩm vừa tạo
        
        // Xử lý thông tin về kích thước và số lượng
        $size_ids = $_POST['size_ids']; // Mảng chứa các size_id
        $stocks = $_POST['stocks']; // Mảng chứa số lượng cho từng kích thước
        
        foreach ($size_ids as $index => $size_id) {
            $stock = $stocks[$index];

            // Thêm thông tin kích thước và số lượng vào bảng product_size
            $stmt_size = $conn->prepare("INSERT INTO product_size (product_id, size_id, stock) 
                VALUES (?, ?, ?)");
            $stmt_size->bind_param('iii', $product_id, $size_id, $stock);

            if (!$stmt_size->execute()) {
                echo "<script>
                    alert('Error occurred while adding size and stock information.');
                    window.location.href = 'products.php';
                </script>";
                exit;
            }
        }

        // Hiển thị thông báo thành công và chuyển hướng
        echo "<script>
            alert('Product has been created successfully.');
            window.location.href = 'products.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Error occurred, try again.');
            window.location.href = 'products.php';
        </script>";
        exit;
    }
}
?>
