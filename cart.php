<?php 
include('layouts/header.php');

if(!isset($_SESSION['logged_in'])){
  header('location: login.php');
  exit;
}

if(isset($_POST['add_to_cart'])){

  $product_id = intval($_POST['product_id']);
  $product_quantity = intval($_POST['product_quantity']);

  // Nếu giỏ hàng đã tồn tại
  if(isset($_SESSION['cart'])){

    $products_array_ids = array_column($_SESSION['cart'], "product_id");
    if(!in_array($product_id, $products_array_ids)){

      $product_array = array(
        'product_id' => $product_id,
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => $product_quantity
      );
  
      $_SESSION['cart'][$product_id] = $product_array;

    } else {
      echo '<script>alert("Product is already in the cart");</script>';
    }

  } else { // Nếu đây là sản phẩm đầu tiên
    $product_array = array(
      'product_id' => $product_id,
      'product_name' => $_POST['product_name'],
      'product_price' => $_POST['product_price'],
      'product_image' => $_POST['product_image'],
      'product_quantity' => $product_quantity
    );

    $_SESSION['cart'][$product_id] = $product_array;
  }

  calculateTotalCart();
} 

// Xóa sản phẩm khỏi giỏ
else if(isset($_POST['remove_product'])){

  $product_id = intval($_POST['product_id']);
  unset($_SESSION['cart'][$product_id]);
  calculateTotalCart();

} 

// Cập nhật số lượng sản phẩm trong giỏ
else if(isset($_POST['edit_quantity'])){

  $product_id = intval($_POST['product_id']);
  $product_quantity = intval($_POST['product_quantity']);

  // Cập nhật số lượng sản phẩm
  if($product_quantity > 0) {
    $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
  }

  calculateTotalCart();
}

// Hàm tính tổng giỏ hàng
function calculateTotalCart(){
  $total_price = 0;
  $total_quantity = 0;

  if(isset($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $product) {
      $total_price += $product['product_price'] * $product['product_quantity'];
      $total_quantity += $product['product_quantity'];
    }
  }

  $_SESSION['total'] = $total_price;
  $_SESSION['quantity'] = $total_quantity;
}

?>

<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">Your Cart</h2>
        <hr>
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>

        <?php if(!empty($_SESSION['cart'])) { ?>
            <?php foreach($_SESSION['cart'] as $product) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $product['product_image']; ?>"/>
                            <div>
                                <p><?php echo $product['product_name']; ?></p>
                                <small><span>$</span><?php echo $product['product_price']; ?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>"/>
                                    <input type="submit" name="remove_product" class="remove-btn" value="Remove"/>
                                </form>
                            </div>
                        </div>
                    </td>

                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>"/>
                            <input type="hidden" name="size_name" value="<?php echo $size['product_id']; ?>"/>
                            <input type="number" name="product_quantity" value="<?php echo $product['product_quantity']; ?>" min="1" required/>
                            <input type="submit" class="edit-btn" value="Edit" name="edit_quantity"/>
                        </form>
                    </td>

                    <td>
                        <span>$</span>
                        <span class="product-price"><?php echo $product['product_quantity'] * $product['product_price'];?></span>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="3">Your cart is empty.</td></tr>
        <?php } ?>
    </table>

    <div class="cart-total">
        <table>
            <tr>
                <td>Total</td>
                <td>$ <?php echo $_SESSION['total'] ?? 0; ?></td>
            </tr>
        </table>
    </div>

    <div class="checkout-container">
        <form method="POST" action="checkout.php">
            <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout"/>
        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
