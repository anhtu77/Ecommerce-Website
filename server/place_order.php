<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

include('connection.php');

if(!isset($_SESSION['logged_in'])) {
    header('location: ../checkout.php?message=Vui lòng đăng nhập để đặt hàng.');
    exit;

    // neu nguoi dung da dang nhap
}else{

if(isset($_POST['place_order'])){

    //get user info an store it in database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "not paid";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                    VALUES (?,?,?,?,?,?,?); ");
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $stmt_status = $stmt->execute();
    if(!$stmt_status){
        header('location: index.php');
        exit;
    }

    //issue new order store order infor in database
    $order_id = $stmt->insert_id;




    //get products form cart
    foreach($_SESSION['cart'] as $key => $value) {
        $product = $_SESSION['cart'] [$key];
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];


        //store each single item in order_items database

        $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
                            VALUE (?,?,?,?,?,?,?,?)");

        $stmt1->bind_param('iissiiis',$order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);

        $stmt1->execute();

    }

    
    // remove everything from cart

    //unset($_SESSION['cart']);

    $_SESSION['order_id'] = $order_id;
   // inform user whether everthing is fine or there is a problem
   header('location: ../payment.php?order_status=Order placed successfull');


}





}
?>