<?php
session_start();

// Only clear admin session (not user session)
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['admin_email']);

// Optional: destroy the session if you want to clear everything
// session_destroy();

header("Location: login.php");
exit;
?>
