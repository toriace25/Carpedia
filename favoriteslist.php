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

    <title>Carpedia - Favorites</title>
  </head>

  <?php include('base.php'); ?>

  <body>
    <?php
	if ($_SESSION['username']) {
		echo "<center>";
		echo "<h1 class='display-4'>{$_SESSION['user']['first_name']}'s Favorite Cars</h1>";
		echo "</center>";

		try {
			$query = "select c.make, c.model, c.year from car c join user_car uc on c.car_id=uc.car_id join user u on uc.user_id=u.user_id where u.user_id={$_SESSION['userid']};";
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
					echo "<h5 class='card-title'><a href='./car.php?make={$make}&model={$model}&year={$year}'/>{$year} {$make} {$model}</h5>";
					echo "</center>";
					echo "</div>";
					echo "</center>";
					echo "</div>";
				}
			}
			else {
				echo "<center>";
				echo "<p class='lead'>You have not favorited any cars yet. Favorite a car and it will appear here!</p>";
				echo "</center>";
			}
		}
		catch(PDOException $e) {
			die('PDO error: ' . $e->getMessage());
		}
	}
	else {
		echo "<center>";
		echo "<h1 class='display-4'>Favorite Cars</h1>";
		echo "<br/>";
		echo "<p class='lead'>Log in to view your favorite cars, or register to start favoriting!</p>";
		echo "</center>";
	}
    ?>	
  </body>
</html>
