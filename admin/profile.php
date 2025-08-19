<?php
session_start();
include("admin_inc/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

// Fetch admin details
$stmt = $con->prepare("SELECT name, email FROM admin WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle update
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = $con->prepare("UPDATE admin SET name=?, email=? WHERE id=?");
    $update->bind_param("ssi", $name, $email, $admin_id);
    if ($update->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow p-4">
    <h3 class="mb-3">My Profile</h3>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
      </div>
      <button type="submit" name="update" class="btn btn-custom">Update Profile</button>
      <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</div>

</body>
</html>
