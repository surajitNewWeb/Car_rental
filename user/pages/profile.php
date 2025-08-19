<?php
include("dash_head.php");
include("../config/db.php");

// Check login
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user details
$user_sql = "SELECT * FROM users WHERE id='$user_id'";
$user_res = mysqli_query($con, $user_sql);
$user = mysqli_fetch_assoc($user_res);

// Update user data
if(isset($_POST['update'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password']; // Keep blank if not changing

    if(empty($username) || empty($email)){
        $message = "Username and Email are required!";
    } else {
        // Check if password is changed
        if(!empty($password)){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET username='$username', email='$email', password='$hashed_password' WHERE id='$user_id'";
        } else {
            $update_sql = "UPDATE users SET username='$username', email='$email' WHERE id='$user_id'";
        }

        if(mysqli_query($con, $update_sql)){
            $message = "Profile updated successfully!";
            // Refresh data
            $user_res = mysqli_query($con, $user_sql);
            $user = mysqli_fetch_assoc($user_res);
        } else {
            $message = "Error updating profile: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
   <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#071022; color:#fff; font-family:'DM Sans',sans-serif; }
        .card { background:#0f2940; border-radius:12px; padding:20px; margin-top:50px; box-shadow:0 4px 15px rgba(0,0,0,0.5);}
        h2 { color:#ffb020; margin-bottom:20px; }
        .btn-custom { background:#ffb020; color:#071022; font-weight:bold; border-radius:8px; padding:10px 20px; text-decoration:none; }
        .btn-custom:hover { background:#d98c00; color:#fff; }
        label { color:#8b98a6; }
        .message { margin-bottom:15px; color:#3ad7c0; }
    </style>
</head>
<body>
<div class="container">
    <div class="card mx-auto col-md-6">
        <h2>⚙️ My Profile</h2>
        <?php if($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label>New Password (leave blank if not changing)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" name="update" class="btn btn-custom w-100">Update Profile</button>
        </form>
        <a href="dashboard.php" class="btn btn-light w-100 mt-3">⬅ Back to Dashboard</a>
    </div>
</div>
 <?php include("../includes/footer.php"); ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
