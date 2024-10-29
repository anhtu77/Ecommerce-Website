<?php 

    session_start(); 

    include('../server/connection.php');

?>


<?php 
        if(!isset($_SESSION['admin_logged_in'])){
            header('location:login.php');
            exit;
        }
        
        if(isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                $stmt = $conn->prepare("DELETE FROM products WHERE product_id=? ");
                $stmt->bind_param('i',$product_id);
                if ($stmt->execute()) {
                    echo "<script>
                            alert('Product has been deleted successfully.');
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
        }



?>
