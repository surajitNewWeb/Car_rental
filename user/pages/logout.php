
<?php
session_start();

// Only clear user session
unset($_SESSION['user_id']);
unset($_SESSION['username']);

// Optional: destroy() if you want to reset everything
// session_destroy();

header("location:/car_rental/index.php");
exit;
?>
