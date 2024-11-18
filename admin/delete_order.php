<?php 

    session_start(); 

    include('../server/connection.php');

?>


<?php 
        if(!isset($_SESSION['admin_logged_in'])){
            header('location:login.php');
            exit;
        }
        
        if(isset($_GET['order_id'])) {
                $order_id = $_GET['order_id'];
                $stmt = $conn->prepare("DELETE FROM orders WHERE order_id=? ");
                $stmt->bind_param('i',$order_id);
                if ($stmt->execute()) {
                    echo "<script>
                            alert('Order has been deleted successfully.');
                            window.location.href = 'index.php';
                          </script>";
                    exit;
                  } else {
                    echo "<script>
                            alert('Error occurred, try again.');
                            window.location.href = 'index.php';
                          </script>";
                    exit;
                  }
        }



?>
