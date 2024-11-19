<?php include('header.php'); 
// Lấy danh sách categories để người dùng chọn loại sản phẩm
$categories_result = $conn->query("SELECT * FROM categories"); ?>


<?php 
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];
  
  
  // Truy vấn sản phẩm dựa trên product_id
  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param('i', $product_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  // Kiểm tra nếu có sản phẩm được trả về
  if ($result->num_rows > 0) {
      $products = $result->fetch_all(MYSQLI_ASSOC); // Lưu kết quả vào mảng $products
  } else {
      echo "Product not found.";
      exit; // Kết thúc mã nếu không có sản phẩm
  }
} elseif (isset($_POST['edit_btn'])) {
  // Kiểm tra nếu tất cả các dữ liệu POST đã được gửi
  if (isset($_POST['product_id'], $_POST['title'], $_POST['description'], $_POST['price'], $_POST['color'], $_POST['category'],$_POST['stock'])) {
      // Cập nhật thông tin sản phẩm
      $product_id = $_POST['product_id'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $color = $_POST['color'];
      $category = $_POST['category'];
      $stock = $_POST['stock'];
      $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, product_color=?, product_category=?, product_stock=? WHERE product_id=?");
      $stmt->bind_param('sssssii', $title, $description, $price, $color, $category, $stock, $product_id);
      
      
      if ($stmt->execute()) {
        echo "<script>
                alert('Product has been updated successfully.');
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
    
      } else {
      echo "Missing POST data.";
      exit;
      }
      } else {
      echo "Invalid access.";
      exit;
}
?>

<div class="container">
  <div class="page-inner">
      <h3 class="fw-bold mb-3">Dashboard</h3>
      <h6 class="op-7 mb-2">Edit Products</h6>
      
      <div class="table-responsive">
          <div class="mx-auto container">
              <form id="edit_form" method="POST" action="edit_product.php">
                  <?php if (!empty($products)) : ?>
                      <?php foreach ($products as $product) : ?>
                          <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                          
                          <div class="form-group mt-2">
                              <label>Title</label>
                              <input type="text" class="form-control" value="<?php echo $product['product_name']; ?>" name="title" required>
                          </div>
                          <div class="form-group mt-2">
                              <label>Description</label>
                              <input type="text" class="form-control" value="<?php echo $product['product_description']; ?>" name="description" required>
                          </div>
                          <div class="form-group mt-2">
                              <label>Price</label>
                              <input type="text" class="form-control" value="<?php echo $product['product_price']; ?>" name="price" required>
                          </div>
                          <div class="form-group mt-2">
                              <label for="category_id">Category</label>
                              <select class="form-control" id="category_id" name="category" required>
                                  <option value="">Select Category</option>
                                  <?php 
                                  if ($categories_result->num_rows > 0) {
                                      while ($category = $categories_result->fetch_assoc()) {
                                          // Kiểm tra nếu danh mục hiện tại khớp với giá trị trong sản phẩm
                                          $selected = ($category['category_name'] == $product['product_category']) ? 'selected' : '';
                                          echo "<option value='{$category['category_name']}' $selected>{$category['category_name']}</option>";
                                      }
                                  }
                                  ?>
                              </select>
                          </div>

                          <div class="form-group mt-2">
                              <label>Stock</label>
                              <input type="text" class="form-control" value="<?php echo $product['product_stock']; ?>" name="stock" required>
                          </div>
                          <div class="form-group mt-2">
                              <label>Color</label>
                              <input type="text" class="form-control" value="<?php echo $product['product_color']; ?>" name="color" required>
                          </div>
                          
                          <div class="form-group mt-3">
                              <input type="submit" class="btn btn-primary" name="edit_btn" value="Edit">
                          </div>
                      <?php endforeach; ?>
                  <?php else : ?>
                      <p>No product data found.</p>
                  <?php endif; ?>
              </form>
          </div>
      </div>
  </div>
</div>

<?php $conn->close(); ?>
   

        <footer class="footer">
         
        </footer>


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
  </body>
</html>
