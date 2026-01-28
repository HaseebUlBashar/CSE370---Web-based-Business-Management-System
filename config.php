<?php
session_start();
$conn = new mysqli("localhost","root","","business_db");
if($conn->connect_error) die("DB failed");

function check_login(){
  if(!isset($_SESSION['id'])){ header("Location:index.php"); exit; }
}
?>