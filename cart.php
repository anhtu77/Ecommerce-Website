<?php  
// session_start();
include('layouts/header.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart']) && isset($_POST['product_id']) && isset($_POST['product_quantity']) && isset($_POST['size_name'])) {
    $product_id = intval($_POST['product_id']);
    $product_quantity = intval($_POST['product_quantity']);
    $size_name = filter_var($_POST['size_name'], FILTER_SANITIZE_STRING); // Xử lý kích thước an toàn
    $product_size_id = $_POST['product_size_id'];

    // Kiểm tra xem có chọn size hay không
    if (empty($size_name)) {
        echo "<div class='alert alert-danger'>Please select a size for the product.</div>";
        exit;
    }

    // Tạo khóa duy nhất cho sản phẩm theo product_id và size_name
    $product_key = $product_id . "_" . $size_name;

    // Nếu giỏ hàng đã tồn tại
    if (isset($_SESSION['cart'])) {
        if (!isset($_SESSION['cart'][$product_key])) {
            // Thêm sản phẩm mới vào giỏ
            $product_array = array(
                'product_id' => $product_id,
                'product_name' => htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8'),
                'product_price' => htmlspecialchars($_POST['product_price'], ENT_QUOTES, 'UTF-8'),
                'product_image' => $_POST['product_image'],
                'product_quantity' => $product_quantity,
                'size_name' => $size_name,
                'product_size_id' => $product_size_id
            );
            $_SESSION['cart'][$product_key] = $product_array;
            echo "<div class='alert alert-success'>Product " . htmlspecialchars($product_array['product_name']) . " (Size: " . htmlspecialchars($size_name) . ") added to cart successfully!</div>";
        } else {
            // Nếu sản phẩm đã có trong giỏ hàng, cộng thêm số lượng
            $_SESSION['cart'][$product_key]['product_quantity'] += $product_quantity; // Cộng thêm số lượng
            echo "<div class='alert alert-success'>Product quantity updated in the cart.</div>";
        }
    } else { 
        // Nếu đây là sản phẩm đầu tiên
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => htmlspecialchars($_POST['product_name'], ENT_QUOTES, 'UTF-8'),
            'product_price' => htmlspecialchars($_POST['product_price'], ENT_QUOTES, 'UTF-8'),
            'product_image' => $_POST['product_image'],
            'product_quantity' => $product_quantity,
            'size_name' => $size_name,
            'product_size_id' => $product_size_id
        );
        $_SESSION['cart'][$product_key] = $product_array;
        echo "<div class='alert alert-success'>Product " . htmlspecialchars($product_array['product_name']) . " (Size: " . htmlspecialchars($size_name) . ") added to cart successfully!</div>";
    }

    calculateTotalCart();
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_product']) && isset($_POST['product_key'])) {
    $product_key = $_POST['product_key']; // Dùng product_key để xác định sản phẩm cần xóa
    unset($_SESSION['cart'][$product_key]);
    calculateTotalCart();
}

// Cập nhật số lượng và size sản phẩm
if (isset($_POST['edit_quantity']) && isset($_POST['product_key']) && isset($_POST['product_quantity']) && isset($_POST['size_name'])) {
    $product_key = $_POST['product_key']; // Lấy product_key từ form
    $product_quantity = intval($_POST['product_quantity']);
    $size_name = filter_var($_POST['size_name'], FILTER_SANITIZE_STRING); // Xử lý kích thước an toàn

    // Kiểm tra số lượng hợp lệ
    if ($product_quantity > 0) {
        $_SESSION['cart'][$product_key]['product_quantity'] = $product_quantity; // Cập nhật số lượng
    }
    if (!empty($size_name) && $size_name !== $_SESSION['cart'][$product_key]['size_name']) {
        $_SESSION['cart'][$product_key]['size_name'] = $size_name; // Cập nhật kích thước nếu thay đổi
    }

    calculateTotalCart(); // Tính lại tổng giỏ hàng
}

// Hàm tính tổng giỏ hàng
function calculateTotalCart() {
    $total_price = 0;
    $total_quantity = 0;

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $price = isset($product['product_price']) ? $product['product_price'] : 0;
            $quantity = isset($product['product_quantity']) ? $product['product_quantity'] : 0;

            $total_price += $price * $quantity;
            $total_quantity += $quantity;
        }
    }

    // Nếu giỏ hàng trống, đảm bảo tổng = 0
    if ($total_price == 0) {
        $_SESSION['total'] = 0;
        $_SESSION['quantity'] = 0;
    } else {
        $_SESSION['total'] = $total_price;
        $_SESSION['quantity'] = $total_quantity;
    }
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

        <?php if (!empty($_SESSION['cart'])) { ?>
            <?php foreach ($_SESSION['cart'] as $product_key => $product) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/images/<?php echo htmlspecialchars($product['product_image']); ?>"/>
                            <div>
                                <p><?php echo htmlspecialchars($product['product_name']); ?></p>
                                <small><span>$</span><?php echo htmlspecialchars($product['product_price']); ?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_key" value="<?php echo $product_key; ?>"/>
                                    <input type="submit" name="remove_product" class="remove-btn" value="Remove"/>
                                </form>
                            </div>
                        </div>
                    </td>

                    <td>
                        <!-- <form method="POST" action="cart.php">
                            <input type="hidden" name="product_key" value="<?php echo $product_key; ?>"/> -->
                            <input type="text" name="size_name" value="<?php echo htmlspecialchars($product['size_name']); ?>" required/> 
                            <!-- <input type="submit" class="edit-btn" value="Edit" name="edit_quantity"/> -->
                        </form>
                    </td>

                    <td>
                        <!-- <form method="POST" action="cart.php">
                            <input type="hidden" name="product_key" value="<?php echo $product_key; ?>"/> -->
                            <input type="number" name="product_quantity" value="<?php echo $product['product_quantity']; ?>" min="1" required/>
                            <!-- <input type="submit" class="edit-btn" value="Edit" name="edit_quantity"/>
                        </form> -->
                    </td>

                    <td>
                        <span>$</span>
                        <span class="product-price"><?php echo $product['product_quantity'] * $product['product_price']; ?></span>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4" style="text-align: center; font-size: 1.2em; color: gray;">Your cart is empty.</td>
            </tr>
        <?php } ?>
    </table>

    <div class="cart-total">
        <table>
            <tr>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_key" value="<?php echo $product_key; ?>"/>
                            <input type="submit" 
                            class="edit-btn" value="Update Your Cart" name="edit_quantity"/>
                        </form>
            </tr>
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
