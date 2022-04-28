<?php
session_start();
require_once('connect.php');
$dbh = ConnectDB();

$log = '';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

	try {
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		if(empty($email)) {
			$log = '<p class="error">Please enter your email</p>';
		}
		if(empty($password)) {
			$log .= '<p class="error">Please enter your password</p>';
		}

		// If we have no error messages, we can continue
		if(empty($log)) {
			$query = " SELECT * FROM user WHERE email = :email";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(':email', $email);
			$stmt->execute();

			// Grab the row to get the password if the row exists
			$row = $stmt->fetch();
			if($row) {
				// Check to see if the passwords match
				if(password_verify($password, $row['password'])) {
					$_SESSION['valid'] = true;
					$_SESSION['timeout'] = time();
					$_SESSION['username'] = $email;
					$_SESSION['user'] = $row;
					$_SESSION['userid'] = $row['user_id'];
					$log = '<div class="alert alert-info" role="alert"> ' . $email . ' has been logged in!</div>';
					header("location: home.php");
					exit();
				}
				else {
					$log = '<div class="alert alert-info" role="alert">Email and/or password is incorrect</div>';
				}
			}
			else {
				$log = '<div class="alert alert-info" role="alert">Email and/or password is incorrect</div>';
			}
		}
	}
	catch(PDOException $e) {
		die('PDO error: ' . $e->getMessage());
	}
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>
    Carpedia - Login
  </title>
  <meta charset="utf-8" />
  <meta name="Author" content="Victoria Scavetta" />
  <meta name="generator" content="vim" />
  <link rel="shortcut icon" href="./Images/favicon.ico" />
</head>

<body>
    
  <!--Navigation bar-->
  <?php include('base.php'); ?>
  <!--end of Navigation bar-->

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class='display-4'>Login</h2>
	<p class='lead'> Log in using your email and password.</p>
        <?php
          echo $log;
        ?>
        <form action="" method="post">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-dark" value="Submit">
          </div>
          <p class='lead'>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
