<?php

session_start();


if(!empty($_SESSION['cart'])){




}else{
  
  header('location: index.php');



}





?>





<?php 
include('layouts/header.php');

?>




    <!-- checkout -->
     
    <!-- Register -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-blod">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                <p class="text-center" style="color:red">
                    <?php if(isset($_GET['message'])) {echo $_GET['message'] ;} ?>
                    <?php if(isset($_GET['message'])) { ?>
                        
                        <a class="btn btn-primary" href="login.php">Login</a>

                        <?php }?>
                   
                </p>
                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Vui lòng nhập đúng định dạng email:"/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required
                    pattern="^0\d{9}$" title="Số điện thoại phải bắt đầu bằng số 0 và gồm 10 chữ số"/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required/>
                </div>
                <div class="form-group checkout-large-element">
                    <label>Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required/>
                </div>
                <div class="form-group checkout-btn-container">
                    <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
                </div>
            </form>
        </div>
     </section>
     <script>
// JavaScript kiểm tra form trước khi submit
document.getElementById("checkout-form").addEventListener("submit", function(event) {
    var phone = document.getElementById("checkout-phone").value;
    var email = document.getElementById("checkout-email").value;

    // Kiểm tra email có đúng định dạng hay không
    var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    if (!emailPattern.test(email)) {
        event.preventDefault(); // Ngăn chặn submit form nếu không hợp lệ
        alert("Vui lòng nhập email đúng định dạng (ví dụ: abc@example.com).");
    }

    // Kiểm tra số điện thoại có đúng định dạng không (đã có pattern trong HTML)
    if (!this.checkValidity()) {
        event.preventDefault();
        alert("Vui lòng kiểm tra lại thông tin! Đảm bảo số điện thoại và email đúng định dạng.");
    }
});
</script>


    














<?php 
include('layouts/footer.php');
?>

