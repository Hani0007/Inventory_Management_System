<?php
$product_name = $category = $brand = $price = $stock = '';
$productNameError = $categoryError = $brandError = $priceError = $stockError = '';
$successMessage = '';

include '../../config/db.php';
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

    $username = $_SESSION['Username'];
}
$product_id = $_GET['id'];

//fetch categories first 
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
if ($result) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p style = 'color:red';>Error Fetching</p>";
}
//fetch brands 
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
if ($result) {
    $brands = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p style = 'color:red';>Error Fetching</p>";
}

//fetch existing records 
$sql = $conn->prepare("SELECT * FROM product WHERE Id = ?");
$sql->bind_param('i', $product_id);
$sql->execute();
$result  = $sql->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['Id'];
        $product_name = $row['Product_Name'];
        $category = $row['Category_id'];
        $brand = $row['Brand_id'];
        $price = $row['Price'];
        $stock = $row['Stock_Quantity'];
    }
    if (!$product_id) {
        echo "<p style = 'color:red'>Product Id Not Found</p>";
    }
}

if (isset($_POST['update'])) {
    $product_name = $_POST['productName'];
    $category = $_POST['productCategory'];
    $brand = $_POST['productBrand'];
    $price = $_POST['productPrice'];
    $stock = $_POST['productStock'];

    // Validate inputs
    if (empty($product_name)) $productNameError = 'Product Name is required';
    if (empty($category)) $categoryError = 'Category is required';
    if (empty($brand)) $brandError = 'Brand is required';
    if (empty($price)) $priceError = 'Price is required';
    if (empty($stock)) $stockError = 'Stock is required';

    /// Insert only if no errors
    if (!$productNameError && !$categoryError && !$brandError && !$priceError && !$stockError) {
        $stmt = $conn->prepare("UPDATE product SET Product_Name = ?,Category_id = ?,Brand_id = ?,Price = ?,Stock_Quantity = ? WHERE id = ?");
        $stmt->bind_param('siiiii', $product_name, $category, $brand, $price, $stock,$product_id);

        if ($stmt->execute()) {
            // $successMessage = "<p class='text-success text-center'>Product Updated successfully!</p>";
            header('location:product_main.php');
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
    <title>Edit Product - Inventory</title>
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
                    <a href="">Products</a>
                    <a href="../categories/add_cat.php">Categories</a>
                    <a href="#">Stock In/Out</a>
                    <a href="../brands/add_brand.php">Brands</a>
                    <a href="#">Users</a>
                    <a href="#">Settings</a>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
                    <div class="container-fluid">
                        <h3 class="mb-4">Update Product</h3>
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
                                    <option disabled <?= $brand == '' ? 'selected' : '' ?>></option>
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
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="number" class="form-control" name="productPrice" value="<?= htmlspecialchars($price) ?>" placeholder="Enter price">
                                <div class="text-danger"><?= $priceError ?></div>
                            </div>

                            <div class="col-md-6">
                                <label for="productStock" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" name="productStock" value="<?= htmlspecialchars($stock) ?>" placeholder="Enter stock">
                                <div class="text-danger"><?= $stockError ?></div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="update" class="btn btn-warning text-white">Update Product</button>
                        </div>
                    </form>
                </div>
</body>

</html>