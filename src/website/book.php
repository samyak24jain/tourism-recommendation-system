<?php

session_start();
require 'dbconnect.php';
	
	$pid = $_GET['pid'];
	$_SESSION['pid'] = $pid;
	$tempname = $_GET['pname'];
	$_SESSION['pname'] = $tempname;
	$user_id = $_SESSION['usr_id'];
	$user_name = $_SESSION['usr_name'];
	$user_email = $_SESSION['usr_email'];
	$dest = $_SESSION['destination'];

	if($tempname == "Economic") {
		$pname = "Economic Package";
		$price = 10000;
	} else if($tempname == "Semi") {
		$pname = "Semi Deluxe Package";
		$price = 15000;
	} else if($tempname == "Deluxe") {
		$pname = "Deluxe Package";
		$price = 20000;
	} else if($tempname == "Ultra") {
		$pname = "Ultra Deluxe Package";
		$price = 25000;
	} else if($tempname == "VIP") {
		$pname = "VIP Package";
		$price = 30000;
	}

	$_SESSION['price'] = $price;

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

		<div class="container" style="margin-top: 30px;">
		    <div class="row">
		        <div class="col-md-4 col-md-offset-4 well">
		            <form role="form" action="payment.php?amount=<?php echo $price; ?>" method="post" name="profileform">
		                <fieldset>
		                    <legend>Confirm booking</legend>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">Package ID</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $pid; ?></p>
		                    </div>
		                    
		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">Package Name</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $pname; ?></p>
		                    </div>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">User ID</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_id; ?></p>
		                    </div>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">User Name</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_name; ?></p>
		                    </div>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">User Email</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_email; ?></p>
		                    </div>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">Amount</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo "Rs. $price"?></p>
		                    </div>

		                    <div class="form-group">
		                        <label for="name" style="padding: 10px">Destination</label>
		                        <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $dest; ?></p>
		                    </div>


		                    <div class="form-group">
		                        <input type="submit" name="makepayment" value="Make Payment" class="btn btn-primary" />
		                    </div>
		                </fieldset>
		            </form>
		        </div>
		    </div>
		</div>

	</body>
</html>

