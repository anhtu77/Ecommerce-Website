<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

include('connection.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if(!isset($_SESSION['logged_in'])) {
    header('location: ../checkout.php?message=Vui lòng đăng nhập để đặt hàng.');
    exit;
} else {

    // Kiểm tra xem người dùng có nhấn nút đặt hàng không
    if(isset($_POST['place_order'])) {

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
        if(empty($name) || empty($email) || empty($phone) || empty($city) || empty($address)) {
            header('location: ../checkout.php?message=Vui lòng điền đầy đủ thông tin');
            exit;
        }

        // Thêm thông tin đơn hàng vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                                VALUES (?,?,?,?,?,?,?); ");
        
        // Kiểm tra nếu $stmt không phải là đối tượng
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

        // Kiểm tra việc thực thi truy vấn
        $stmt_status = $stmt->execute();
        if(!$stmt_status) {
            die('Error executing query: ' . $stmt->error); // Hiển thị lỗi nếu không thực thi được
        }

        // Lấy ID của đơn hàng vừa tạo
        $order_id = $stmt->insert_id;

        // Lấy thông tin sản phẩm từ giỏ hàng
        foreach($_SESSION['cart'] as $key => $value) {
            $product = $_SESSION['cart'][$key];
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];

            // Thêm từng sản phẩm vào bảng order_items
            $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
                                    VALUES (?,?,?,?,?,?,?,?)");
            
            // Kiểm tra nếu $stmt1 không phải là đối tượng
            if ($stmt1 === false) {
                die('Error preparing statement for order items: ' . $conn->error);
            }

            $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
            $stmt1->execute();

            // Cập nhật số lượng sản phẩm trong kho
            $stmt2 = $conn->prepare("UPDATE products SET product_stock = product_stock - ? WHERE product_id = ?");
            if ($stmt2 === false) {
                die('Error preparing statement for stock update: ' . $conn->error);
            }
            $stmt2->bind_param('ii', $product_quantity, $product_id);
            $stmt2->execute();
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);

        // Lưu ID đơn hàng vào session và chuyển hướng đến trang thanh toán
        $_SESSION['order_id'] = $order_id;
        header('location: ../payment.php?order_status=Order placed successfully');
    }
}
?>
