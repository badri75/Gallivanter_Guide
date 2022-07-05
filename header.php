<?PHP
	if (isset($_GET['logout'])) { 
		session_start();
	    session_destroy();
	    if(isset($_SESSION['userid'])) {
	    	unset($_SESSION['userid']);
	    }elseif (isset($_SESSION['guideid'])) {
	     	unset($_SESSION['guideid']);
	    }elseif(isset($_SESSION['adminid'])){
	    	unset($_SESSION['adminid']);
	    }

	    if((isset($_SESSION["date"]))&&(isset($_SESSION["lang"]))&&(isset($_SESSION["search"]))){
		    	unset($_SESSION['search']);
		    	unset($_SESSION["date"]);
		    	unset($_SESSION["lang"]);
	    }
	    header("location: index.php"); 
	} 
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/230e68782e.js" crossorigin="anonymous"></script>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<style type="text/css">
		.navbar{
			background-color: #1a2b49;
		}
		.nav-link{
			color: white;
		}
		#login-btn{
			border: 2px solid black;
			background-color: #F44336;
			color: solid black;
			border-radius: 20px;
			padding: 0.2rem 1rem!important;
			line-height: 30px;
		}
		#login-btn:hover{
			color: black;
		}
		.trigger-btn{
			margin-left: 0px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-inner">
		<a class="navbar-brand" href="../index.php">Gallivanter Guide</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="../index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../blog/select_blog.php">Blog</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Help</a>
				</li>
				<li class="nav-item">
					<?php  if (isset($_SESSION['userid'])) : ?>
						<a class="nav-link" href="../users/profile.php">Profile&nbsp;</a>
					<?php elseif(isset($_SESSION['guideid'])):?>
						<a class="nav-link" href="../guides/profile.php">Profile&nbsp;</a>
					<?php else:?>
						<a class="nav-link" href="../users/signup.php">Sign Up</a>
					<?php endif ?> 
				</li>
				<li class="nav-item">
					<?php  if ((isset($_SESSION['userid']))||(isset($_SESSION['guideid']))||(isset($_SESSION['adminid']))) : ?>
						<a class="nav-link btn btn-danger trigger-btn" id="login-btn" href="../header.php?logout='1'">
							Logout
						</a>
					<?php else:?>
						<a class="nav-link btn btn-danger trigger-btn" id="login-btn" href="../index.php">
							Login
						</a>
					<?php endif ?> 
				</li>
    		</ul>
  		</div>
  	</nav><br>
</body>
</html>