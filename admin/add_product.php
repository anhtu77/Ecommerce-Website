<?php 
include('header.php'); 


// Lấy danh sách categories để người dùng chọn loại sản phẩm
$categories_result = $conn->query("SELECT * FROM categories");

?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Add Product</h6>

        <div class="table-responsive">
            <div class="mx-auto container">
                <form method="POST" action="create_product.php" enctype="multipart/form-data">

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
                                    // Lưu category_name vào value của option
                                    echo "<option value='{$category['category_name']}'>{$category['category_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    


                    <div class="form-group mt-2">
                        <label for="product-size">Size</label>
                        <input type="text" class="form-control" id="product-size" name="product_size" placeholder="Size" required>
                    </div>


                    <div class="form-group mt-2">
                        <label for="product-stock">Stock</label>
                        <input type="number" class="form-control" id="product-stock" name="product_stock" placeholder="Stock Quantity" required>
                    </div>

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

<!-- Custom template -->
<div class="custom-template">
    <div class="title">Settings</div>
    <div class="custom-content">
        <!-- Add your custom settings here if needed -->
    </div>
</div>

<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

</body>
</html>
