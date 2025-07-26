<?php
include '../../config/db.php';
session_start();

if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is Not set</p>";
    exit;
} else {
    $username = $_SESSION['Username'];
}

$sql = $conn->prepare("SELECT Id, Product_Name, Category_id, Brand_id, Cost_price, Selling_price, Stock_Quantity, Created_Date, Created_Time FROM product");
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stock Entries - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
        }

        .layout {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: white;
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

        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
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
    <div class="layout">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h4 class="text-white text-center">StockFlow</h4>
            <a href="../auth/dashboard.php">Dashboard</a>
            <a href="../products/product_main.php">Products</a>
            <a href="../categories/add_cat.php">Categories</a>
            <a href="../stocks/stock_main.php">Stock In/Out</a>
            <a href="../brands/add_brand.php">Brands</a>
            <a href="../users/user_main.php">Users</a>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h3 class="mb-4">Product List</h3>
            <table class="table table-striped table-bordered">
                <thead class="table-dark width-100">
                    <tr>
                        <th>Product Name</th>
                        <th>Category ID</th>
                        <th>Brand ID</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Stock Quantity</th>
                        <th>Created Date</th>
                        <th>Created Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Product_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Category_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['Brand_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['Cost_price']); ?></td>
                                <td><?php echo htmlspecialchars($row['Selling_price']); ?></td>
                                <td><?php echo htmlspecialchars($row['Stock_Quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['Created_Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Created_Time']); ?></td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <a href="edit_product.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="delete_product.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                    </div>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>