<?php include('header.php'); ?>

<?php 

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order = $stmt->get_result();


} else if(isset($_POST['edit_order'])){

    $order_status = $_POST['order_status'];
    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param('si', $order_status, $order_id);
    
    if ($stmt->execute()) {
      echo "<script>
              alert('Order has been updated successfully.');
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

}else{
    header('location: index.php');
    exit;
}

?>

<div class="container">
  <div class="page-inner">
      <h3 class="fw-bold mb-3">Dashboard</h3>
      <h6 class="op-7 mb-2">Edit Order</h6>
      
      <div class="table-responsive">
          <div class="mx-auto container">
              <form id="edit-order-form" method="POST" action="edit_order.php">

              <?php foreach($order as $r ) { ?>
                 <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'] ;}?></p>
                 <div class="form-group my-3">
                    <label>Order Id</label>
                    <p class="my-4"><?php echo $r['order_id']; ?></p>
                 </div>
                 <div class="form-group mt-3">
                    <label>Order Price</label>
                    <p class="my-4"><?php echo $r['order_cost']; ?></p>
                 </div>

                 <input type="hidden" name="order_id" value="<?php echo $r['order_id']; ?>">

                 <div class="form-group my-3">
                    <label>Order Status</label>
                    <?php if($r['order_status'] == 'Delivered') { ?>
                        <p class="my-4">Delivered</p>
                        <p style="color: red;">This order has been delivered and cannot be edited.</p>
                    <?php } else { ?>
                        <select class="form-select" required name="order_status">                     
                            <option value="not paid" <?php echo ($r['order_status'] == 'not paid') ? 'selected' : '';?>>Not Paid</option>
                            <option value="paid" <?php echo ($r['order_status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                            <option value="shipped"<?php echo ($r['order_status'] == 'shipped') ? 'selected' : '';?>>Shipped</option>
                            <option value="Delivered" <?php echo ($r['order_status'] == 'Delivered') ? 'selected' :'';?>>Delivered</option>
                        </select>
                    <?php } ?>
                 </div>

                 <div class="form-group my-3">
                    <label>Order Date</label>
                    <p class="my-4"><?php echo $r['order_date']; ?></p>
                 </div>

                 <?php if($r['order_status'] != 'Delivered') { ?>
                 <div class="form-group mt-3">
                    <input type="submit" class="btn btn-primary" name="edit_order" value="Edit">
                 </div>
                 <?php } ?>
                    <?php } ?>
              </form>
          </div>
      </div>
  </div>
</div>



        <footer class="footer">
         
        </footer>


      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
  </body>
</html>
