<?php
session_start();

include_once 'dbconnect.php';

//check if form is submitted

    $user_id = $_SESSION['usr_id'];
    $user_name = $_SESSION['usr_name'];
    $user_email = $_SESSION['usr_email'];
    $user_pref1 = $_SESSION['usr_pref1'];
    $user_pref2 = $_SESSION['usr_pref2'];
    $user_location = $_SESSION['usr_location'];
    

?>

<!DOCTYPE html>
<html>
<head>
    <title>MyProfile</title>
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
                <a class="navbar-brand" href="index.php">Tourism Recomendation System</a>
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

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 well">
                <form role="form" action="editprofile.php" method="post" name="profileform">
                    <fieldset>
                        <legend>Profile</legend>

                        <div class="form-group">
                            <label for="name" style="padding: 10px">Username</label>
                            <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_name; ?></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="name" style="padding: 10px">Email</label>
                            <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_email; ?></p>
                        </div>

                        <div class="form-group">
                            <label for="name" style="padding: 10px">Preference 1</label>
                            <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_pref1; ?></p>
                        </div>

                        <div class="form-group">
                            <label for="name" style="padding: 10px">Preference 2</label>
                            <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_pref2; ?></p>
                        </div>

                        <div class="form-group">
                            <label for="name" style="padding: 10px">Location</label>
                            <p class="form-control-static" style="display:inline; margin-left: 15%"><?php echo $user_location; ?></p>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="editprofile" value="Edit Profile" class="btn btn-primary" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>