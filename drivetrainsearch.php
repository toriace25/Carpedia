<?php
        session_start();
        require_once('connect.php');
        $dbh = ConnectDB();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Author" content="Victoria Scavetta" />
    <meta name="generator" content="vim" />

    <link rel="shortcut icon" href="./Images/favicon.ico" />

    <title>Carpedia - Search</title>
  </head>

  <?php include('base.php'); ?>

  <body>
    <center>
      <h1 class='display-4'>Search by Drivetrain</h1>
    </center>

    <?php
        try {
                $query = "select distinct drive from drivetrain;";
                $stmt = $dbh->prepare($query);
                $stmt->execute();

                echo "<br/>";
                if($stmt->rowCount() > 0) {
                        echo "<div class='row row-cols-1 row-cols-md-3'>";
                        while (($row = $stmt->fetch()) != null) {
                                $drivetrain = $row['drive'];
                                echo "<div class='col mb-4' style='width: 18rem;'>";
                                echo "<center>";
                                if ($drivetrain == 'FWD') {
                                        echo "<img src='./Images/2021_Civic.png' style='width: 16rem; height: 8rem;'>";
                                }
                                elseif ($drivetrain == 'RWD') {
                                        echo "<img src='./Images/2021_miata.png' style='width: 16rem; height: 8rem;'>";
                                }
                                elseif ($drivetrain == 'AWD') {
                                        echo "<img src='./Images/2020_CX-5.png' style='width: 16rem; height: 8rem;'>";
                                }
                                echo "<div class='card-body' style='width: 16rem'>";
                                echo "<center>";
                                echo "<h5 class='card-title'><a href='./searchresults.php?drivetrain={$drivetrain}'>{$drivetrain}</h5>";
                                echo "</center>";
                                echo "</div>";
                                echo "</center>";
                                echo "</div>";
                        }
                }
        }
        catch(PDOException $e) {
                die('PDO error: ' . $e->getMessage());
        }
    ?>
  </body>
</html>
