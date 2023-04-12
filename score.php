<?php

require "dbBroker.php";
require "user.php";


session_start();

if (isset($_POST['score']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_score = $_POST['score'];

    User::writeScore($user_id, $conn, $user_score);
    
}
 


?>