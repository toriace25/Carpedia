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
      <h1 class='display-4'>Search Results</h1>
    </center>

    <?php
	try {
		if ($_GET['body_style']) {
			$query = "select * from car where body_style = '{$_GET['body_style']}';";
		}
		elseif ($_GET['drivetrain']) {
			$query = "select distinct c.make, c.model, c.year from car c join trim t on c.car_id=t.car_id join trim_drivetrain td on t.trim_id=td.trim_id join drivetrain d on td.drivetrain_id=d.drivetrain_id where drive = '{$_GET['drivetrain']}';";
		}
		elseif ($_GET['transmission']) {
			$query = "select distinct c.make, c.model, c.year from car c join trim t on c.car_id=t.car_id join trim_transmission tt on t.trim_id=tt.trim_id join transmission tr on tt.transmission_id=tr.transmission_id where trans = '{$_GET['transmission']}';";
		}
                $stmt = $dbh->prepare($query);
                $stmt->execute();

                echo "<br/>";
                if($stmt->rowCount() > 0) {
                        echo "<div class='row row-cols-1 row-cols-md-3'>";
                        while (($row = $stmt->fetch()) != null) {
				$make = $row['make'];
				$model = $row['model'];
				$year = $row['year'];
                                echo "<div class='col mb-4' style='width: 18rem;'>";
                                echo "<center>";
                                if ($model != 'Miata/MX-5') {
                                        echo "<img src='./Images/{$year}_{$model}.png' style='width: 16rem; height: 8rem;'>";
                                }
                                else {
                                        echo "<img src='./Images/{$year}_miata.png' style='width: 16rem; height: 8rem;'>";
                                }
                                echo "<div class='card-body' style='width: 16rem'>";
                                echo "<center>";
                                echo "<h5 class='card-title'><a href='./car.php?make={$make}&model={$model}&year={$year}'>{$year} {$make} {$model}</h5>";
                                echo "</center>";
                                echo "</div>";
                                echo "</center>";
                                echo "</div>";
                        }
		}
		else {
			echo "<center>";
			echo "<p class='lead'>No results found. Try searching again!</p>";
			echo "</center>";
		}
        }
        catch(PDOException $e) {
                die('PDO error: ' . $e->getMessage());
        }
    ?>
  </body>
</html>