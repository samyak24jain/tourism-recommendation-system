<?php

session_start();
require 'dbconnect.php';

if (isset($_POST['payingform'])) {

	$ccdc = $_POST['ccdc'];
	$cvv = $_POST['cvv'];
	
		if(mysqli_query($con, "INSERT INTO payment(price,package_id,userid,creditcard_no,cvv) VALUES('" . $_SESSION['price'] . "', '" . $_SESSION['pid'] . "', '" . $_SESSION['usr_id'] . "', '" . $ccdc . "', '" . $cvv . "')")) {
			$successmsg = "Successfully payed";
		} else {
			$errormsg = "Payment failed. Please try again.";
		}
}

if (isset($_POST['makepayment'])) {
	
		if(mysqli_query($con, "INSERT INTO package_booking(package_id,package_name,userid,price,destination,userlocation) VALUES('" . $_SESSION['pid'] . "', '" . $_SESSION['pname'] . "', '" . $_SESSION['usr_id'] . "', '" . $_SESSION['price'] . "', '" . $_SESSION['destination'] . "', '" . $_SESSION['usr_location'] . "')")) {
			$successmsg = "Successfully booked,proceed to pay! <a href='login.php'>Click here to Login</a>";
		} else {
			$errormsg = "Booking failed.";
		}
}

if(isset($_GET['amount'])) {
	$amount = $_GET['amount'];

}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tourism Recommendation System</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport" >
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	</head>
	<body>
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">Tourism Recommendation System</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar1">
					<ul class="nav navbar-nav navbar-right">
						<?php if (isset($_SESSION['usr_id'])) { ?>
						<li><a href="profile.php">Profile</a></li>
						<li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?></p></li>
						<li><a href="logout.php">Log Out</a></li>
						<?php } else { ?>
						<li><a href="login.php">Login</a></li>
						<li><a href="register.php">Sign Up</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" style="margin-top: 130px;">
			<div><p class="text-success" style="text-align: center;"><?php if(isset($_POST['ccdc']) && isset($_POST['cvv'])) {echo "Payment Successful!";} ?></p></div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4 well">
					<form role="form" action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
						<fieldset>
							<legend>Make Payment</legend>

							<div class="form-group">
								<label for="name">Amount</label>
								<p class="form-control-static"><?php if(isset($_GET['amount'])) {echo "Rs. $amount";} ?></p>
							</div>

							<div class="form-group">
								<label for="name">Credit Card/Debit Card No.</label>
								<input type="number" name="ccdc" placeholder="Enter your CC/DC No." required class="form-control" />
							</div>

							<div class="form-group">
								<label for="name">CVV</label>
								<input type="number" name="cvv" placeholder="Enter your 3-digit CVV" required class="form-control " />
							</div>

							<div class="form-group">
								<input type="submit" name="payingform" value="Confirm Payment" class="btn btn-success" />
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>