<?php
session_start();
require_once "connect.php";

$email = $_POST['email'];
$password = md5($_POST['password']);

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    $_SESSION['user'] = [
        "id" => $user['id'],
        "name" => $user['name'],
        "surname" => $user['surname'],
        "email" => $user['email'],
    ];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else{
    $_SESSION['message'] = 'Wrong email or password! Try again!';
    header('Location: ../index.php');

}