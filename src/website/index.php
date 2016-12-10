<?php
session_start();

require 'dbconnect.php';

//set validation error flag as false
$error = false;

function getaddress($lat,$lng)
{
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	if($status=="OK")
	{
		return $data->results[0]->formatted_address;
	}
	else
	{
		return false;
	}
}

if (isset($_POST['Upload_Image'])) {

	$target_dir = "/opt/lampp/htdocs/wta/uploaded/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	$filename = $_FILES["fileToUpload"]["name"];

	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        echo "File ". $_FILES["fileToUpload"]["name"] ." is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 5000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        chmod($target_file, 0777);
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}

if (isset($_POST['searchsubmit'])) {
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchkey = $_POST["searchkey"];
    $searchtime = date("Y-m-d H:i:s");
	}
	
	if(isset($_SESSION['usr_id']))
		$user_id = $_SESSION['usr_id'];
	else
		$user_id = 0;

	if(mysqli_query($con, "INSERT INTO searchresults(userid,searchterms,searchtime) VALUES('" . $user_id . "', '" . $searchkey . "', '" . $searchtime . "')")) {
			$successmsg = "Successfully Searched! ";
		} else {
			$errormsg = "Search unsuccessful.";
	}

	$result = mysqli_query($con, "SELECT * from photodata WHERE tags like '%" . $searchkey . "%'");
	$count = 0;
	$caption = array();
	$photos = array();
	while ($row = mysqli_fetch_array($result)) {
		$photos[$count] = $row['id'];
		$lat = $row['latitude'];
		$long = $row['longitude'];
		$address = getaddress($lat, $long);
		if($address) {
			$caption[$count] = $address;
		} else {
			$caption[$count] = "Not Available.";
		}
		$count = $count + 1;
		if ($count == 20) {
			break;
		}
	} 

} else{
?>
<script type="text/javascript">document.getElementById('hidediv').style.display = 'none';</script>
<?php
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
<div style="margin:0 auto; text-align: center;" class = "jumbotron">
	<h3>Search</h3> 
	<p>You  may search either by keyword :</p> 
	<form class="form-horizontal" method="post" action="<?php  echo $_SERVER['PHP_SELF']; ?>"  id="searchform"> 
		<input style="margin-right:30" class="input-lg" type="text" name="searchkey" value = <?php if (isset($_POST['searchsubmit'])) echo $searchkey; ?> > 
		<input style="margin-left:30" class="btn btn-primary btn-lg"  type="submit" name="searchsubmit" value="Search"> 
	</form> 
</div>
<!-- <div style="margin:0 auto; text-align: center;" >
	<h5>Or</h5>
</div>
<div style="margin:0 auto; text-align: center;" class = "jumbotron">
	<p>You  may search by image :</p> 
	<form class="form-horizontal" action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<div style ="display: inline;text-align: center;">
	    <p style ="display: inline;text-align: center;">Select image to upload:</p>
	    <input style ="display: inline;" type="file" name="fileToUpload" id="fileToUpload">
	</div>    
	    <br><br>
	    <input class="btn btn-primary btn-lg" type="submit" value="Upload Image" name="Upload_Image">
	</form>
</div> -->
<div class="container-fluid" id="hidediv">
	<div class="row" id="hidediv">
	    <div class="col-md-4">
	      <a href="<?php $_SESSION['destination'] = $caption[0];?>travel.php" class="thumbnail">
	        <p><?php  echo $caption[0]; ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[0] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php $_SESSION['destination'] = $caption[1];?>travel.php" class="thumbnail">
	        <p><?php echo $caption[1] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[1] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[2] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[2] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[2] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	</div>
	<div class="row" id="hidediv">
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[3] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[3] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[3] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[4] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[4] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[4] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[5] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[5] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[5] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	</div>
	<div class="row" id="hidediv">
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[6] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[6] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[6] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[7] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[7] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[7] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[8] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[8] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[8] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	</div>
	<div class="row" id="hidediv">
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[9] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[9] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[9] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[10] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[10] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[10] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[11] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[11] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[11] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	</div>
	<div class="row" id="hidediv">
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[12] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[12] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[12] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[13] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[13] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[13] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	    <div class="col-md-4">
	      <a href="<?php  echo "imagesfinal/photo_" . $photos[14] . ".jpg" ?>" class="thumbnail">
	        <p><?php echo $caption[14] ?></p>
	        <img src="<?php  echo "imagesfinal/photo_" . $photos[14] . ".jpg" ?>" class="img-responsive img-rounded" alt="Image" style="width:150px;height:150px">
	      </a>
	    </div>
	</div>

</div>
	
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

