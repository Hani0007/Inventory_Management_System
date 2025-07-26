<?php
include '../../config/db.php';

$username = $email = $role = '';
$usernameError = $emailError = $roleError = '';
$user_Id = $_GET['id'] ?? null;

if (!$user_Id) {
    echo "<p style='color:red;text-align:center;'>User ID missing.</p>";
    exit;
}

// Fetch existing record
$stmt = $conn->prepare("SELECT Username, Email, Role FROM users WHERE Id = ?");
$stmt->bind_param('i', $user_Id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['Username'];
    $email = $row['Email'];
    $role = $row['Role'];
} else {
    echo "<p style='color:red;text-align:center;'>User not found.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $hasError = false;

    if (empty($username)) {
        $usernameError = 'Username is Required';
        $hasError = true;
    }

    if (empty($email)) {
        $emailError = 'Email is Required';
        $hasError = true;
    }

    if (empty($role)) {
        $roleError = 'Role is Required';
        $hasError = true;
    }

    if (!$hasError) {
        $sql = $conn->prepare("UPDATE users SET Username = ?, Email = ?, Role = ? WHERE Id = ?");
        $sql->bind_param('sssi', $username, $email, $role, $user_Id);
        if ($sql->execute()) {
            // echo "<p style='color: green; text-align:center; font-size:20px; font-weight:bold; margin-top:45px'>User updated successfully!</p>";
         header('Location: user_main.php'); exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Update failed.</p>";
        }
    }
}
?>















<!-- modules/auth/register.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration - Inventory System</title>

    <!-- ✅ Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="register-container">
            <h3 class="text-center mb-4">Update User</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>">
                    <div style="color:red;"><?= $usernameError ?></div>
                </div>


                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                    <div style="color:red;"><?= $emailError ?></div>
                </div>

                <select name="role" class="form-select">
                    <option value="staff" <?= $role == 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="manager" <?= $role == 'manager' ? 'selected' : '' ?>>Manager</option>
                </select>

                <button type="submit" class="btn btn-success w-100 mt-4" name='update'>Update</button>
            </form>
        </div>
    </div>

    <!-- ✅ Bootstrap JS Bundle (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>