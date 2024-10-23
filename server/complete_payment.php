<?php 

session_start();

include('connection.php');


if(isset($_GET['transaction_id']) && isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];
    $order_status = "paid";
    $transaction_id = $_GET['transaction_id'];
    $user_id = $_SESSION['user_id'];

    //change order_status to paid
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id = ?");
    $stmt->bind_param('si',$order_status,$order_id);

    $stmt->execute();
    
    //store payment info
    $stmt1 = $conn->prepare("INSERT INTO payments (order_id, order_status, user_id, transaction_id)
                            VALUES (?,?,?); ");
    $stmt->bind_param('iii', $order_id, $order_status, $user_id, $transaction_id);

    $stmt1->execute();

    //go to user account
    header("location: account.php?payment_massage=Paid successfully, thanks for your shopping with us.");

} else {
    header("location: index.php");
    exit;
}









?>