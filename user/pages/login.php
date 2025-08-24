<?php
session_start();
include("../config/db.php");

$message = ""; // for feedback messages

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['pass'];

    if (!empty($email) && !empty($password)) {
        // check if user exists
        $stmt = $con->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashedPassword);
            $stmt->fetch();

            // verify password
            if (password_verify($password, $hashedPassword)) {
                // login success → set session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header("Location: dashboard.php"); // redirect to dashboard (change if needed)
                exit;
            } else {
                $message = "<p style='color:red; text-align:center;'>Invalid password!</p>";
            }
        } else {
            $message = "<p style='color:red; text-align:center;'>No account found with this email!</p>";
        }

        $stmt->close();
    } else {
        $message = "<p style='color:red; text-align:center;'>All fields are required!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Login</title>
<style>
    * {margin: 0;padding: 0;box-sizing: border-box;font-family: 'Poppins', sans-serif;}
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #1f1c2c, #928dab);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-container {
        width: 100%;
        max-width: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(15px);
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        color: #fff;
        animation: fadeIn 1s ease-in-out;
    }
    .form-container h2 {text-align: center;margin-bottom: 20px;font-weight: 600;letter-spacing: 1px;}
    .form-group {margin-bottom: 15px;}
    .form-group label {display: block;font-size: 14px;margin-bottom: 5px;color: #ddd;}
    .form-group input {
        width: 100%;
        padding: 10px 15px;
        border: none;
        outline: none;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 14px;
        transition: 0.3s ease;
    }
    .form-group input:focus {background: rgba(255, 255, 255, 0.3);box-shadow: 0 0 5px #00ffd5, 0 0 10px #00ffd5;}
    .btn {
        width: 100%;padding: 10px;border: none;border-radius: 8px;
        background: linear-gradient(45deg, #00ffd5, #00aaff);
        color: #000;font-weight: bold;font-size: 16px;cursor: pointer;transition: 0.3s;
    }
    .btn:hover {transform: scale(1.05);box-shadow: 0 0 10px #00ffd5, 0 0 20px #00aaff;}
    .form-footer {text-align: center;margin-top: 15px;font-size: 13px;}
    .form-footer a {color: #00ffd5;text-decoration: none;}
    .message {margin-bottom: 15px;text-align:center;}
    @keyframes fadeIn {from { opacity: 0; transform: translateY(20px); }to { opacity: 1; transform: translateY(0); }}
    @media (max-width: 500px) {.form-container {margin: 0 15px;padding: 20px;}}
</style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>
    <?php if ($message) echo "<div class='message'>$message</div>"; ?>
    <form method="post" action="">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" placeholder="Enter password" required>
        </div>
        <button class="btn" type="submit" name="login">Login</button>
        <div class="form-footer">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </div>
    </form>
</div>

</body>
</html>
<?php $con->close(); ?>
