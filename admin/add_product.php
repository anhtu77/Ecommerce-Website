<?php  
include('header.php'); 

// Kết nối cơ sở dữ liệu và lấy danh sách categories
$categories_result = $conn->query("SELECT * FROM categories");

// Lấy danh sách sizes (các kích thước có sẵn)
$sizes_result = $conn->query("SELECT * FROM sizes");

// Tạo danh sách kích thước dưới dạng JSON
$sizes = [];
if ($sizes_result->num_rows > 0) {
    while ($size = $sizes_result->fetch_assoc()) {
        $sizes[] = $size;
    }
}
?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Add Product</h6>

        <div class="table-responsive">
            <div class="mx-auto container">
                <form method="POST" action="create_product.php" enctype="multipart/form-data">

                    <!-- Các thông tin cơ bản của sản phẩm -->
                    <div class="form-group mt-2">
                        <label for="product-name">Product Name</label>
                        <input type="text" class="form-control" id="product-name" name="product_name" placeholder="Product Name" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="product-desc">Description</label>
                        <input type="text" class="form-control" id="product-desc" name="product_description" placeholder="Description" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="product-price">Price</label>
                        <input type="text" class="form-control" id="product-price" name="product_price" placeholder="Price" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php 
                            if ($categories_result->num_rows > 0) {
                                while ($category = $categories_result->fetch_assoc()) {
                                    echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Các thông tin về kích thước và số lượng -->
                    <div class="form-group mt-2">
                        <label for="product-size">Size and Stock</label>
                        <div id="size-container">
                            <div class="size-item d-flex align-items-center gap-3">
                                <label class="form-label">Size:</label>
                                <select class="form-control size-select" name="size_ids[]" required>
                                    <option value="">Select Size</option>
                                    <?php 
                                    foreach ($sizes as $size) {
                                        echo "<option value='{$size['size_id']}'>{$size['size_name']}</option>";
                                    }
                                    ?>
                                </select>
                                
                                <label class="form-label ms-3">Stock:</label>
                                <input type="number" class="form-control stock-input" name="stocks[]" placeholder="Stock Quantity" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link mt-2" id="add-size-btn">Add Size</button>
                    </div>

                    <!-- Ô nhập tổng số lượng -->
                    <div class="form-group mt-2">
                        <label for="product_stock">Total Stock:</label>
                        <input type="number" class="form-control" id="product_stock" name="product_stock" placeholder="Total Stock" readonly>
                    </div>

                    <!-- Thông tin màu sắc và hình ảnh -->
                    <div class="form-group mt-2">
                        <label for="product-color">Color</label>
                        <input type="text" class="form-control" id="product-color" name="product_color" placeholder="Color" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="image1">Image 1</label>
                        <input type="file" class="form-control" id="image1" name="product_image1" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="image2">Image 2</label>
                        <input type="file" class="form-control" id="image2" name="product_image2">
                    </div>

                    <div class="form-group mt-2">
                        <label for="image3">Image 3</label>
                        <input type="file" class="form-control" id="image3" name="product_image3">
                    </div>

                    <div class="form-group mt-2">
                        <label for="image4">Image 4</label>
                        <input type="file" class="form-control" id="image4" name="product_image4">
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" name="create_product" value="Create">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer"></footer>

<script>
    const sizes = <?php echo json_encode($sizes); ?>;

    // Hàm cập nhật tổng số lượng
    function updateTotalStock() {
        let totalStock = 0;
        document.querySelectorAll('.stock-input').forEach(input => {
            const value = parseInt(input.value) || 0;
            totalStock += value;
        });
        document.getElementById('product_stock').value = totalStock;
    }

    // Thêm size mới
    document.getElementById('add-size-btn').addEventListener('click', function() {
        const sizeContainer = document.getElementById('size-container');
        const newSizeItem = document.createElement('div');
        newSizeItem.classList.add('size-item', 'd-flex', 'align-items-center', 'gap-3');
        newSizeItem.innerHTML = `
            <label class="form-label">Size:</label>
            <select class="form-control size-select" name="size_ids[]" required>
                ${sizes.map(size => `<option value="${size.size_id}">${size.size_name}</option>`).join('')}
            </select>
            <label class="form-label ms-3">Stock:</label>
            <input type="number" class="form-control stock-input" name="stocks[]" placeholder="Stock Quantity" required>
        `;
        sizeContainer.appendChild(newSizeItem);

        // Gắn sự kiện lắng nghe
        newSizeItem.querySelector('.stock-input').addEventListener('input', updateTotalStock);
    });

    // Cập nhật tổng số lượng khi thay đổi
    document.getElementById('size-container').addEventListener('input', function(e) {
        if (e.target.classList.contains('stock-input')) {
            updateTotalStock();
        }
    });
</script>
