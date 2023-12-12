<?php
session_start();
require_once "connect.php";

class UserPosts
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getUserPosts()
    {
        if (isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];

            $sql = "SELECT users.name, users.surname, user_posts.created_at, user_posts.post_content, user_posts.post_id
                FROM user_posts 
                INNER JOIN users ON user_posts.user_id = users.id 
                WHERE user_posts.user_id = $userId
                ORDER BY user_posts.created_at DESC";

            $result = mysqli_query($this->connection, $sql);

            if (!$result) {
                echo "Error: " . mysqli_error($this->connection);
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="post">';
                    echo '<div class="user_info">';
                    echo '<div class="name">' . $row["name"] . '</div>';
                    echo '<div class="surname">' . $row["surname"] . '</div>';
                    echo '<div class="published_at">' . "Published at: " . $row["created_at"] . '</div>';
                    echo '</div>';
                    echo '<div class="post_content">' . $row["post_content"] . '</div>';
                    echo '<a class="button_edit button" href="edit_post.php?post_id=' . $row['post_id'] . '">EDIT</a>';
                    echo '</div>';
                }
            }
            mysqli_close($this->connection);
        } else {
            echo "User is not authenticated!";
        }
    }
}

$userPosts = new UserPosts($connect);
$userPosts->getUserPosts();
?>
