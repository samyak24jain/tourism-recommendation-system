<?php
session_start();

require 'dbconnect.php';

//set validation error flag as false
$error = false;

if (isset($_POST['asd'])) {

    $pref1 = $_POST["pref1"];
	$pref2 = $_POST["pref2"];
	$location = $_POST["location"];
	$_SESSION['usr_pref1'] = $pref1;
	$_SESSION['usr_pref2'] = $pref2;
	$_SESSION['usr_location'] = $location;
}

if (isset($_POST['editprofile'])) {
	$id= $_SESSION['usr_id'];
	$name = $_SESSION['usr_name'];
	$email =  $_SESSION['usr_email'];
	$pref1 = $_SESSION['usr_pref1'];
	$pref2 = $_SESSION['usr_pref2'];
	$location = $_SESSION['usr_location'];
}

if (isset($_POST['editingform'])) {
	$id= $_SESSION['usr_id'];
	$name = $_SESSION['usr_name'];
	$email =  $_SESSION['usr_email'];
	$pref1 = $_POST["pref1"];
	$pref2 = $_POST["pref2"];
	$location = $_POST["location"];
	$_SESSION['usr_pref1'] = $pref1;
	$_SESSION['usr_pref2'] = $pref2;
	$_SESSION['usr_location'] = $location;
	
	//name can contain only alpha characters and space
	if (!preg_match("/^[a-zA-Z ]+$/",$pref1)) {
		$error = true;
		$pref1_error = "Preference must contain only alphabets and space";
	}
	if (!preg_match("/^[a-zA-Z ]+$/",$pref2)) {
		$error = true;
		$pref2_error = "Preference must contain only alphabets and space";
	}
	if (!preg_match("/^[a-zA-Z ]+$/",$location)) {
		$error = true;
		$location_error = "Location/Address must contain only alphabets and space";
	}
	if (!$error) {
		if(mysqli_query($con, "UPDATE users SET pref1 ='" . $pref1 . "',pref2= '" . $pref2 . "', location= '" . $location . "' WHERE id = '" . $id . "'")) {
			$successmsg = "Successfully Editted! <a href='index.php'>Go Back</a>";
		} else {
			$errormsg = "Username & email already exist.";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">LOGO</a>
		</div>
		<!-- menu items -->
		
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Edit Profile</legend>

					<div class="form-group">
						<label for="name">Name</label>
						<p class="form-control-static"><?php echo $name; ?></p>
						<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
					</div>
					
					<div class="form-group">
						<label for="name">Email</label>
						<p class="form-control-static"><?php echo $email; ?></p>
						<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Preference 1</label>
						<input type="text" name="pref1" placeholder="Enter first preference tourist location" required value="<?php echo $pref1; ?>" class="form-control" />
						<span class="text-danger"><?php if (isset($pref1_error)) echo $pref1_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Preference 2</label>
						<input type="text" name="pref2" placeholder="Enter second preference tourist location" required value="<?php echo $pref2; ?>" class="form-control" />
						<span class="text-danger"><?php if (isset($pref2_error)) echo $pref2_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Location</label>
						<input type="text" name="location" placeholder="Enter your address location" required value="<?php echo $location; ?>" class="form-control " />
						<span class="text-danger"><?php if (isset($location_error)) echo $location_error; ?></span>
					</div>

					<div class="form-group">
						<input type="submit" name="editingform" value="Save Changes" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
	</div>
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>