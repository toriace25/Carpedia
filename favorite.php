<?php
session_start();
require_once('connect.php');
$dbh = connectDB();

$car_id = $_POST['car_id'];

try {
	if ($_SESSION['username']) {
		$user_id = $_SESSION['user']['user_id'];
		$query = "select car.car_id, user.user_id from user join user_car on user.user_id=user_car.user_id join car on user_car.car_id=car.car_id where car.car_id={$car_id} and user.user_id={$user_id};";
		$stmt = $dbh->prepare($query);
	  	$stmt->execute();

	  	if ($stmt->rowCount() == 0) {
		  	$query = "insert into user_car (user_id, car_id) values ({$user_id}, {$car_id});";
		  	$stmt = $dbh->prepare($query);
		  	$stmt->execute();
	  	}
	 	else {
		  	$query = "delete from user_car where user_id = {$user_id} and car_id = {$car_id};";
		  	$stmt = $dbh->prepare($query);
		  	$stmt->execute();
	  	}
  	}
}
catch(PDOException $e) {
	die('PDO error: ' . $e->getMessage());
}
?>
