<?php
// modules/auth/register.php
include '../../config/db.php';
session_start();

$username = $email = $password = $role = '';
$usernameError = $emailError = $passwordError = $roleError = '';
$successMesg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validation
    if (empty($username)) {
        $usernameError = 'Username is required';
    }

    if (empty($email)) {
        $emailError = 'Email is required';
    }

    if (empty($password)) {
        $passwordError = 'Password is required';
    }

    if (empty($role)) {
        $roleError = 'Role is required';
    }

    // If no validation errors
    if (empty($usernameError) && empty($emailError) && empty($passwordError) && empty($roleError)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = $conn->prepare("INSERT INTO users(username, email, password, role) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $username, $email, $hashed_password, $role);

        if ($sql->execute()) {
            // Optional success message (if not redirecting)
            // $successMesg = "Registered successfully!";
            header('Location: login.php');
            exit;
        } else {
            $emailError = 'Email already exists or registration failed.';
        }

        $sql->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration - Inventory System</title>
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
        .text-danger {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-container">
        <h3 class="text-center mb-4">Register New User</h3>
        <?php if (!empty($successMesg)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($successMesg) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>">
                <?php if ($usernameError): ?><div class="text-danger"><?= $usernameError ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                <?php if ($emailError): ?><div class="text-danger"><?= $emailError ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
                <?php if ($passwordError): ?><div class="text-danger"><?= $passwordError ?></div><?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">-- Select Role --</option>
                    <option value="staff" <?= $role == 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="manager" <?= $role == 'manager' ? 'selected' : '' ?>>Manager</option>
                </select>
                <?php if ($roleError): ?><div class="text-danger"><?= $roleError ?></div><?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success w-100" name="submit">Register</button>
            <span class="text-center mt-4 d-block">
                Already have an account? <a href="login.php" class="text-decoration-none">Login</a>
            </span>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



