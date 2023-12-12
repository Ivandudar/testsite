<?php
require_once "connect.php";
if (isset($_SESSION['user'])) {
    echo '
        <a class="button" id="exit" href="vendor/logout.php">
            Exit
        </a> ';
} else {
    echo '<button class="button" id="open_sign_in">
            Sign in
        </button>
        <button class="button" id="open_sign_up" >
            Sign up
        </button>';
}
?>
