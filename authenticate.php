<?php
session_start();
$USERNAME = "project";
$PASSWORD = "abc@123";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $USERNAME && $password === $PASSWORD){
        $_SESSION['loggedin'] = true;
        header("Location: devices.php"); // redirect to devices dashboard
        exit;
    } else {
        echo "<script>alert('Invalid username or password'); window.location='login.php';</script>";
    }
}
?>
