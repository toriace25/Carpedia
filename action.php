<?php
require_once('connect.php');
$dbh = ConnectDB();
$make = $_GET['make'];

try {

	if (!empty($make)) {
		// Fetch model based on make
		$query = "SELECT DISTINCT model FROM car WHERE make = '{$make}' order by model;";
		$stmt = $dbh->prepare($query);
		$stmt->execute();

		echo "<option value=''>Choose Model</option>";
 		while (($row = $stmt->fetch()) != null) {
			echo "<option value='{$row['model']}'>{$row['model']}</option>"; 
 		}
	}
	elseif (!empty($_GET['model'])) {
		$model = $_GET['model']; 
		// Fetch year based on model
		$query = "SELECT year FROM car WHERE model = '{$model}' order by year desc;";
		$stmt = $dbh->prepare($query);
		$stmt->execute();

		echo "<option value=''>Choose Year</option>";
	    	while (($row = $stmt->fetch()) != null) {
	       		echo '<option value="'.$row['year'].'">'.$row['year'].'</option>'; 
	    	}
	}
}
catch(PDOException $e) {
	die('PDO error: ' . $e->getMessage());
}
?>
