<?php include('header.php'); ?>



<?php 


 
  if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
  
    $page_no = $_GET['page_no'];
  }else{
   
    $page_no = 1;
  }

  
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  $total_records_per_page = 10;

  $offset = ($page_no-1) * $total_records_per_page;

  $previous_page = $page_no - 1;

  $next_page = $page_no + 1;

  $adjacents ="2";

  $total_no_of_pages = ceil($total_records/$total_records_per_page);


  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page");
  $stmt2->execute();
  $products = $stmt2->get_result();
  



?>



        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>

                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Products</h6>
              </div>
              
            </div>
            <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr>
                        <th scope="col">Product Id</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Stock</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Category</th>
                        <th scope="col">Product Color</th>
                        <th scope="col">Edit Images</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($products as $product){ ?>
                      <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td>
                            <img src="<?php echo "../assets/images/". $product['product_image']; ?>" style="width: 70px; height:70px;"/>
                        </td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['product_stock']; ?></td>
                        <td><?php echo "$".$product['product_price']; ?></td>
                        <td><?php echo $product['product_category']; ?></td>
                        <td><?php echo $product['product_color']; ?></td>
                        <td><a class="btn btn-warning" href="<?php echo "edit_images.php?product_id=".$product['product_id']."&product_name=".$product['product_name'];?>">Edit</a></td>
                        <td><a class="btn btn-primary" href="edit_product.php?product_id=<?php echo $product['product_id'];?>">Edit</a></td>
                        <td><a class="btn btn-danger"  href="delete_product.php?product_id=<?php echo $product['product_id']; ?>">Delete</a></td>
                      </tr>

                      <?php } ?>
                    </tbody>

                  </table>
           

                    <nav aria-label="Page navigation example" class="mx-auto">
                          <ul class="pagination mt-5 mx-auto">
                      
                                  <li class="page-item <?php if($page_no <= 1) {echo 'disabled';} ?>">
                                      <a class="page-link" href="<?php if($page_no <= 1) {echo '#';} else {echo "?page_no=".($page_no-1);} ?>">Previous</a>
                                  </li>

                                  <li class="page-item <?php if($page_no == 1) {echo 'active';} ?>">
                                      <a class="page-link" href="?page_no=1">1</a>
                                  </li>
                                  <li class="page-item <?php if($page_no == 2) {echo 'active';} ?>">
                                      <a class="page-link" href="?page_no=2">2</a>
                                  </li>

                                  <?php if($page_no >= 3 && $page_no < $total_no_of_pages) { ?>
                                      <li class="page-item">
                                      </li>
                                      <li class="page-item <?php if($page_no == $page_no) {echo 'active';} ?>">
                                          <a class="page-link" href="<?php echo "?page_no=".$page_no; ?>"><?php echo $page_no; ?></a>
                                      </li>
                                  <?php } ?>



                                  <li class="page-item"><a class="page-link" href="#">...</a></li>
                                  <li class="page-item <?php if($page_no == $total_no_of_pages) {echo 'active';} ?>">
                                      <a class="page-link" href="?page_no=<?php echo $total_no_of_pages; ?>"><?php echo $total_no_of_pages; ?></a>
                                  </li>

                                  <li class="page-item <?php if($page_no >= $total_no_of_pages) {echo 'disabled';} ?>">
                                      <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else {echo "?page_no=".($page_no+1);} ?>">Next</a>
                                  </li>
                                  
                      <!-- Hiển thị trang cuối cùng -->
                      
                            </ul>

              
                    </nav>
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
