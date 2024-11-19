<?php 
include('header.php'); 

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy danh sách categories và sizes
$categories_result = $conn->query("SELECT * FROM categories");
$sizes_result = $conn->query("SELECT * FROM sizes");

// Tạo danh sách kích thước dưới dạng JSON
$sizes = [];
if ($sizes_result->num_rows > 0) {
    while ($size = $sizes_result->fetch_assoc()) {
        $sizes[] = $size;
    }
}

// Xử lý khi người dùng submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu POST
    if (isset($_POST['product_id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['color'], $_POST['category'], $_POST['size_ids'], $_POST['stocks'])) {
        $product_id = $_POST['product_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $category = $_POST['category'];
        $size_ids = $_POST['size_ids'];
        $stocks = $_POST['stocks'];

        // Tính tổng `product_stock`
        $total_stock = array_sum($stocks);

        // Cập nhật thông tin sản phẩm
        $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, product_color=?, product_category=?, product_stock=? WHERE product_id=?");
        $stmt->bind_param('sssssii', $title, $description, $price, $color, $category, $total_stock, $product_id);

        if ($stmt->execute()) {
            // Xóa các size cũ của sản phẩm
            $delete_stmt = $conn->prepare("DELETE FROM product_sizes WHERE product_id = ?");
            $delete_stmt->bind_param('i', $product_id);
            $delete_stmt->execute();

            // Thêm các size mới
            $insert_stmt = $conn->prepare("INSERT INTO product_sizes (product_id, size_id, stock) VALUES (?, ?, ?)");
            foreach ($size_ids as $index => $size_id) {
                $stock_quantity = $stocks[$index];
                $insert_stmt->bind_param('iii', $product_id, $size_id, $stock_quantity);
                $insert_stmt->execute();
            }

            echo "<script>
                    alert('Product has been updated successfully.');
                    window.location.href = 'products.php';
                  </script>";
        } else {
            echo "<script>alert('Error occurred, try again.');</script>";
        }
    } else {
        echo "Missing POST data.";
    }
    exit;
}

// Lấy thông tin sản phẩm và kích thước (nếu chỉnh sửa)
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
    <h3 class="fw-bold mb-3">Edit Product</h3>
    <form method="POST" action="edit_product.php">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <div class="form-group mt-2">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $product['product_name']; ?>" required>
        </div>

        <div class="form-group mt-2">
            <label>Description</label>
            <input type="text" class="form-control" name="description" value="<?php echo $product['product_description']; ?>" required>
        </div>

        <div class="form-group mt-2">
            <label>Price</label>
            <input type="number" class="form-control" name="price" value="<?php echo $product['product_price']; ?>" required>
        </div>

        <div class="form-group mt-2">
            <label>Category</label>
            <select class="form-control" name="category" required>
                <option value="">Select Category</option>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $category['category_name']; ?>" <?php echo ($category['category_name'] == $product['product_category']) ? 'selected' : ''; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group mt-2">
            <label>Color</label>
            <input type="text" class="form-control" name="color" value="<?php echo $product['product_color']; ?>" required>
        </div>

        <div class="form-group mt-2">
            <label>Sizes</label>
            <div id="size-container">
                <?php foreach ($product_sizes as $product_size): ?>
                    <div class="size-item d-flex align-items-center gap-3 mb-2">
                        <select class="form-control size-select" name="size_ids[]" required>
                            <option value="">Select Size</option>
                            <?php foreach ($sizes as $size): ?>
                                <option value="<?php echo $size['size_id']; ?>" <?php echo ($size['size_id'] == $product_size['size_id']) ? 'selected' : ''; ?>>
                                    <?php echo $size['size_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" class="form-control stock-input" name="stocks[]" placeholder="Stock Quantity" value="<?php echo $product_size['stock']; ?>" required>
                        <button type="button" class="btn btn-danger remove-size-btn">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-link mt-2" id="add-size-btn">Add Size</button>
        </div>

        <div class="form-group mt-2">
            <label>Total Stock (Product Stock)</label>
            <input type="text" class="form-control" id="total-stock" value="<?php echo $product['product_stock']; ?>" readonly>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>
<footer class="footer"></footer>

<script>
    // Hàm tính tổng số lượng tồn
    function updateTotalStock() {
        let totalStock = 0;
        // Lặp qua các ô nhập số lượng tồn của các size
        document.querySelectorAll('.stock-input').forEach(function (input) {
            let stockValue = parseInt(input.value) || 0;
            totalStock += stockValue;
        });
        // Cập nhật giá trị tổng số lượng
        document.getElementById('total-stock').value = totalStock;
    }

    // Cập nhật tổng số lượng khi thay đổi số lượng tồn của size
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('stock-input')) {
            updateTotalStock();
        }
    });

    // Cập nhật tổng số lượng khi thêm hoặc xóa size
    document.getElementById('add-size-btn').addEventListener('click', function () {
        const sizeContainer = document.getElementById('size-container');
        const sizeItem = ` 
            <div class="size-item d-flex align-items-center gap-3 mb-2">
                <select class="form-control size-select" name="size_ids[]" required>
                    <option value="">Select Size</option>
                    <?php foreach ($sizes as $size): ?>
                        <option value="<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" class="form-control stock-input" name="stocks[]" placeholder="Stock Quantity" value="0" required>
                <button type="button" class="btn btn-danger remove-size-btn">Remove</button>
            </div>
        `;
        sizeContainer.insertAdjacentHTML('beforeend', sizeItem);
        updateTotalStock();
    });

    // Xử lý xóa size
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-size-btn')) {
            e.target.closest('.size-item').remove();
            updateTotalStock();
        }
    });

    // Cập nhật tổng số lượng khi trang tải xong
    updateTotalStock();
</script>
