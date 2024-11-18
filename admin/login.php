<?php 
include('..layouts/header.php');
?>

<?php
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
  header('location: account.php'); // Nếu người dùng đã đăng nhập, chuyển hướng tới trang tài khoản
  exit;
}

if(isset($_POST['login_btn'])) {

  $email = $_POST['email'];
  $password = md5($_POST['password']); // Mã hóa mật khẩu (sử dụng MD5, tuy nhiên nên xem xét sử dụng các phương pháp mã hóa an toàn hơn)

  // Truy vấn để lấy thông tin người dùng và vai trò
  $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password, role FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");

  $stmt->bind_param('ss', $email, $password);

  if($stmt->execute()){
      $stmt->bind_result($user_id, $user_name, $user_email, $user_password, $role);
      $stmt->store_result();
      if($stmt->num_rows() == 1) {
        $stmt->fetch();

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['role'] = $role; // Lưu vai trò người dùng
        $_SESSION['logged_in'] = true;

        // Kiểm tra vai trò và chuyển hướng
        if ($role == 'admin') {
          header('location: admin/admin_dashboard.php'); // Trang dành cho admin
        } else {
          header('location: index.php'); // Trang dành cho khách hàng
        }
        
      } else {
        header('location: login.php?error=Đăng nhập thất bại');
      }

  } else {
    header('location: login.php?error=Hệ thống đăng bận');
  }

}
?>

<!-- login form -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-blod">Login</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="login-form" method="POST" action="login.php">
      <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p>
      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required/>
      </div>
      <div class="form-group">
        <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
      </div>
      <div class="form-group">
        <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
      </div>
    </form>
  </div>
</section>

<?php 
include('..layouts/footer.php');
?>
