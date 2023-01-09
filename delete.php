<?php 
include "config.php";
$id = $_GET['id'];

$query = mysqli_query($con, "DELETE FROM algo_now WHERE algo_id='$id'");
echo "<script>window.location='report.php';</script>";
?>