<?php
session_start();
require_once('connect.php');
$dbh = ConnectDB();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="Author" content="Victoria Scavetta" />
  <meta name="generator" content="vim" />

  <link rel="shortcut icon" href="./Images/favicon.ico" />

  <title>Carpedia - Home</title>

  <style>
  body {
    background-image: url('./Images/honda_civic.jpg');
    height: 100vh;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }
  .title {
    margin-bottom: 3rem;
  }
  </style>
</head>

<?php include('base.php'); ?>

<body>
  <div class="container-fluid">
    <center class="title">
    <h1 class="display-3">Welcome to Carpedia</h1>
    </center>

    <center>
      <div class="card text-white bg-dark mb-3" style="max-width: 35rem;">
        <div class="card-body">
	  <h5 class="card-title">Choose a Specific Model</h5>
	  <form class="form-inline well" action="./car.php" method="get">
	    <div class="form-group">
<?php
try {
	$query = 'SELECT DISTINCT make FROM car ORDER BY make;';
	$stmt = $dbh->prepare($query);
	$stmt->execute();
	echo "<select class='custom-select' name='make' id='make' size='1'>";
	echo "<option selected='selected' value=''>Choose Make</option>";
	$i = 1;
	while (($row = $stmt->fetch()) != null) {
		echo "<option value = '{$row['make']}'>{$row['make']}</option>";
		$i = $i + 1;
	}
	echo "</select>";
}
catch(PDOException $e) {
	die('PDO error: ' . $e->getMessage());
}
?>
              <select class="custom-select" name="model"
               id="model" size="1">
               <option selected="selected" value="">Choose Model</option>
	     </select>
              <select class="custom-select" name="year"
               id="year" size="1">
               <option selected="selected" value="">Choose Year</option>
             </select>
	    </div>
            <div class="form-group">
              <input type="submit" class="btn btn-secondary" value="Search" />
	    </div>
	  </form>
        </div>
      </div>
    </center>
  </div>
</body>
</html>

<script src="./homesearch.js"></script>
