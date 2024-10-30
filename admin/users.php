<?php include('header.php'); ?>

<?php 
// Kiểm tra trang hiện tại
if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

// Tổng số bản ghi và thiết lập phân trang
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM users");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

$total_records_per_page = 10;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$total_no_of_pages = ceil($total_records/$total_records_per_page);

// Lấy dữ liệu user từ cơ sở dữ liệu
$stmt2 = $conn->prepare("SELECT * FROM users LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$users = $stmt2->get_result();
?>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Users</h6>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">User Name</th>
            <th scope="col">User Email</th>
            <th scope="col">User Password</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $user){ ?>
          <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['user_name']; ?></td>
            <td><?php echo $user['user_email']; ?></td>
            <td><?php echo $user['user_password']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

      <nav aria-label="Page navigation example" class="mx-auto">
        <ul class="pagination mt-5 mx-auto">
          <li class="page-item <?php if($page_no <= 1) {echo 'disabled';} ?>">
            <a class="page-link" href="<?php if($page_no <= 1) {echo '#';} else {echo "?page_no=".($page_no-1);} ?>">Previous</a>
          </li>
          <?php for($i = 1; $i <= $total_no_of_pages; $i++) { ?>
          <li class="page-item <?php if($page_no == $i) {echo 'active';} ?>">
            <a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
          <?php } ?>
          <li class="page-item <?php if($page_no >= $total_no_of_pages) {echo 'disabled';} ?>">
            <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else {echo "?page_no=".($page_no+1);} ?>">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<footer class="footer">
  <!-- Footer content -->
</footer>

<!-- JavaScript files -->
<script src="assets/js/core/jquery-3.7.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
</body>
</html>
