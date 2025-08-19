<?php 
include("admin_inc/db.php"); 

if (!isset($_GET['did'])) {
    die("ID not provided!");
}
$id = intval($_GET['did']);

$sql = "DELETE FROM vehical WHERE id=$id";

if ($con->query($sql)) {
    header("Location: view_vehical.php");
    exit;
} else {
    die("Error deleting record: " . $con->error);
}
?>
