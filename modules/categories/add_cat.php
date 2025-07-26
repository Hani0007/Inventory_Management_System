<?php
session_start();
include '../../config/db.php';
$category = '';
$categoryerror = '';

if (!isset($_SESSION['Username'])) {
  echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

  $username = $_SESSION['Username'];
}

if (isset($_POST['add_cat'])) {
  $category = $_POST['category_name'];
}
if (empty($category)) {
  $categoryerror = 'Category is Required';
}
//if no validation occur
if (!$categoryerror) {
  $sql = $conn->prepare("INSERT INTO categories(name)VALUES(?)");
  $sql->bind_param('s', $category);
  $sql->execute();
  echo "<p style='background: linear-gradient(to right, #d4edda, #c3e6cb); color: #155724; font-weight: bold; text-align: center; padding: 10px; border-radius: 5px;'>Added Successfully</p>";
}








?>









<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Category</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      background-color: #343a40;
      padding-top: 20px;
    }

    .sidebar a {
      color: #fff;
      padding: 10px;
      display: block;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .navbar {
      background-color: #ffffff;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .admin {
      margin-right: 9px !important;
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="position-sticky">
          <h4 class="text-white text-center">StockFlow</h4>
          <a href="../auth/dashboard.php">Dashboard</a>
          <a href="../products/product_main.php">Products</a>
          <a href="../categories/add_cat.php">Categories</a>
          <a href="../stocks/stock_main.php">Stock In/Out</a>
          <a href="../brands/add_brand.php">Brands</a>
          <a href="../users/user_main.php">Users</a>

        </div>
      </nav>

      <!-- Main Content -->
      <main class="col-md-10 ms-sm-auto px-md-4">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
          <div class="container-fluid">
            <h3 class="mb-0">Add Category</h3>
            <div class="ms-auto d-flex align-items-center">
              <span class="me-3">Welcome, <?php echo htmlspecialchars($username); ?></span>
              <a href="logout.php" class="btn btn-warning text-white">Logout</a>
            </div>
          </div>
        </nav>

        <!-- Add Category Form -->
        <div class="card p-4 mb-4">
          <form method="POST" class="row g-3">
            <div class="col-md-8">
              <input type="text" name="category_name" class="form-control" placeholder="Enter new category" value="<?= htmlspecialchars($category) ?>">
              <div class="text-danger"><?= $categoryerror ?></div>
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100" name="add_cat">Add categories</button>
              </div>
              <div class="col-md-3">
                <a href="category_main.php" class="btn btn-secondary w-100">View Categories</a>
              </div>
            </div>
          </form>
        </div>

      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>