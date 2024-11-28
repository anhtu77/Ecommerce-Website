<?php include('header.php'); ?>

<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Giả sử $conn là kết nối tới cơ sở dữ liệu đã được thiết lập
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Order not found.');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Truy vấn dữ liệu từ bảng order_items
    $stmt_items = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt_items->bind_param('i', $order_id);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();

    $order_items = [];
    while ($row = $result_items->fetch_assoc()) {
        $order_items[] = $row;
    }
}
?>

<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Order Details</h6>

        <div class="order-details">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Order ID</th>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                    </tr>
                    <tr>
                        <th>Order Price</th>
                        <td><?php echo htmlspecialchars($order['order_cost']); ?> USD</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                    </tr>
                    <tr>
                        <th>User ID</th>
                        <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                    </tr>
                    <tr>
                        <th>User Phone</th>
                        <td><?php echo htmlspecialchars($order['user_phone']); ?></td>

                    </tr>
                    <tr>
                        <th>User City</th>
                        <td><?php echo htmlspecialchars($order['user_city']); ?></td>
                    </tr>
                    <tr>
                        <th>User address </th>
                        <td><?php echo htmlspecialchars($order['user_address']); ?></td>
                    </tr>

                    
                </table>
                <!-- Thêm phần hiển thị chi tiết đơn hàng -->
                <section id="orders" class="orders container my-5 py-3">
                    <div class="container mt-5">
                        <h2 class="font-weight-bold text-center">Order Details</h2>
                        <hr class="mx-auto">
                    </div>

                    <table class="mt-5 pt-5 mx-auto">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Quantity</th>
                        </tr>

                        <?php if (!empty($order_items)) { ?>
                            <?php foreach ($order_items as $row) { ?>
                                <tr>
                                    <td>
                                        <div class="product-info">
                                        <a href="single_product.php?product_id=<?php echo htmlspecialchars($row['product_id']); ?>">
                                            <img src="../assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="width: 70px; height: 70px;" />
                                        </a>

                                            <div>
                                                <p class="mt-3"><?php echo htmlspecialchars($row['product_name']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>$<?php echo htmlspecialchars($row['product_price']); ?></span>
                                    </td>
                                    <td>
                                        <span><?php echo htmlspecialchars($row['size_name']); ?></span>
                                    </td>
                                    <td>
                                        <span><?php echo htmlspecialchars($row['product_quantity']); ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="text-center">No order items found.</td>
                            </tr>
                        <?php } ?>
                    </table>
                </section>

            </div> -->

            <!-- Optional: add more order details or related items -->
        </div>
    </div>
</div>


<footer class="footer"></footer>

<!-- Include necessary scripts -->
<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<!-- Add more script includes as needed -->
