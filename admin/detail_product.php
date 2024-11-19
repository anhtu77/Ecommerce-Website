<?php 
include('header.php'); 

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy thông tin sản phẩm
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();

        // Lấy thông tin kích thước liên quan
        $size_stmt = $conn->prepare("SELECT ps.size_id, ps.stock, s.size_name FROM product_sizes ps JOIN sizes s ON ps.size_id = s.size_id WHERE ps.product_id = ?");
        $size_stmt->bind_param('i', $product_id);
        $size_stmt->execute();
        $sizes_result = $size_stmt->get_result();
        $product_sizes = $sizes_result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid access.";
    exit;
}
?>


    <div class="container">
        <h3 class="fw-bold mb-3">Product Details</h3>

        <!-- Hiển thị thông tin sản phẩm -->
        <div class="product-details">
            <h4><?php echo $product['product_name']; ?></h4>
            <h4> <img src="<?php echo "../assets/images/". $product['product_image']; ?>" style="width: 70px; height:70px;"/></h4>
            <p><strong>Description:</strong> <?php echo $product['product_description']; ?></p>
            <p><strong>Price:</strong> <?php echo number_format($product['product_price'], 2); ?> USD</p>
            <p><strong>Color:</strong> <?php echo $product['product_color']; ?></p>
            <p><strong>Category:</strong> <?php echo $product['product_category']; ?></p>
            <p><strong>Total Stock:</strong> <?php echo $product['product_stock']; ?></p>

            <!-- Hiển thị các size và số lượng tồn -->
            <h5>Available Sizes</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($product_sizes) > 0): ?>
                        <?php foreach ($product_sizes as $size): ?>
                            <tr>
                                <td><?php echo $size['size_name']; ?></td>
                                <td><?php echo $size['stock']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No sizes available for this product.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>



