<?php
session_start();
require_once "connect.php";

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_post = $_POST['user_post'];
    $user_post_escaped = mysqli_real_escape_string($connect, $user_post); // Екранування даних

    $sql = "INSERT INTO `user_posts` (`user_id`, `post_content`) VALUES ('$user_id', '$user_post_escaped')";
    if (mysqli_query($connect, $sql)) {
        header('Location: ../index.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    }
} else {
    echo "User ID not found in session.";
}
?>
