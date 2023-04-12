<?php

$host = "game.best.rs";
$db = "bestrs_game_mart23";
$user = "bestrs_bestrs";
$pass = "!;VyeHA(@W2S";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_errno){
    // console.log("Neuspesna konekcija. Greska".$conn->connect_error."poz");
    exit("Nauspesna konekcija: greska> ".$conn->connect_error.", err kod>".$conn->connect_errno);
}


?>