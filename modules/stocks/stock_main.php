<?php
include '../../config/db.php';
session_start();

if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is not set.</p>";
    exit;
}

$username = $_SESSION['Username'];

$sql = $conn->prepare("SELECT Id, type, quantity, reason, created_by FROM stocks");
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
        html, body {
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
            <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
                <div class="container-fluid">
                    <h3 class="mb-0">Stock Entries</h3>
                    <div class="ms-auto d-flex align-items-center">
                        <span class="me-3">Welcome, <?php echo htmlspecialchars($username); ?></span>
                        <a href="logout.php" class="btn btn-warning text-white">Logout</a>
                    </div>
                </div>
            </nav>

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Reason</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Id']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_by']); ?></td>
                                <td>
                                    <a href="edit_stock.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_stock.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stock entry?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No stock entries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
