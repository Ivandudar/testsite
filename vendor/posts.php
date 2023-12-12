<?php
session_start();
require_once "connect.php";

class UserPostAdder {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function addPost() {
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            $userPost = $_POST['user_post'];
            $userPostEscaped = mysqli_real_escape_string($this->connection, $userPost);

            $sql = "INSERT INTO `user_posts` (`user_id`, `post_content`) VALUES ('$userId', '$userPostEscaped')";
            if (mysqli_query($this->connection, $sql)) {
                header('Location: ../index.php');
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        } else {
            echo "User ID not found in session.";
        }
    }
}

$userPostAdder = new UserPostAdder($connect);
$userPostAdder->addPost();
?>
