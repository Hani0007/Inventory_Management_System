<?php
session_start();
include '../../config/db.php';

$brand = '';
$branderror = '';

if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is Not set</p>";
} else {
    $username = $_SESSION['Username'];
}




$brand_id = $_GET['id'];

// Fetch existing record
$sql = $conn->prepare("SELECT * FROM brands WHERE id = ?");
$sql->bind_param('i', $brand_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $brand = $row['name'];
}

// Handle form submission
if (isset($_POST['update'])) {
    $brand = $_POST['brand_name'];

    if (empty($brand)) {
        $branderror = 'Brand is Required';
    }

    if (!$branderror) {
        $sql = $conn->prepare("UPDATE brands SET name = ? WHERE id = ?");
        $sql->bind_param('si', $brand, $brand_id);
        $sql->execute();
        echo "<p style='background: linear-gradient(to right, #d4edda, #c3e6cb); color: #155724; font-weight: bold; text-align: center; padding: 10px; border-radius: 5px;'>Updated Successfully</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Brand - Inventory</title>
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
                    <a href="#">Products</a>
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
                        <h3 class="mb-4">Update Brand</h3>
                        <span class="admin ms-auto">Welcome, <?= htmlspecialchars($username); ?></span>
                        <a href="logout.php" class="btn btn-warning text-white">Logout</a>
                    </div>
                </nav>

                <form method="post">
                    <div class="col-md-3">
                        <label for="brand_name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" name="brand_name" value="<?= htmlspecialchars($brand) ?>">
                        <div class="text-danger"><?= $branderror ?></div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <button type="submit" name="update" class="btn btn-info text-white">Update Brand</button>
                    </div>
                </form>

            </main>
        </div>
    </div>
</body>

</html>
