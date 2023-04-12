<?php

require "dbBroker.php";
require "user.php";


session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['user_id']) && isset($_POST["submit"]) && $_POST["submit"]=="logout") {
    echo "Uspesna odjava";

    session_destroy();
    header('Location: login.php');
    exit();
} 

$user_id = $_SESSION['user_id'];

$user_name = User::returnName($user_id, $conn);
$user_score = User::returnScore($user_id, $conn);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BESTica</title>
    
    <link rel="shortcut icon" href="images/best_logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
    <div class="header">
        <img src="images/best_logo_standard.png" alt="BEST Logo" class="logo">
        <h1>BESTica</h1>
        <form method="POST" action="#">
            <button type="submit" name="submit" value="logout" class="button btn-logout">Odjavi se</button>
        </form>
    </div>

    <div class="space"></div>
    <i class='fas fa-caret-left'></i>

    <div class="game">
        <div class="console">
            <div class="console-btns">
                <button class="button btn-restart" data-restart-btn>Restart</button>
                <a href="scoreboard.php" target="_blank"><button class="button">Scoreboard</button></a>
                <div class="saznajvise">
                    <p style="font-size:15px; font-weight:bold;">Saznaj više</p>
                    <a href="https://best.rs/" target="_blank"><button class="button btn-small">O BEST-u</button></a>
                </div>
            </div>

            <div class="screen">
                <p class="tekst"><b>Your BEST score:</b> <b><?php echo $user_score?></b></p>
                <canvas id="board"></canvas>
                <h3 class="tekst">Score: <span id="score"> 0</span></h3>
            </div>

            <div class="container hide" data-restart>
                <h3>GAME OVER!</h3>
                <p class="rezultat">Your score: <b><span id="score-end">0</span></b></p>
            </div>

            <div class="console-btns">
                <button id="up" class="btn"><i class='fas fa-caret-up'></i></button>
                <div style="display:flex; flex-direction:row; justify-content:center;">
                    <button id="left" class="btn"><i class='fas fa-caret-left'></i></button>
                    <button class="btn-nista"></button>
                    <button id="right" class="btn"><i class='fas fa-caret-right'></i></button>
                </div>
                <button id="down" class="btn"><i class='fas fa-caret-down'></i></button>
            </div>
        </div>
    </div>




    <script src="script.js"></script>

</body>
</html>