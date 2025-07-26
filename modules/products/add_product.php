<?php
$product_name = $category = $brand = $costprice = $selling_price =  $stock = '';
$productNameError = $categoryError = $brandError = $costpriceError =$selling_priceError =  $stockError = '';
$successMessage = '';

include '../../config/db.php';
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

    $username = $_SESSION['Username'];
}

//fetch categories first 
// $categories = [];
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
if ($result) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p style = 'color:red';>Error Fetching</p>";
}
//fetch brands 
// $brands = [];
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
if ($result) {
    $brands = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p style = 'color:red';>Error Fetching</p>";
}

//post handlers
if (isset($_POST['submit'])) {
    $product_name = $_POST['productName'];
    $category = $_POST['productCategory'];
    $brand = $_POST['productBrand'];
    $costprice = $_POST['productPrice'];
    $selling_price = $_POST['productSellingPrice'];
    $stock = $_POST['productStock'];

    // Validate inputs
    if (empty($product_name)) $productNameError = 'Product Name is required';
    if (empty($category)) $categoryError = 'Category is required';
    if (empty($brand)) $brandError = 'Brand is required';
    if (empty($costprice)) $costpriceError = 'Cost Price is required';
    if (empty($selling_price)) $selling_priceError = 'Selling Price is required';
    if (empty($stock)) $stockError = 'Stock is required';

    // Insert only if no errors
    if (!$productNameError && !$categoryError && !$brandError && !$costpriceError &&!$selling_priceError &&!$stockError) {
        $stmt = $conn->prepare("INSERT INTO product (Product_Name, Category_id, Brand_id,  Cost_price,Selling_price, Stock_Quantity, Created_Date, Created_Time) VALUES (?, ?, ?, ?, ?,?, NOW(), NOW())");
        $stmt->bind_param('siiiii', $product_name, $category, $brand, $costprice,$selling_price, $stock);

        if ($stmt->execute()) {
            $successMessage = "<p class='text-success text-center'>Product added successfully!</p>";
        } else {
            $successMessage = "<p class='text-danger text-center'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product - Inventory</title>
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
                <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
                    <div class="container-fluid">
                        <h3 class="mb-4">Add New Product</h3>
                        <span class="admin ms-auto">Welcome,<?php echo htmlspecialchars($username); ?></span>
                        <a href="logout.php" class="btn btn-warning text-white">Logout</a>
                    </div>
                </nav>

                <div class="container mt-5">
                    <?= $successMessage ?>
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="productName" value="<?= htmlspecialchars($product_name) ?>" placeholder="Enter product name">
                                <div class="text-danger"><?= $productNameError ?></div>
                            </div>

                            <div class="col-md-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" name="productCategory">
                                    <option disabled <?= $category == '' ? 'selected' : '' ?>></option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($category == $cat['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <div class="text-danger"><?= $categoryError ?></div>
                            </div>

                            <div class="col-md-3">
                                <label for="productBrand" class="form-label">Brand</label>
                                <select class="form-select" name="productBrand">
                                    <option disabled <?= $brand == '' ? 'selected' : '' ?>>Select brand</option>
                                    <?php foreach ($brands as $b): ?>
                                        <option value="<?= $b['id'] ?>" <?= $brand == ($b['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($b['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="text-danger"><?= $brandError ?></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productPrice" class="form-label"> Cost Price</label>
                                <input type="number" class="form-control" name="productPrice" value="<?= htmlspecialchars($costprice) ?>" placeholder="Enter price">
                                <div class="text-danger"><?= $costpriceError ?></div>
                            </div>
                           
                            <div class="col-md-6">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" name="productStock" value="<?= htmlspecialchars($stock) ?>" placeholder="Enter stock">
                                <div class="text-danger"><?= $stockError ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productSellingPrice" class="form-label">Selling Price</label>
                                <input type="number" class="form-control" name="productSellingPrice" value="<?= htmlspecialchars($selling_price) ?>" placeholder="Enter selling price">
                                <div class="text-danger"><?= $selling_priceError ?></div>
                            </div>
                        

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
</body>

</html>