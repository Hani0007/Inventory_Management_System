<?php
include '../../config/db.php';
session_start();
$email = $password = '';
$emailError = $passwordError = '';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $emailError = 'Email is Required';
        exit;
    }
    if (empty($password)) {
        $passwordError = 'Password is Required';
        exit;
    }
}
$sql = $conn->prepare("SELECT Username, Password FROM users WHERE email = ?");
$sql->bind_param('s', $email);
$sql->execute();
// Store the result for num_rows to work
$sql->store_result();
if ($sql->num_rows > 0) {
    $newresult = $sql->bind_result($username, $hashedPassword);
    $finalresult = $sql->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['Username'] = $username;
        //   echo $username;
        header('Location: dashboard.php');
        exit;
    }
}


















?>
<!-- modules/auth/login.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Inventory System</title>

    <!-- ✅ Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-container">
            <h3 class="text-center mb-4">Login</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                    <div class="text-danger"><?= $emailError ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" value="<?= htmlspecialchars($password) ?>">
                    <div class="text-danger"><?= $passwordError ?></div>
                </div>

                <button type="submit" class="btn btn-success w-100" name="submit">Login</button>
                <span class="text-center mt-4 d-block">
                    Don't have an account? <a href="register.php" class="text-decoration-none">Register</a>
                </span>


            </form>
        </div>
    </div>

    <!-- ✅ Bootstrap JS Bundle (optional but useful) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>