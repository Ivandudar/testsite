<?php
session_start();
?>

<head>
    <link href="../dist/css/main.css" rel="stylesheet">
</head>


<body>
<div class="container">
    <header class="header">
        <div class="logo">
            <a href="/" class="logo_link">
                <img src="../src/img/logo.png" width="40" height="40">
            </a>
        </div>
        <ul class="menu">
            <li class="menu_item">
                <a href="/" class="menu_link">
                    <img src="../src/img/home.svg" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Home
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/search.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Explore
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/Notifications.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Notifications
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/Messages.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Messages
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/Lists.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Lists
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/Communities.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Communities
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/logo.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    Premium
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link" href="/profile.php">
                    <img src="../src/img/Profile.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    My posts
                </span>
                </a>
            </li>
            <li class="menu_item">
                <a class="menu_link">
                    <img src="../src/img/More.png" class="menu_img" height="26" width="26">
                    <span class="menu_text">
                    More
                </span>
                </a>
            </li>
        </ul>
        <div class="button_container">

        </div>
        <div class="sign_container">

            <?php
            if (isset($_SESSION['user'])){
                echo '
            <a class="button" id="exit" href="vendor/logout.php">
                Exit
            </a> ';
            }
            else{
                echo '<button class="button" id="open_sign_in">
                Sign in
            </button>
            <button class="button" id="open_sign_up" >
                Sign up
            </button>';
            }
            ?>
        </div>
    </header>
    <main>
        <?php
        require_once "connect.php";
        ini_set('display_errors', 1);
        if(isset($_SESSION['user']['id'])) {
            // Отримання ідентифікатора посту
            $postId = $_GET['post_id'];
            $userId = $_SESSION['user']['id'];

            // Отримання даних про пост для відображення у textarea
            $sql = "SELECT * FROM `user_posts` WHERE `post_id` = '$postId' AND `user_id` = '$userId'";
            $result = mysqli_query($connect, $sql);

            if($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $postContent = $row['post_content'];
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

            if ($stmt = mysqli_prepare($connect, $updateSql)) {
                mysqli_stmt_bind_param($stmt, "si", $newPostContent, $postId);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Changes saved successfully!";
                } else {
                    echo "Error updating the post: " . mysqli_error($connect);
                }

                mysqli_stmt_close($stmt);
            }
        }
        ?>

      <div class="edit_wrapper">
          <h3 class="premium_title">Edit post</h3>
          <form method="POST">
              <textarea name="post_content" class="post_area edit_area" required><?php echo $postContent; ?></textarea>
              <input  class="button edit_submit_button" type="submit" name="save_changes" value="Save">
          </form>
      </div>


    </main>
    <footer class="footer">
        <div class="footer_wrapper">
            <div class="premium">
                <h3 class="premium_title">Subscribe to Premium</h3>
                <p class="premium_text">Subscribe to unlock new features and if eligible, receive a share of ads revenue.</p>
                <button class="button premium_button">Subscribe</button>
            </div>
            <div class="footer_block">
                <ul class="footer_ul">
                    <li class="footer_li">
                        <a class="footer_li_a">
                            Terms of Service
                        </a>
                    </li>
                    <li class="footer_li">
                        <a class="footer_li_a">
                            Privacy Policy
                        </a>
                    </li>
                    <li class="footer_li">
                        <a class="footer_li_a">
                            Cookie Policy
                        </a>
                    </li>
                    <li class="footer_li">
                        <a class="footer_li_a">
                            Accessibility
                        </a>
                    </li>
                    <li class="footer_li">
                        <a class="footer_li_a">
                            Ads info
                        </a>
                    </li>
                    <li class="footer_li">
                        <a class="footer_li_a">
                            More
                        </a>
                    </li>
                    <li class="footer_li">
                        © 2023 X Corp
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</div>


<div class="pop_up" id="pop_up_sign_in">
    <div class="pop_up_container">
        <div class="pop_up_body">
            <form class="pop_up_form" action="signin.php" method="post">
                <span class="pop_up_title">Log in</span>
                <input class="input" type="text" placeholder="Email" name="email">
                <input class="input" type="password" placeholder="Password" name="password">
                <button class="button button_pop_up" type="submit">Sign in</button>
            </form>
            <img src="../src/img/close.png" width="30" height="30" class="close_pop_up" id="close_sign_in">
        </div>
    </div>
</div>

<div class="pop_up" id="pop_up_sign_up">
    <div class="pop_up_container">
        <div class="pop_up_body">
            <form class="pop_up_form" action="signup.php" method="post" >
                <span class="pop_up_title">Create an account</span>
                <input class="input" type="text" placeholder="Name" name="name">
                <input class="input" type="text" placeholder="Surname" name="surname">
                <input class="input" type="email" placeholder="Email" name="email">
                <input class="input" type="password" placeholder="Password" name="password">
                <button class="button button_pop_up" type="submit">Sign up</button>
            </form>
            <img src="../src/img/close.png" width="30" height="30" class="close_pop_up" id="close_sign_up">
        </div>
    </div>
</div>
<script src="../src/js/main.js"></script>
</body>