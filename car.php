<?php
session_start();
require_once('connect.php');
$dbh = ConnectDB();

$make = $_GET['make'];
$model = $_GET['model'];
$year = $_GET['year'];
$query = "select car_id from car where make = '{$make}' and model = '{$model}' and year = '{$year}';";
$stmt = $dbh->prepare($query);
$stmt->execute();
$car_id = ($stmt->fetch())['car_id'];
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

    <title>Carpedia - Car Info</title>
  </head>

  <?php include('base.php'); ?>

  <body>

    <div class="container-fluid">
      <?php
	echo "<h1 class='display-4'>{$year} {$make} {$model}</h1>";

	echo "<center>";
	if ($model !== 'Miata/MX-5') {
		echo "<img src='./Images/{$year}_{$model}.png' class='img-fluid' alt='car'>";
	}
	else {
		echo "<img src='./Images/{$year}_miata.png' class='img-fluid' alt='car'>";
	}
	echo "</center>";
      ?>
      <br/>
      <div class="post">
      <?php
	echo "<div class='post-action'>";
	$favorited = false;
        if ($_SESSION['username']) {
		$query = "select car.car_id, user.user_id from user join user_car on user.user_id=user_car.user_id join car on user_car.car_id=car.car_id where car.car_id = {$car_id} and user.user_id = {$_SESSION['userid']};";
		$stmt = $dbh->prepare($query);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			echo "<button type='button' class='btn btn-dark btn-lg' name='fav_unfav' id='favUnfav'>Remove from Favorites</button>";
			$favorited = true;
		}
		else {
			echo "<button type='button' class='btn btn-dark btn-lg' name='fav_unfav' id='favUnfav'>Add to Favorites</button>";
		}
	}
	echo "</div>";
      ?>
      <br/>
       </div>
      <?php
        $query = "select car.*, trim.* from trim join car on trim.car_id=car.car_id where make = '{$make}' and model = '{$model}' and year = '{$year}';";
        $stmt = $dbh->prepare($query);
	$stmt->execute();

	while (($row = $stmt->fetch()) != null) {
		$trim_id = $row['trim_id'];
		$name = $row['name'];
		$style = $row['body_style'];
		$hp = $row['horsepower'];
		$displacement = $row['engine_displacement'];
		$induction = $row['induction_type'];
		echo "<h3>Trim: {$name}</h3>";
		echo '<div class="table-responsive-sm">';
		echo '<table class="table">';
		echo '<thead>';
		echo '<tr class="table-active">';
		echo '<th scope="col">Style</th>';
              	echo '<th scope="col">Drive</th>';
              	echo '<th scope="col">Transmission</th>';
              	echo '<th scope="col">Horsepower</th>';
              	echo '<th scope="col">Displacement</th>';
              	echo '<th scope="col">Induction</th>';
              	echo '<th scope="col">MPG City</th>';
              	echo '<th scope="col">MPG Highway</th>';
            	echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		// Query to grab transmission type, drivetrain, and mpg
		$q = "select trans, drive, mpg_city, mpg_hwy from trim join mpg on trim.trim_id=mpg.trim_id join transmission on mpg.transmission_id=transmission.transmission_id join drivetrain on mpg.drivetrain_id=drivetrain.drivetrain_id where trim.trim_id = {$trim_id};";
		$s = $dbh->prepare($q);
		$s->execute();

		while (($r = $s->fetch()) != null) {
			echo '<tr>';
			echo "<td>{$style}</td>";
			echo "<td>{$r['drive']}</td>";
			echo "<td>{$r['trans']}</td>";
			echo "<td>{$hp}</td>";
			echo "<td>{$displacement}</td>";
			echo "<td>{$induction}</td>";
			echo "<td>{$r['mpg_city']}</td>";
			echo "<td>{$r['mpg_hwy']}</td>";
			echo "</tr>";
		}

		echo '</tbody>';
        	echo '</table>';
      		echo '</div>';
	}
      ?>
    </div>
</body>
</html>

<script type="text/javascript">
var favorited = "<?php echo $favorited; ?>";
var car_id = <?php echo $car_id; ?>;

$(document).ready(function(){

    // add/remove favorite click
	$("#favUnfav").on("click", function() {

        	// AJAX Request
        	$.ajax({
            		url: 'favorite.php',
            		type: 'post',
			data: {car_id:car_id},
			success: function(){
				// If it was favorited, switch the button to add and change favorited to false, otherwise swith to remove and change favorited to true
				if (favorited === "1") {
					$("#favUnfav").html("Add to Favorites");
					favorited = "";
	    			}
				else {
					$("#favUnfav").html("Remove from Favorites");
					favorited = "1";
				}
	    		},
	    		error: function(result) {
	    			alert('error');
	    		}	  
        	});
    	});
});
</script>
