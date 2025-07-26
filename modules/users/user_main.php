<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<p style = 'color:red;'>Username is Not set</p>";
} else {

    $username = $_SESSION['Username'];
}

$sql = $conn->prepare("SELECT Id,Username,Email,Role FROM users");
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                 <nav class="col-md-2 d-none d-md-block sidebar">
        <div class="position-sticky">
          <h4 class="text-white text-center">StockFlow</h4>
          <a href="../auth/dashboard.php">Dashboard</a>
          <a href="../products/product_main.php">Products</a>
          <a href="../categories/add_cat.php">Categories</a>
          <a href="#">Stock In/Out</a>
           <a href="../brands/add_brand.php">Brands</a>
          <a href="../users/user_main.php">Users</a>
          
        </div>
      </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light my-3">
                    <div class="container-fluid">
                        <h3 class="mb-0">Total Users</h3>
                        <div class="ms-auto d-flex align-items-center">
                            <span class="me-3">Welcome, <?php echo htmlspecialchars($username); ?></span>
                            <a href="../auth/logout.php" class="btn btn-warning text-white">Logout</a>
                        </div>
                    </div>
                </nav>

                <!---Table---->
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['Username']) ?></td>
                                    <td><?php echo htmlspecialchars($row['Email']) ?></td>
                                    <td><?php echo htmlspecialchars($row['Role']) ?></td>
                                    <td>
                                    <a href="edit_user.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="delete_user.php?id=<?php echo $row['Id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No User Found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>