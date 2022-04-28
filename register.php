<?php
session_start();
// Connect to the database
require_once('connect.php');
$dbh = ConnectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

   try {
	   $query = 'SELECT * FROM user WHERE email = :email';
	   $stmt = $dbh->prepare($query);
	   $log = '';
	   $email = $_POST['email'];
	   $stmt->bindParam(':email', $email);

	   $stmt->execute();
	   if($stmt->rowCount() > 0) {
		  $log = '<div class="alert alert-info" role="alert">This email address is already registered</div>';
	   }
	   else {
		   $password = $_POST['password'];
		   $confirmpassword = $_POST['confirmpass'];
		   if(strlen($password) < 8) {
			   $log = '<div class="alert alert-info" role="alert">Password must have at least 8 characters</div>';
		   }
		   elseif($password != $confirmpassword) {
			   $log = '<div class="alert alert-info" role="alert">Passwords do not match</div>';
		   }
		   else {
			   $passwordhash = password_hash($password, PASSWORD_BCRYPT);
			   $query = 'INSERT INTO user (first_name, last_name, email, password) VALUES (:firstname, :lastname, :email, :password)';
			   $stmt = $dbh->prepare($query);
			   $firstname = $_POST['firstname'];
			   $lastname = $_POST['lastname'];
			   $stmt->bindParam(':firstname', $firstname);
			   $stmt->bindParam(':lastname', $lastname);
			   $stmt->bindParam(':email', $email);
			   $stmt->bindParam(':password', $passwordhash);

			   $stmt->execute();

			   $stmt = null;
			   $log .= '<div class="alert alert-info" role="alert">You have been registered successfully!</div>';
		   }
	    }
   }
   catch(PDOException $e) {
	   die ('PDO error inserting(): ' . $e->getMessage() );
   }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>
    Carpedia - Registration
  </title>
  <meta charset="utf-8" />
  <meta name="Author" content="Victoria Scavetta" />
  <meta name="generator" content="vim" />
  <link rel="shortcut icon" href="./Images/favicon.ico" />
</head>
    
<body>
  <!--Navigation bar-->
  <?php include('base.php');?>
  <!--end of Navigation bar-->

  <div class="container">
    <div class="row">
        <div class="col-md-12">
	    <h2 class='display-4'>Register</h2>
            <p class='lead'>Enter your first name, last name, and email. Create a password with at least 8 characters.</p>
            <?php echo $log; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="firstname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lastname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirmpass" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-dark">
                </div>
                <p class='lead'>Have an account? <a href="login.php">Login Here</a></p>
            </form>
        </div>
    </div>  
  </div>
</body>
</html>
