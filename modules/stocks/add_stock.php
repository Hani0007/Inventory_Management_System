<?php
include '../../config/db.php';
session_start();

if (!isset($_SESSION['Username'])) {
    echo "<p style='color:red;'>Username is not set.</p>";
    exit;
}

$username = $_SESSION['Username'];

$product_id = $type = $quantity = $reason = $cost_price = $selling_price = '';
$TypeError = $quantityError = $reasonError = $productError = $cost_priceError = $selling_priceError = '';
$product_list = [];

$sql = $conn->prepare("SELECT Id, Product_Name FROM product");
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_list[] = $row;
    }
}

if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $reason = $_POST['reason'];
    $cost_price = $_POST['costprice'];
    $selling_price = $_POST['selling_price'];

    // Basic validation
    if (empty($product_id)) $productError = 'Product is required';
    if (empty($type)) $TypeError = 'Type is required';
    if (empty($quantity) || $quantity <= 0) $quantityError = 'Quantity must be greater than zero';
    if (empty($reason)) $reasonError = 'Reason is required';

    if (!$productError && !$TypeError && !$quantityError && !$reasonError) {

        // OUT validation
        if ($type === 'OUT') {
            $check = $conn->prepare("SELECT stock_quantity FROM product WHERE Id = ?");
            $check->bind_param("i", $product_id);
            $check->execute();
            $res = $check->get_result();
            $row = $res->fetch_assoc();

            if ($row['stock_quantity'] < $quantity) {
                echo "<div class='text-danger'>Error: Not enough stock available to perform stock OUT.</div>";
                exit;
            }
        }

        // Profit/loss calculation
        $profit_loss = 0;
        if ($type === 'IN') {
            $profit_loss = ($selling_price - $cost_price) * $quantity;
        }

        // Insert stock entry
        $sql = $conn->prepare("INSERT INTO stocks (product_id, type, quantity, reason, cost_price, selling_price, created_by) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("isisiis", $product_id, $type, $quantity, $reason, $cost_price, $selling_price, $username);

        if ($sql->execute()) {
            if ($type === 'IN') {
                $update = $conn->prepare("UPDATE product SET stock_quantity = stock_quantity + ? WHERE Id = ?");
            } else {
                $update = $conn->prepare("UPDATE product SET stock_quantity = stock_quantity - ? WHERE Id = ?");
            }

            $update->bind_param("ii", $quantity, $product_id);
            $update->execute();

            echo "<div class='alert alert-success'>
                    Stock entry added successfully and product quantity updated!<br>
                    <strong>Profit/Loss:</strong> PKR " . number_format($profit_loss, 2) . "
                 </div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to insert stock entry: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stock Entries - Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100vh;
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
            overflow-y: auto;
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
    <nav class="sidebar">
        <h4 class="text-white text-center">StockFlow</h4>
        <a href="../auth/dashboard.php">Dashboard</a>
        <a href="../products/product_main.php">Products</a>
        <a href="../categories/add_cat.php">Categories</a>
        <a href="../stocks/stock_main.php">Stock In/Out</a>
        <a href="../brands/add_brand.php">Brands</a>
        <a href="../users/user_main.php">Users</a>
    </nav>

    <div class="container mt-5">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Select Product</label>
                <select name="product_id" class="form-select">
                    <?php foreach ($product_list as $p): ?>
                        <option value="<?= $p['Id'] ?>" <?= $product_id == $p['Id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['Product_Name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-danger"><?= $productError ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Transaction Type</label>
                <select name="type" class="form-select">
                    <option value="">Select Type</option>
                    <option value="IN" <?= $type == 'IN' ? 'selected' : '' ?>>Stock In</option>
                    <option value="OUT" <?= $type == 'OUT' ? 'selected' : '' ?>>Stock Out</option>
                </select>
                <div class="text-danger"><?= $TypeError ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($quantity) ?>">
                <div class="text-danger"><?= $quantityError ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Reason</label>
                <input type="text" name="reason" class="form-control" placeholder="e.g. Purchase, Sale" value="<?= htmlspecialchars($reason) ?>">
                <div class="text-danger"><?= $reasonError ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Cost Price</label>
                <input type="number" name="costprice" class="form-control" value="<?= htmlspecialchars($cost_price) ?>">
                <div class="text-danger"><?= $cost_priceError ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Selling Price</label>
                <input type="number" name="selling_price" class="form-control" value="<?= htmlspecialchars($selling_price) ?>">
                <div class="text-danger"><?= $selling_priceError ?></div>
            </div>

            <button type="submit" class="btn btn-success" name="submit">Submit Entry</button>
        </form>

        
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

</html>
