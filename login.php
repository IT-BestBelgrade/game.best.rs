<?php
    
require "dbBroker.php";
require "user.php";

session_destroy();
session_start();

if(isset($_POST['email']) && isset($_POST['name'])){
    $uemail = $_POST['email'];
    $uname = $_POST['name'];

    $korisnik = new User(null, $uemail, $uname);

    // $odg = $korisnik->loginUser($korisnik, $conn);
    $odg = User::loginUser($korisnik, $conn); //pristup statickim funkcijama preko klasa
    
    if ($odg->num_rows==1){  //email vec postoji u bazi
        $kor = $odg->fetch_assoc();
        echo "postoji user";

        if ($kor['name'] == $uname) {  //user postoji u bazi
            $_SESSION['user_id'] = $kor['id'];
            header('Location: index.php');
            exit();

        } else {  //nije unet isti email i name
            echo "NISTE UNELI DOBRE PODATKE";

            $_SESSION['pogresan_name'] = "pogresan name";
            $_SESSION['pogresan_email'] = $kor['email'];
            header('Location: pogresanLogin.php');
            exit();
        }

    } else if ($odg->num_rows==0){   //novi user
        User::loginNewUser($korisnik, $conn);
        
        $odg_new = User::loginUser($korisnik, $conn);
        $kor_new = $odg_new->fetch_assoc();
 
        $mejl = $kor_new['email'];
        $nejm = $kor_new['name'];
        $_SESSION['user_id'] = $kor_new['id'];
        header('Location: index.php');

        $to = $mejl;
        $subject = "[BEST Belgrade][Game] Uspešno logovanje";
        $text = "
        <html>
            <head>
                <title>[BEST Belgrade][Game] Uspešno logovanje</title>
            </head>
            <body>
	     <p>
	      Zdravo,
	      <br /><br />
	      Uspešno ste se prijavili na BESTica Game. Vaši uneti podaci su:
	      <br />
	      <b>Email:<span style='color: #1973be'> $mejl </span></b>
	      <br />
	      <b>Instagram:<span style='color: #1973be'> $nejm </span></b>
	      <br /><br />
	      Molimo Vas da iste podatke koristite prilikom svake naredne prijave.
	      <br /><br />
	      --
	      <br />
	      <p style='text-align: center;'>
	        <b style='font-size: 22px; color: #faa519;'>Započni svoju BEST avanturu!</b>
	        <br /><br />
	        Želiš da unaprediš svoja znanja i veštine, učiš, zabaviš se, putuješ i
	        razvijaš timski duh?
	        <br>
	        Jedna od najvećih studentskih organizacija, Udruženje
	        studenata tehnike Evrope, BEST Beograd, otvara vrata za <b>nove članove</b>! 
	        <br><br>
	        BEST Beograd ti pruža priliku da kroz organizaciju projekata za studente i rad
	        u timovima stekneš nova znanja i iskustva, oprobaš se u različitim sferama
	        i stekneš mnoštvo veština družeći se sa kolegama sa tehničko-tehnoloških i
	        prirodno-matematičkih fakulteta, kao i Farmaceutskog fakulteta. Moći ćeš
	        da putuješ i upoznaš BEST-ovce širom Evrope, s obzirom na to da je lokalna
	        grupa BEST Beograd samo jedna od 86 lokalnih BEST grupa širom Evrope.
	        <br><br>
	        <b style='font-size: 16px; color: #faa519;'>Prijave za nove članove otvorene su do 27. februara na: </b>
	        <br>
	        <b style='font-size: 15px; color: #faa519;'>https://best.rs/uclani-se/</b>
	        <br><br>
	        Ne propusti priliku da naučiš nešto novo,
	        unaprediš sebe i stekneš prijatelje i uspomene za ceo život. Započni svoju
	        BEST avanturu!
	        <br><br><br>
	        Puno pozdrava!
	      </p>
	      <br />
	      --
	      <br /><br />
	      This e-mail was sent from BESTica Game (https://game.best.rs/)
	    </p>
            </body>
        </html>
        ";
        $header = "MIME-Version: 1.0" . "\r\n";
        $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $header .= "From: BEST Belgrade <game@best.rs>" . "\r\n";
        $header .= "BCC: it@best.rs" . "\r\n";
        $header .= "Reply-to: it@best.rs" . "\r\n";
        mail($to, $subject, $text, $header);

        exit();

    } else{
        echo `<script>console.log( "Neuspesna prijava");</script>`;
        // $korisnik = null;
        exit();
    }
}

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
    <!-- <link rel="stylesheet" href="css/button.css"> -->
    <!-- <link rel="stylesheet" href="css/drugi.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <div class="header" style="justify-content:space-between">
        <img src="images/best_logo_standard.png" alt="BEST Logo" class="logo">
        <h1>BESTica</h1>
        <img src="images/best_logo_white.png" alt="BEST Logo" class="logo">

    </div>

    
    <!-- <img src="images/pozadina.jpg" alt="" class="background"> -->

    <div class="login-form">
        <form method="POST" action="#">

            <div class="container">
                <label for="email" class="lbl">Email</label>
                <input type="email" name="email" id="email" class="inpt" required>
                <br>
                <label for="neme" class="lbl">Instagram</label>
                <input type="text" name="name" id="name" class="inpt" value="@">
                <p class="fusnota" style="font-size:13px; font: weight 500px;">
                    Ako nemate Instagram, unesite nadimak.<br>
                    <!-- <i>Zapamtite vase podatke :)</i> -->
                </p>
                <br>
                <button type="submit" name="submit" value="login" class="button btn-login">Prijavi se!</button>
            </div>

        </form>
    </div>

    
</body>
</html>
