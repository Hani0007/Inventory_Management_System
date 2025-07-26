<?php
session_start();
include '../../config/db.php';
$brand = '';
$branderror = '';

if (!isset($_SESSION['Username'])) {
  echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

  $username = $_SESSION['Username'];
}

if (isset($_POST['add_brand'])) {
  $brand = $_POST['brand_name'];
}
if (empty($brand)) {
  $branderror = 'Brand is Required';
}
//if no validation occur
if (!$branderror) {
  $sql = $conn->prepare("INSERT INTO brands(name)VALUES(?)");
  $sql->bind_param('s', $brand);
  $sql->execute();
  echo "<p style='background: linear-gradient(to right, #d4edda, #c3e6cb); color: #155724; font-weight: bold; text-align: center; padding: 10px; border-radius: 5px;'>Added Successfully</p>";
}








?>









<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Brand - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            background-color: #f8f9fa;
        }
.sidebar {
    min-height: 100vh;
    background-color: #343a40;
    padding-top: 20px;
    overflow-y: auto; /* Allow vertical scrolling */
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

        .card {
            border: none;
            border-radius: 10px;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .admin {
            margin-right: 9px !important;
        }
    </style>

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
            <h3 class="mb-0">Add New Brand</h3>
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
              <input type="text" name="brand_name" class="form-control" placeholder="Enter new Brand" value="<?= htmlspecialchars($brand) ?>">
              <div class="text-danger"><?= $branderror ?></div>
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100" name="add_brand">Add Brands</button>
              </div>
              <div class="col-md-3">
                <a href="brands_main.php" class="btn btn-secondary w-100">View Brands</a>
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