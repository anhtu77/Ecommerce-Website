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
      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
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
