<?php
    
require "dbBroker.php";
require "user.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$rezultat = User::getAll($conn);
if (!$rezultat) {
   echo "Greska" ;
   die();
}
if ($rezultat->num_rows == 0) {
    echo "Nema rezultata";
    die();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BESTica - Scoreboard</title>

    <link rel="shortcut icon" href="images/best_logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
</head>
<body>

    <div class="header" style="justify-content:space-between">
       <img src="images/best_logo_standard.png" alt="BEST Logo" class="logo">
       <h1>BESTica</h1>
        <img src="images/best_logo_white.png" alt="BEST Logo" class="logo">
    </div>

    <!-- <img src="img/pozadina.png" alt="" class="background"> -->

    <div class="cont-tabela">

        <h2 style="color:#faa519; margin-top:-30px;">SCOREBOARD</h2>

        <table class="tabela">
            <thead>
                <tr>
                    <th class="tbl-rang">Rang</th>
                    <!-- <th>Email</th> -->
                    <th class="tbl-name">Name</th>
                    <th class="tbl-score">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while (($red = $rezultat->fetch_array()) && ($i < 10)) {
                    $i++;
                ?>
                    <tr>
                        <td class="tbl-rang"><?php echo $i ?></td>
                        <!-- <td><?php echo $red['email'] ?></td> -->
                        <td class="tbl-name"><?php echo $red['name'] ?></td>
                        <td class="tbl-score"><?php echo $red['score'] ?></td>
                    </tr>
                <?php    
                }
                ?>
            </tbody>
        </table>
    </div>
    



</body>
</html>