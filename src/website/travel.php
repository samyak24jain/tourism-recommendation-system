<?php

session_start();

require 'dbconnect.php';

	// echo $_SESSION['usr_id'];
	// echo $_SESSION['usr_name'];
	// echo $_SESSION['usr_pref1'];
	// echo $_SESSION['usr_location'];
	// echo $_SESSION['destination'];

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

		<div class="container" style="text-align: center; margin-bottom: 30px; margin-top: 30px;">
			<h2>
				Choose your Travel Package<br/>
				<small>[Click to choose]</small>
			</h2>
		</div>
		<table class="table table-hover ">
 			<tr>
 				<th>Package ID</th>
 				<th>Package Name</th>
 				<th>Price (Rs.)</th>
 				<th>Destination</th>
 			</tr>
 			<tr class="active" onclick="window.location='book.php?pid=1&pname=Economic'">
 				<td>1</td>
 				<td>Economic Package</td>
 				<td>10000</td>
 				<td><?php echo $_SESSION['destination']; ?></td>
 			</tr>
 			<tr class="success" onclick="window.location='book.php?pid=2&pname=Semi'">
 				<td>2</td>
 				<td>Semi-Deluxe Package</td>
 				<td>15000</td>
 				<td><?php echo $_SESSION['destination']; ?></td>
 			</tr>
 			<tr class="warning" onclick="window.location='book.php?pid=3&pname=Deluxe'">
 				<td>3</td>
 				<td>Deluxe Package</td>
 				<td>20000</td>
 				<td><?php echo $_SESSION['destination']; ?></td>
 			</tr>
 			<tr class="danger" onclick="window.location='book.php?pid=4&pname=Ultra'">
 				<td>4</td>
 				<td>Ultra Deluxe Package</td>
 				<td>25000</td>
 				<td><?php echo $_SESSION['destination']; ?></td>
 			</tr>
 			<tr class="info" onclick="window.location='book.php?pid=5&pname=VIP'">
 				<td>5</td>
 				<td>VIP Package</td>
 				<td>30000</td>
 				<td><?php echo $_SESSION['destination']; ?></td>
 			</tr>
 		</table>
	</body>









</html>