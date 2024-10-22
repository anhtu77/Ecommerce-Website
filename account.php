<?php

session_start();
include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}


if (isset($_GET['logout'])) {
    if(isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}


if(isset($_POST['change_password'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    
  if($password !== $confirmPassword){
    header('location: account.php?error= Mật khẩu của bạn không chính xác');
  }
  else if(strlen($password) < 6){
    header('location: account.php?error= Mật khẩu phải có ít nhất 6 ký tự ');

    // no error
  }else{
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email = ?");
    $stmt->bind_param('ss',md5($password),$user_email);

    if($stmt->execute()){
        header('location: account.php?message= Mật khẩu được đổi thành công');
    }else{
        header('location: account.php?error= Mật khẩu được đổi không thành công');
    }
  }

}




// Nhận đơn hàng
if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ");

    $stmt->bind_param('i', $user_id);

    $stmt->execute();

    $orders = $stmt->get_result();

}


?>














<?php 
include('layouts/header.php');

?>


        <div class="container">
            <a href="index.php"><img class="logo" src="assets/imgs/logo.png"/></a>
         <a href="index.php"><h2 class="brand">TSport</h2></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop.html">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/contact.html">Contact Us</a>
              </li>

              <li class="nav-item">
                <a class="icon" href="cart.php"><i class="fas fa-cart-shopping"></i></a>
                <a class="icon" href="account.html"><i class="fas fa-user"></i></a>
              </li>

          
            </ul>

          </div>
        </div>
      </nav>


    <!-- Account -->
    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];} ?></p>
            <p class="text-center" style="color:green"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];} ?></p>
                <h3 class="font-weight-blod">Account info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name: <span><?php if(isset($_SESSION['user_name'])) {echo $_SESSION['user_name'];} ?></span></p>
                    <p>Email: <span><?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email'];} ?></span></p>
                    <p><a href="#orders" id="order-btn">Your orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <form id="account-form" method="POST" action="account.php">
                    <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
                    <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn" />
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Orders -->

    <section id="orders" class="orders container my-5 py-3">
        <div class="container mt-2">
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Order id</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order Date</th>
                <th>Order details</th>
            </tr>


            <?php while($row = $orders->fetch_assoc()){ ?>
                    <tr>
                        <td>
                            <!-- <div class="product-info">
                                <img src="assets/imgs/featured1.png" />
                                <div>
                                    <p class="mt-3"><?php echo $row['order_id']; ?></p>
                                </div>
                            </div> -->
                            <span><?php echo $row['order_id']; ?></span>
                        </td>

                        <td>
                            <span><?php echo $row['order_cost']; ?></span>
                        </td>

                        <td>
                            <span><?php echo $row['order_status']; ?></span>
                        </td>

                        <td>
                            <span><?php echo $row['order_date']; ?></span>
                        </td>

                        <td>
                            <form method="POST" action="order_details.php">
                                <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                                <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                                <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details">
                            </form>
                        </td>

                    </tr>

            <?php } ?>



        </table>


    </section>






<?php 
include('layouts/footer.php');
?>

