<?php
require_once "connect.php";

class UserPostsHandler
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function displayUserPosts()
    {
        $sql = "SELECT users.name, users.surname, user_posts.created_at, user_posts.post_content 
                FROM user_posts 
                INNER JOIN users ON user_posts.user_id = users.id 
                ORDER BY user_posts.created_at DESC";

        $result = mysqli_query($this->connection, $sql);

        if (!$result) {
            echo "Error: " . mysqli_error($this->connection);
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->displayPost($row);
            }
        }

        mysqli_close($this->connection);
    }

    private function displayPost($row)
    {
        echo '<div class="post">';
        echo '<div class="user_info">';
        echo '<div class="name">' . $row["name"] . '</div>';
        echo '<div class="surname">' . $row["surname"] . '</div>';
        echo '<div class="published_at">' . "Published at: " . $row["created_at"] . '</div>';
        echo '</div>'; // Закриття блоку user_info
        echo '<div class="post_content">' . $row["post_content"] . '</div>';
        echo '</div>'; // Закриття блоку post
    }
}

$userPostsHandler = new UserPostsHandler($connect);
$userPostsHandler->displayUserPosts();
?>
