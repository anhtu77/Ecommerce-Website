<?php
session_start();

include('../server/connection.php');

if(isset($_SESSION['admin_logged_in'])){
  header('location: index.php');
  exit;
}

if(isset($_POST['login_btn'])) {


  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");

  $stmt->bind_param('ss',$email,$password);

  if($stmt->execute()){
      $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);
      $stmt->store_result();
      if($stmt->num_rows() == 1) {
        $stmt->fetch();

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_logged_in'] = true;

        header('location: index.php?login_success=Đăng nhập thành công');
        
        



        }else{
          header('location: login.php?error=Đăng nhập thất bại');
        }


  }else{
      header('location: login.php?error=Hệ thống đăng bận');
  }

}



?>












<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Nhập</title>
    <!-- Link đến Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/login.css" rel="stylesheet">
</head>

<section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-blod">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" enctype="multipart/form-data" method="POST" action="login.php">
              <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
                <div class="form-group mt-2">
                    <label>Email</label>
                    <input type="email" class="form-control" id="product-name" name="email" placeholder="Email" required/>
                </div>
                <div class="form-group mt-2">
                    <label>Password</label>
                    <input type="password" class="form-control" id="product-desc" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group mt-3">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>
                
            </form>
        </div>
     </section>

    <!-- Link đến Bootstrap JavaScript (tùy chọn) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
