<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (isset($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | YESEFERSEW</title>
    <style>
        body { font-family: sans-serif; background: #1a1a2e; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #16213e; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); width: 300px; }
        h2 { text-align: center; color: #D4AF37; }
        input { width: 100%; padding: 0.8rem; margin: 0.5rem 0; border-radius: 0.5rem; border: none; box-sizing: border-box; }
        button { width: 100%; padding: 0.8rem; background: #D4AF37; color: #1a1a2e; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: bold; }
        .error { color: #ff6b6b; font-size: 0.8rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>YESEFERSEW ADMIN</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
