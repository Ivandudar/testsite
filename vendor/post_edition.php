<?php
// post_edition.php

require_once "connect.php";

class PostEditor {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function editPost() {
        if(isset($_SESSION['user']['id'])) {
            // Отримання ідентифікатора посту
            $postId = $_GET['post_id'];
            $userId = $_SESSION['user']['id'];

            // Отримання даних про пост для відображення у textarea
            $sql = "SELECT * FROM `user_posts` WHERE `post_id` = '$postId' AND `user_id` = '$userId'";
            $result = mysqli_query($this->connection, $sql);

            if($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $postContent = $row['post_content']; // Отримання контенту поста для використання в textarea
            } else {
                echo "The post was not found or you don't have permission to edit this post.";
                exit();
            }
        } else {
            echo "The user is not logged in or the post identifier for editing is not specified.";
            exit();
        }

        // Перевірка методу запиту на POST (при натисканні на кнопку для збереження)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
            $newPostContent = $_POST['post_content'];

            $updateSql = "UPDATE user_posts SET post_content = ? WHERE post_id = ?";

            if ($stmt = mysqli_prepare($this->connection, $updateSql)) {
                mysqli_stmt_bind_param($stmt, "si", $newPostContent, $postId);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Changes saved successfully!";
                } else {
                    echo "Error updating the post: " . mysqli_error($this->connection);
                }

                mysqli_stmt_close($stmt);
            }
        }

        return $postContent; // Повернення контенту поста для використання в HTML-коді
    }
}

$postEditor = new PostEditor($connect);
$postContent = $postEditor->editPost();
?>
