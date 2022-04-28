<?php

function ConnectDB() {

   /*** mysql server info ***/
    $hostname = '127.0.0.1';  // Local host, i.e. running on elvis
    $username = 'scavettav2';           // Your MySQL Username goes here
    $password = '1Lovepotion!';           // Your MySQL Password goes here
    $dbname   = 'scavettav2';           // Repeat your MySQL Username here

   try {
       $dbh = new PDO("mysql:host=$hostname;dbname=$dbname",
                      $username, $password);
    }
    catch(PDOException $e) {
        die ('PDO error in "ConnectDB()": ' . $e->getMessage() );
    }

    return $dbh;
}

?>

