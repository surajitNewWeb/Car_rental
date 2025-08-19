<?php
$con = mysqli_connect("localhost", "root", "", "car_rental");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['sign'])) {
    $n = $_POST['name'];
    $e = $_POST['email'];
    $p = $_POST['pass'];

    $ins="INSERT INTO users SET username='$n', email='$e', password='$p' "; 
     if($con->query($ins)) {
         echo "<script>alert('✅ Sign up successful!');</script>"; 
           header("location:login.php");  
     } else{
            echo "<script>alert('❌ Error: Could not sign up');</script>";
         } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

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

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #ddd;
        }

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

        .form-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 5px #00ffd5, 0 0 10px #00ffd5;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(45deg, #00ffd5, #00aaff);
            color: #000;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px #00ffd5, 0 0 20px #00aaff;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .form-footer a {
            color: #00ffd5;
            text-decoration: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 500px) {
            .form-container {
                margin: 0 15px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Create Account</h2>
        <form method="post" action="">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pass" placeholder="Create password" required>
            </div>
            <button class="btn" type="submit" name="sign">Sign Up</button>
            <div class="form-footer">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>

</html>
<?php $con->close(); ?>