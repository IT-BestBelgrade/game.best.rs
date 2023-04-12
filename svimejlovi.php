<?php
    
require "dbBroker.php";
require "user.php";

session_start();

$mejl = 'mejl';
if(isset($_POST['email']) ){
    $uemail = $_POST['email'];
    // $uname = $_POST['name'];

    $korisnik = new User(null, $uemail, "");
    $odg = User::loginUser($korisnik, $conn);
    $kor = $odg->fetch_assoc();

    $_SESSION['user_id'] = $kor['id'];

    $mejl = $kor['email'];
}

$rezultat = User::getAllWithoutOrder($conn);
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
    <title>Mejlovi</title>

    <!-- <link rel="shortcut icon" href="images/best_logo1.png" type="image/x-icon"> -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
</head>
<body>

    <!-- <div class="header" style="justify-content:space-between">
       <img src="images/best_logo_standard.png" alt="BEST Logo" class="logo">
       <h1>BESTica</h1>
        <img src="images/best_logo_white.png" alt="BEST Logo" class="logo">
    </div> -->

<?php
if ($mejl != 'vrankovic.nina00@gmail.com' && $mejl != 'it@best.rs' && $mejl != 'simic.mila.best@gmail.com' && $mejl != 'pr@best.rs'){
?>

    <div class="login-form">
        <form method="POST" action="#">

            <div class="container">
                <label for="email" class="lbl">Email</label>
                <input type="email" name="email" id="email" class="inpt" required>
                <br>
                <button type="submit" name="submit" value="login" class="button btn-login">Prijavi se</button>
            </div>

        </form>
    </div>

<?php   
}
?>


<?php
if ($mejl == 'vrankovic.nina00@gmail.com' || $mejl == 'it@best.rs' || $mejl == 'simic.mila.best@gmail.com' || $mejl == 'pr@best.rs'){
?>

<div class="cont-tabela">

<table class="tabela">
    <thead>
        <tr>
            <!-- <th class="tbl-rang">Rang</th> -->
            <th>Email</th>
            <!-- <th class="tbl-name">Name</th> -->
            <!-- <th class="tbl-score">Score</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        // $i = 0;
        while ($red = $rezultat->fetch_array()) {
            // $i++;
        ?>
            <tr>
                <!-- <td class="tbl-rang"><?php echo $i ?></td> -->
                <td><?php echo $red['email'] ?></td>
                <!-- <td class="tbl-name"><?php echo $red['name'] ?></td> -->
                <!-- <td class="tbl-score"><?php echo $red['score'] ?></td> -->
            </tr>
        <?php    
        }
        ?>
    </tbody>
</table>
</div>

<?php   
}
?>
    



</body>
</html>