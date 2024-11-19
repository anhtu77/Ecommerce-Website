<?php include('header.php'); ?>

<div class="container">
  <div class="page-inner">
      <h3 class="fw-bold mb-3">Dashboard</h3>
      <h6 class="op-7 mb-2">Add Category</h6>
      
      <div class="table-responsive">
          <div class="mx-auto container">
              <form id="create-form" method="POST" action="create_category.php">
                <p style="color: red;"> 
                  <?php 
                  if(isset($_GET['error'])) { 
                      echo $_GET['error']; 
                  } 
                  ?>
                </p>

                <div class="form-group mt-2">
                    <label>Category Name</label>
                    <input type="text" class="form-control" id="category-name" name="category_name" placeholder="Category Name" required>
                </div>

                <div class="form-group mt-2">
                    <input type="submit" class="btn btn-primary" name="create_category" value="Create">
                </div>
              </form>
          </div>
      </div>
  </div>
</div>

<footer class="footer">
  <!-- Footer content -->
</footer>

<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<script>
  // Custom scripts here
</script>
</body>
</html>
