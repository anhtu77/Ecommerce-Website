<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

include('connection.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['logged_in'])) {
    header('location: ../checkout.php?message=Vui lòng đăng nhập để đặt hàng.');
    exit;
}

if (isset($_POST['place_order'])) {
    // Lấy thông tin người dùng từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total']; // Tổng tiền đơn hàng
    $order_status = "not paid"; // Trạng thái đơn hàng ban đầu
    $user_id = $_SESSION['user_id']; // ID người dùng
    $order_date = date('Y-m-d H:i:s'); // Thời gian đặt hàng

    // Kiểm tra dữ liệu đầu vào
    if (empty($name) || empty($email) || empty($phone) || empty($city) || empty($address)) {
        header('location: ../checkout.php?message=Vui lòng điền đầy đủ thông tin');
        exit;
    }

    // Thêm thông tin đơn hàng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                            VALUES (?,?,?,?,?,?,?)");
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
    $stmt_status = $stmt->execute();
    if (!$stmt_status) {
        die('Error executing query: ' . $stmt->error);
    }

    $order_id = $stmt->insert_id;

    // Lấy thông tin sản phẩm từ giỏ hàng
    foreach ($_SESSION['cart'] as $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];
        $product_size_id = $product['product_size_id']; // Lấy kích cỡ từ giỏ hàng
        //size
        $size_name = $product['size_name'];

        // Kiểm tra nếu size_id không tồn tại trong giỏ hàng
        if (!isset($product['product_size_id'])) {
            header('location: ../checkout.php?message=Vui lòng chọn kích cỡ cho sản phẩm: ' . $product_name);
            exit;
        }

        // Kiểm tra tồn kho trước khi thêm sản phẩm vào đơn hàng
        $stmt_check = $conn->prepare("SELECT stock FROM product_sizes WHERE product_id = ? AND product_size_id = ?");
        if ($stmt_check === false) {
            die('Error preparing statement for stock check: ' . $conn->error);
        }
        $stmt_check->bind_param('ii', $product_id, $product_size_id);
        if (!$stmt_check->execute()) {
            die('Error executing stock check query: ' . $stmt_check->error);
        }
        $stmt_check->bind_result($available_stock);
        $stmt_check->fetch();
        $stmt_check->free_result(); // Free the result set after fetching the data

        // Kiểm tra nếu tồn kho không đủ
        if ($product_quantity > $available_stock) {
            header('location: ../checkout.php?message=Không đủ hàng cho sản phẩm: ' . $product_name);
            exit;
        }

        // Thêm sản phẩm vào bảng order_items
        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date, size_name)
                                 VALUES (?,?,?,?,?,?,?,?,?)");
        if ($stmt1 === false) {
            die('Error preparing statement for order items: ' . $conn->error);
        }
        $stmt1->bind_param('iissiisss', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date, $size_name);
        if (!$stmt1->execute()) {
            die('Error executing query for order items: ' . $stmt1->error);
        }

        // Cập nhật tồn kho sau khi thêm sản phẩm vào đơn hàng
        $stmt2 = $conn->prepare("UPDATE product_sizes SET stock = stock - ? WHERE product_id = ? AND product_size_id = ?");
        if ($stmt2 === false) {
            die('Error preparing statement for stock update: ' . $conn->error);
        }
        $stmt2->bind_param('iii', $product_quantity, $product_id, $product_size_id);
        if (!$stmt2->execute()) {
            die('Error executing stock update query: ' . $stmt2->error);
        }

        // Cập nhật tổng số lượng sản phẩm trong bảng products
        $stmt3 = $conn->prepare("UPDATE products SET product_stock = product_stock - ? WHERE product_id = ?");
        if ($stmt3 === false) {
            die('Error preparing statement for product stock update: ' . $conn->error);
        }
        $stmt3->bind_param('ii', $product_quantity, $product_id);
        if (!$stmt3->execute()) {
            die('Error executing product stock update query: ' . $stmt3->error);
        }
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    // Lưu ID đơn hàng vào session và chuyển hướng
    $_SESSION['order_id'] = $order_id;
    header('location: ../payment.php?order_status=Order placed successfully');
}
?>
