<?php
session_start();
require_once 'connect.php';
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);
mysqli_query($connect, "INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`) VALUES (NULL, '$name', '$surname', '$email', '$password')");

header('Location: ../index.php'); // Редирект на головну сторінку
