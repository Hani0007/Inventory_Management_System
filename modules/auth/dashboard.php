<?php
include '../../config/db.php';
session_start();

if (!isset($_SESSION['Username'])) {
  echo "<p style='color:red;'>Username is not set</p>";
  exit; // important!
}

$username = $_SESSION['Username'];
$sql = $conn->prepare("SELECT COUNT(*)FROM product");
$sql->execute();
$sql->bind_result($totalproduct);
$sql->fetch();
$sql->close();

//Fetching User Count 
$sql = $conn->prepare("SELECT COUNT(*) FROM users");
$sql->execute();
$sql->bind_result($totalusers);
$sql->fetch();
$sql->close();

// Fetching Stock IN Count 
$sql = $conn->prepare("SELECT COUNT(*) FROM stocks WHERE type = 'IN'");
$sql->execute();
$sql->bind_result($totalstockin);
$sql->fetch();
$sql->close();

// Fetching Stock OUt Count 
$sql = $conn->prepare("SELECT COUNT(*) FROM stocks WHERE type = 'OUT'");
$sql->execute();
$sql->bind_result($totalstockouts);
$sql->fetch();
$sql->close();

// Total Revenue
$sql = $conn->prepare("SELECT  SUM(Selling_price*quantity) FROM stocks WHERE type = 'OUT'");
$sql->execute();
$sql->bind_result($totalRevenue);
$sql->fetch();
$sql->close();

// Total Cost
$sql = $conn->prepare("SELECT SUM(Cost_price*quantity) FROM stocks WHERE type = 'OUT'");
$sql->execute();
$sql->bind_result($totalCost);
$sql->fetch();
$sql->close();

//profit or loss calculation
$sql = $conn->prepare("SELECT SUM(Selling_price*quantity) - SUM(Cost_price*quantity) FROM stocks WHERE type = 'OUT'");
$sql->execute();
$sql->bind_result($profitOrLoss);
$sql->fetch();
$sql->close();
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory Dashboard</title>
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
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
          <div class="container-fluid">
            <h2 class="mb-0">Dashboard</h2>
            <span class="admin ms-auto">Welcome,<?php echo htmlspecialchars($username); ?></span>
            <a href="logout.php" class="btn btn-warning text-white">Logout</a>
          </div>
        </nav>

        <!-- Stats -->
        <div class="row g-3">
          <div class="col-md-3">
            <div class="card text-white bg-primary p-3">
              <h5>Total Products</h5>
              <h2><?php echo $totalproduct; ?></h2>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-success p-3">
              <h5>Stock In</h5>
              <h2><?php echo htmlspecialchars($totalstockin) ?></h2>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-danger p-3">
              <h5>Stock Out</h5>
              <h2><?php echo htmlspecialchars($totalstockouts) ?></h2>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-white bg-warning p-3">
              <h5>Users</h5>
              <h2><?php echo $totalusers ?></h2>
            </div>
          </div>
        </div>

        <!-- Margins Section -->
        <div class="row mt-4">
          <div class="col-md-8">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="card text-white bg-info p-3">
                  <h5>Total Revenue</h5>
                  <h2>$<?php echo htmlspecialchars($totalRevenue) ?></h2>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card text-white bg-secondary p-3">
                  <h5>Total Cost</h5>
                  <h2>$<?php echo htmlspecialchars($totalCost) ?></h2>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card text-white bg-dark p-3">
                  <h5>Profit / Loss</h5>
                  <h2>$ <?php echo htmlspecialchars($profitOrLoss)?> <small>(Profit)</small></h2>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Margins Section -->

          <!-- Shortcuts (unchanged) -->
          <div class="col-md-4">
            <div class="card p-3">
              <h5>Shortcuts</h5>
              <a href="../products/add_product.php" class="btn btn-outline-primary mb-2 w-100">Add Product</a>
              <a href="../stocks/add_stock.php" class="btn btn-outline-success mb-2 w-100">Stock In</a>
              <a href="#" class="btn btn-outline-danger mb-2 w-100">Stock Out</a>
            </div>
          </div>
        </div>

    </div>
    </main>
  </div>
  </div>
</body>

</html>