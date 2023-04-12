<?php

class User {
    public $id;
    public $email;
    public $name;
    public $score;

    public function __construct($id = null, $email=null, $name=null, $score=null) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->score = $score;
    }

    public static function loginUser($usr, mysqli $conn) {
        $query = "SELECT * FROM user WHERE email='$usr->email'";
        $rez = $conn->query($query);
        return $rez;
    }

    public static function loginNewUser($usr, mysqli $conn) {
        $query = "INSERT INTO user (email, name, score) VALUES ('$usr->email', '$usr->name', 0)";
        $rez = $conn->query($query);
    }

    // public static function returnUser($usrid, mysqli $conn) {
    //     $query = "SELECT * FROM user WHERE id = '$usrid'";
    //     $rez = $conn->query($query);
    //     // return mysqli_fetch_assoc($rez)['maxid'];
    //     return $rez->fetch_assoc();
    // }

    public static function returnName($id, mysqli $conn) {
        $query = "SELECT name as nm FROM user WHERE id = '$id'";
        $rez = $conn->query($query);
        // return mysqli_fetch_assoc($rez)['maxid'];
        return $rez->fetch_assoc()['nm'];
    }

    public static function returnScore($id, mysqli $conn) {
        $query = "SELECT score as scr FROM user WHERE id = '$id'";
        $rez = $conn->query($query);
        // return mysqli_fetch_assoc($rez)['maxid'];
        return $rez->fetch_assoc()['scr'];
    }

    public static function writeScore($id, mysqli $conn, $score) {
        $lastScore = User::returnScore($id, $conn);
        echo "novi:"; echo $score;
        echo " ";
        echo "stari:"; echo $lastScore;
        // exit();
        if ($score > $lastScore) {
            $query = "UPDATE user SET score='$score' WHERE id='$id'";
            $rez = $conn->query($query);
            return;
        }
    }

    public static function maxScore(mysqli $conn) {
        $query = "SELECT MAX(score) as maxscr FROM user";
        $rez = $conn->query($query);
        return $rez->fetch_assoc()['maxscr'];
    }

    public static function maxUser(mysqli $conn) {
        $maxscore = User::maxScore($conn);
        $query = "SELECT * FROM user WHERE score='$maxscore'";
        $rez = $conn->query($query);
        return $rez->fetch_assoc();
    }


    public static function getAll(mysqli $conn) {
        $query = "SELECT * FROM user ORDER BY score DESC";

        $rez = $conn->query($query);
        return $rez;
    }
    
    public static function getAllWithoutOrder(mysqli $conn) {
        $query = "SELECT * FROM user";

        $rez = $conn->query($query);
        return $rez;
    }

}

?>