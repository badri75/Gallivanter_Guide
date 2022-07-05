<?php
	session_start();
	if (!isset($_SESSION['guideid'])) {
		echo '<script>
	        alert("Unauthorized");
	        window.location.href="../index.php";
	      </script>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		
		.zoom{
			padding: 10px;
			background-color: #1a2b49; 
			transition: transform .2s;
			width: 200px;
			height: 200px;
			overflow: hidden;
			color: white;
		}
		.zoom:hover{
			transform: scale(1.2);
		}
		/*Footer*/
		.bottomed{
			position: fixed;
			bottom: 0px;
			right: 0px;
			left: 0px;
		}
		h3{
			margin-left: 10px;
		}
	</style>
	<title></title>
</head>

<body>
	<?php	include '../header.php';	?>

	<br><br><br>
	<section class="container">
		<section class="row">
			<div class="col-md-4">
				<center>
					<a href="./profile.php">
						<div class="zoom">						
							<i class="fa fa-user fa-8x" aria-hidden="true"></i><br>
							<h3>Profile</h3>
						</div>
					</a>
				</center>
			</div>
			<div class="col-md-4">
				<center>
					<a href="./signup.php">
						<div class="zoom">
							<i class="fa fa-folder-open fa-8x" aria-hidden="true"></i><br>
							<h3>Packages</h3>
						</div>
					</a>
				</center>
			</div>
			<div class="col-md-4">
				<center>
					<a href="">
						<div class="zoom">
							<i class="fas fa-rupee-sign fa-8x" aria-hidden="true"></i><br>
							<h3>Income</h3>
						</div>
					</a>
				</center>
			</div>
		</section>
	</section>
	<section class="bottomed">	<?php include '../footer.php';?>	</section>
</body>
</html>