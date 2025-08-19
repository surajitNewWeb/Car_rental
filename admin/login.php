<?php 
session_start();
include("admin_inc/db.php");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ✅ Directly check email + password (plain text)
    $stmt = $con->prepare("SELECT id, name FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['an'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];  
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: Arial, sans-serif;
    height: 100vh;
    background: rgba(6, 6, 58, 0.94);
    display: flex;
    justify-content: center;
    align-items: center;
}
.login-container {
    background: rgba(15, 41, 64, 0.9);
    padding: 40px 30px;
    border-radius: 12px;
    width: 100%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.6);
}
.login-container img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 10px;
    object-fit: cover;
    border: 2px solid #ffb020;
}
.login-container h2 {
    color: #ffb020;
    margin-bottom: 15px;
    font-size: 24px;
}
.login-container .error {
    color: #ff4d4d;
    margin-bottom: 15px;
    font-size: 14px;
}
.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    font-size: 16px;
}
.login-container input[type="submit"] {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    border: none;
    border-radius: 8px;
    background: #3ad7c0;
    color: #071022;
    font-weight: bold;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease;
}
.login-container input[type="submit"]:hover {
    background: #2bb3a2;
}
@media (max-width: 500px) {
    .login-container { padding: 30px 20px; }
    .login-container h2 { font-size: 20px; }
    .login-container input[type="text"],
    .login-container input[type="password"],
    .login-container input[type="submit"] { font-size: 14px; padding: 10px; }
}
</style>
</head>
<body>

<div class="login-container">
    <img src="assets/images/user.png" alt="Admin Logo">
    <h2>Admin Login</h2>

    <?php if(isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form method="POST">
        <input type="text" name="email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>
</div>

</body>
</html>
