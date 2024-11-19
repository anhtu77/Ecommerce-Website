<?php include('header.php'); ?>

<?php 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    
    // Truy vấn sản phẩm dựa trên category_id
    $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kiểm tra nếu có sản phẩm được trả về
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc(); // Lưu kết quả vào mảng $category
    } else {
        echo "Category not found.";
        exit; // Kết thúc mã nếu không có sản phẩm
    }
} elseif (isset($_POST['edit_btn'])) {
    // Kiểm tra nếu tất cả các dữ liệu POST đã được gửi
    if (isset($_POST['category_id'], $_POST['category_name'])) {
        // Cập nhật thông tin sản phẩm
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        // Kiểm tra dữ liệu đầu vào
        if (empty($category_name)) {
            echo "Category name cannot be empty.";
            exit;
        }

        $stmt = $conn->prepare("UPDATE categories SET category_name=? WHERE category_id=?");
        $stmt->bind_param('si', $category_name, $category_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Category has been updated successfully.');
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
        <h6 class="op-7 mb-2">Edit category</h6>

        <div class="table-responsive">
            <div class="mx-auto container">
                <form id="edit_form" method="POST" action="edit_category.php">
                    <?php if (!empty($category)) : ?>
                        <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                        
                        <div class="form-group mt-2">
                            <label>Title</label>
                            <input type="text" class="form-control" value="<?php echo $category['category_name']; ?>" name="category_name" required>
                        </div>
                    
                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" name="edit_btn" value="Edit">
                        </div>
                    <?php else : ?>
                        <p>No category data found.</p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>

<footer class="footer">
    <!-- Footer content -->
</footer>

<!-- Custom template -->
<div class="custom-template">
    <div class="title">Settings</div>
    <div class="custom-content">
        <!-- Settings content -->
    </div>
</div>

<!-- Core JS Files -->
<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<!-- Additional JS Files -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/plugin/chart.js/chart.min.js"></script>
<script src="assets/js/plugin/datatables/datatables.min.js"></script>

<script>
    // Add any custom JavaScript for the page
</script>
</body>
</html>
