<?php

$connect = mysqli_connect('localhost', 'root', 'root', 'mydatabase');
if (!$connect){
    die("Error connect to database");
}
?>