<?php 
include('server/connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Lấy thông tin sản phẩm
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result();

    // Lấy danh sách size của sản phẩm từ bảng product_sizes và sizes
    $stmt_sizes = $conn->prepare("SELECT ps.product_size_id, s.size_name, ps.stock 
                                  FROM product_sizes ps 
                                  JOIN sizes s ON ps.size_id = s.size_id 
                                  WHERE ps.product_id = ?");
    $stmt_sizes->bind_param("i", $product_id);
    $stmt_sizes->execute();
    $sizes_result = $stmt_sizes->get_result();
} else {
    header('location: index.php');
    exit();
}

include('layouts/header.php');
?>

<!-- single-product -->
<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <?php while ($row = $product->fetch_assoc()) { ?>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="img-fluid w-100 pb-1" src="assets/images/<?php echo $row['product_image']; ?>" id="mainImg"/>
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-12">
            <h6><?php echo $row['product_category']; ?></h6>
            <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
            <h2><?php echo $row['product_price']; ?></h2>

            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/> 
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

                <!-- Dropdown cho lựa chọn size -->
                <label for="size">Choose size:</label>
                <select name="product_size" id="size">
                    <?php while ($size_row = $sizes_result->fetch_assoc()) { ?>
                        <option value="<?php echo $size_row['product_size_id']; ?>" data-size-name="<?php echo $size_row['size_name']; ?>">
                            <?php echo $size_row['size_name']; ?> - Stock: <?php echo $size_row['stock']; ?>
                        </option>
                    <?php } ?>
                </select>

                <!-- Trường ẩn để lưu tên kích thước (size_name) -->
                <input type="hidden" name="size_name" id="size_name" value=""/>

                <!-- Số lượng sản phẩm -->
                <input type="number" name="product_quantity" value="1" min="1"/>

                <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
            </form>

            <h4 class="mt-5 mb-5">Product details</h4>
            <span><?php echo $row['product_description']; ?></span>
        </div>
        <?php } ?>
    </div>
</section>

<script>
    // Cập nhật size_name khi chọn kích thước
    const sizeDropdown = document.getElementById('size');
    const sizeNameInput = document.getElementById('size_name');
    
    sizeDropdown.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        sizeNameInput.value = selectedOption.getAttribute('data-size-name');
    });

    // Gọi sự kiện change để cập nhật mặc định khi trang tải
    sizeDropdown.dispatchEvent(new Event('change'));
</script>

<?php include('layouts/footer.php'); ?>
