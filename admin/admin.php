<?php
	session_start();

	$conn = mysqli_connect("localhost","root","","gallivanter_guide");
	if (mysqli_connect_errno()){
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<style type="text/css">
		h4{
			width: 100%;
			background-color: #1a2b49;
			padding: 8px;
			border: 1px solid black;
			color: white;
		}
		.size{
			font-size: 1.2rem;
		}
		#edit{
    		border: 2px solid black;
			background-color: darkgreen;
			color: black;			
			border-radius: 20px;
			padding: 0.1rem 0.6rem!important;
			opacity: 0.8;
		}
		.outer{
			margin-bottom: 20px;
		}
		.inner{
			border: 2px solid black;
			padding: 10px;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?>

	<nav class="container">
		<center><h2>Admin Panel</h2></center><br>
		<h4>Edit Blogs</h4>
		<?php
			$blog = $conn->query("SELECT * FROM blog_tbl");
			while ($row = $blog->fetch_array()) {
		?>
		<section class=row>
			<div class="col-md-4">
				<p class="size">
					<?php	echo $row['blogid'].". ".$row['title'];	?>
				</p>
			</div>
			<div class="col-md-4">
				<span id="edit" style="padding-right: 5px!important;">
					<a style="color: white;" href="../blog/write_blog.php?id=<?PHP echo $row['blogid']; ?>">Edit</a>
				</span>&nbsp;&nbsp;&nbsp;
				<span id="edit" style="background-color: darkblue; padding-right: 5px!important;">
					<a style="color: white;" href="../blog/display_blog.php?id=<?PHP echo $row['blogid']; ?>">View</a>
				</span>&nbsp;&nbsp;&nbsp;
				<span id="edit" style="background-color: red;">
					<a style="color: white;" href="./delete_blog.php?id=<?PHP echo $row['blogid']; ?>">Delete</a>
				</span>
			</div>
		</section>
		<?php	}	?>
		<br>

		<h4>Edit Guides & Packages</h4>
		<?php
			$guides = $conn->query("SELECT * from guides_tbl");
			while ($row1 = $guides->fetch_array()) {
				$gid = $row1['guideid'];
		?>
			<p class="size">
				<?php echo $gid.". ".$row1['guidename']; ?>
			</p>
			<?php
				$packages = $conn->query("SELECT * from package_tbl where guideid = $gid");
				while ($row2 = $packages->fetch_array()){
			?>
			<nav class="row">
				<div class="col-md-1"></div>
				<div class="col-md-2">
					<p><?php echo $row2['packageid'].") ".$row2['price'] ?></p>
				</div>
				<div class="col-md-3">
					<span id="edit" style="padding-right: 5px!important;">
						<a style="color: white;" href="../guides/edit_packages.php?id=<?PHP echo $row2['packageid']; ?>">Edit</a>
					</span>&nbsp;&nbsp;&nbsp;
					<span id="edit" style="background-color: red;">
						<a style="color: white;" href="./delete_packages.php?id=<?PHP echo $row2['packageid']; ?>">Delete</a>
					</span>
				</div>
			</nav>
		<?php }	} ?><br>

		<h4>Order Summary</h4>
		<section class="row">
			<?php
				$order =  $conn->query("SELECT * from orders_tbl ORDER BY tour_date");
				while ($row2 = $order->fetch_array()) {
					$orderid = $row2['orderid'];
					$pid = $row2['packageid'];
					$date = $row2['tour_date'];
					$lan = $row2['language'];
					$userid = $row2['userid'];
					$uquery = $conn->query("SELECT * from users_tbl where userid='$userid' Limit 1");
					while ($row3 = $uquery->fetch_array()) {
						$uname = $row3['username'];
						$age = $row3['age'];
						$country = $row3['country'];
					}
			?>
				<div class="col-md-6 outer size">
					<section class="inner">
						<section class="row">
							<div class="col-md-6">
								<p>Orderid: </p>
								<p>Packageid: </p>
								<p>Date: </p>
								<p>Preferred Language: </p>
								<p>Customer Name: </p>
								<p>Customer Age: </p>
								<p>Customer Country: </p>
							</div>
							<div class="col-md-6" id="details">
								<p><?php echo $orderid; ?></p>
								<p><?php echo $pid; ?></p>
								<p><?php echo $date; ?></p>
								<p><?php echo $lan; ?></p>
								<p><?php echo $uname; ?></p>
								<p><?php echo $age; ?></p>
								<p><?php echo $country; ?></p>
							</div>
						</section>
					</section>
				</div>
			<?php 	$uquery='';	}	?>
		</section>
	</nav>

	<?php include '../footer.php';?>
</body>
</html>