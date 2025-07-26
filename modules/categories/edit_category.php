<?php
include '../../config/db.php';
session_start();

$category = '';
$categoryerror = '';

if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is not set</p>";
    exit;
} else {
    $username = $_SESSION['Username'];
}

// Get category ID from URL
$cat_id = $_GET['id'] ?? null;
if (!$cat_id) {
    echo "<p style='color:red;'>No category ID provided</p>";
    exit;
}

// Fetch existing category name
$sql = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$sql->bind_param('i', $cat_id);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $category = $row['name'];
} else {
    echo "<p style='color:red;'>Category not found</p>";
    exit;
}
$sql->close();

// Handle form submission
if (isset($_POST['update'])) {
    $category = trim($_POST['name']);

    if (empty($category)) {
        $categoryerror = 'Category is required';
    }

    if (!$categoryerror) {
        $sql = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $sql->bind_param('si', $category, $cat_id);
        if ($sql->execute()) {
            // Redirect after successful update
            header("Location: category_main.php?success=1");
            exit;
        } else {
            echo "<p style='color:red;'>Update failed: " . $sql->error . "</p>";
        }
        $sql->close();
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
                        <h3 class="mb-4">Update Categories</h3>
                        <span class="admin ms-auto">Welcome, <?= htmlspecialchars($username); ?></span>
                        <a href="logout.php" class="btn btn-warning text-white">Logout</a>
                    </div>
                </nav>

                <form method="post">
                    <div class="col-md-3">
                        <label for="brand_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($category) ?>">
                        <div class="text-danger"><?= $categoryerror ?></div>
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
