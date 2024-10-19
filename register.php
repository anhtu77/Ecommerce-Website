<?php

session_start();

include('server/connection.php');



      // neu nguoi dung da dang ki thanh cong, ho khong the vao trang dang ki 
if(isset($_SESSION['logged_in'])){
      header('location: account.php');
      exit;
}
    



if(isset($_POST['register'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];



  if($password !== $confirmPassword){
    header('location: register.php?error=password dont match');
  }
  else if(strlen($password) < 6){
    header('location: register.php?error=password must be at least 6 charachters ');
  }

else{
        $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
        $stmt1->bind_param('s',$email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();

        if($num_rows != 0) {
          header('location: register.php?error=user with this email already exists');
        }else{

          
              $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password)
              VALUES (?,?,?)");


              $stmt->bind_param('sss',$name, $email, md5($password));

              // neu tai khoan duoc tao thanh cong
              if($stmt->execute()){
                    $user_id = $stmt->insert_id;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['logged_in']  = true;
                    header('location: account.php?register_success=Bạn đã đăng kí thành công');

               // tai khoan khong duoc tao     
              }else{
                header('location: register.php?error=Bạn không thể tạo tài khoản này');
              }


        }

}
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>

     <!--Navbar-->
     <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
      <div class="container">
        <a href="index.php"><img class="logo" src="assets/imgs/logo.png"/></a>
        <a href="index.php"><h2 class="brand">TSport</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
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
              <a class="icon" href="cart.html"><i class="fas fa-cart-shopping"></i></a>
              <a class="icon" href="account.html"><i class="fas fa-user"></i></a>
            </li>

        
          </ul>

        </div>
      </div>
    </nav>



    <!-- Register -->
     <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-blod">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php">
              <p style="color: red"><?php if(isset($_GET['error'])) { echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="ConfirmPassword" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you have account? Login</a>
                </div>
            </form>
        </div>
     </section>





         <!--Footer-->
    <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <img class="logo" src="assets/imgs/logo.png"/>
            <p class="pt-3">We provide the best products for the most affordable prices</p>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Featured</h5>
            <ul class="text-uppercase">
              <li><a href="#">men</a></li>
              <li><a href="#">women</a></li>
              <li><a href="#">boys</a></li>
              <li><a href="#">girls</a></li>
              <li><a href="#">new arrivals</a></li>
              <li><a href="#">clothes</a></li>
            </ul>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Contact Us</h5>
            <div>
              <h6 class="text-uppercase">Address</h6>
              <p>1234 Street Name, City</p>
            </div>
            <div>
              <h6 class="text-uppercase">Phone</h6>
              <p>123 456 7890</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>info@gmail.com</p>
            </div>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Instagram</h5>
            <div class="row">
              <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
              <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
              <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
              <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
              <img src="assets/imgs/footer1.jpeg" class="img-fluid w-25 h-100 m-2">
            </div>
          </div>
  
        </div>
  
  
        <div class="copyright mt-5">
          <div class="row container mx-auto">
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <img src="assets/imgs/pay.png" >
            </div>
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
              <p>eCommerce @ 2025 All Right Reserved</p>
            </div>
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
  
      </footer>
  





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>