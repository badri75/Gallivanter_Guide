<?PHP
	session_start();
	if (!isset($_SESSION['guideid'])) {
		echo '<script>
			alert("Login First");
	        window.location.href="../index.php";
	      </script>';
	}
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error) {
		die('Connection Failed : '.$conn->connect_error);
	}
	else{
		$id = $_SESSION['guideid'];
		$guide = mysqli_query($conn, "SELECT * from guides_tbl where guideid='$id'");

		while ($row = $guide->fetch_array()) {
			$img = $row['image'];
			$name = $row['guidename'];
			$gender = $row['gender'];
			$age = $row['age'];
			$email = $row['email'];
			$city = $row['city'];
			$languages = $row['languages'];
			$phnno = $row['phoneno'];
			$exp = $row['experience'];
		}

		if($gender=="m"){
			$gender="Male";
		}
		elseif($gender=="f"){
			$gender="Female";
		}

		if($_SERVER["REQUEST_METHOD"] == "POST") {
				$price = $_POST['price'];
				$days = $_POST['days'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$target = $conn->real_escape_string($_POST['target']);

				$insert = $conn->query("INSERT into package_tbl (guideid, price, days, starttime, endtime, target_loc) values('".$id."','".$price."','".$days."','".$start."','".$end."','".$target."')");
				if($insert) {
					echo '<script>
						alert("Successfully Added");
				        window.location.href="./profile.php";
				      </script>';
				}
				else{
					echo ("Oops! ".$conn->error);
				}
		}
		$package = mysqli_query($conn, "SELECT * from package_tbl where guideid='$id'");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Guide Profile</title>
	<style type="text/css">
		h4, .package{
			width: 100%;
			background-color: #1a2b49;
			padding: 8px;
			border: 1px solid black;
			color: white;
		}
		h5{
			margin-bottom: 0px!important;
		}
		.image{
			margin-left: 25px;
		}
		.col-md-6 p{
			font-size: 1.2rem;
			text-align: right;
			font-weight: bold;
			margin-bottom: 11px;
		}
		.col-md-4 p{
			margin-bottom: 17px;
		}
		#details p{
			text-align: left;
			font-weight: normal;
		}
		.col-md-8 input{
			margin-bottom: 15px;
		}
		textarea{
			width: 80%;
			height: 75px;
		}
		#edit{
			float: right;
    		position: relative;
    		bottom: 27px;
    		right: 8px;
    		border: 2px solid black;
			background-color: red;
			color: black;			
			border-radius: 20px;
			padding: 0.1rem 0.6rem!important;
			opacity: 0.8;
		}
		#note p{
			text-align: center;
			color: red;
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

	<center><h2>Guide Profile</h2></center><br>
	<section class="container">
		<h4>Profile</h4><br>
		<section class="row">
			<div class="col-md-4">
				<div class="image">
					<?PHP
						echo "<img width='300px' height='300px' src='data:image;base64,".base64_encode($img)."' style='position:relative; overflow:hidden;'>";
					?>
				</div>
			</div>
			<div class="col-md-6">
				<section class="row" display="none">
					<div class="col-md-6">
						<p>Name: </p>
						<p>Gender: </p>
						<p>Age: </p>
						<p>Email: </p>
						<p>City: </p>
						<p>Languages known: </p>
						<p>Mobile No: </p>
						<p>Experience: </p>
					</div>
					<div class="col-md-6" id="details">
						<p><?PHP echo $name; ?></p>
						<p><?PHP echo $gender; ?></p>
						<p><?PHP echo $age; ?></p>
						<p><?PHP echo $email; ?></p>
						<p><?PHP echo $city; ?></p>
						<p><?php echo $languages; ?></p>
						<p><?PHP echo $phnno; ?></p>
						<p><?PHP echo $exp; ?></p>
					</div>
				</section>
			</div>
		</section><br>

		<h4>Packages</h4><br>
		<section class="row">
			<div class="col-md-6">
				<center><h3>New Package</h3></center><br>
				<center><button onclick="show()">+ Create new Package</button></center><br>
				<section  id="create" style="display: none;">
					<section class="row">
						<div class="col-md-4">
							<p>Price:</p>
							<p>Days:</p>
							<p>Start Time:</p>
							<p>End Time:</p>
							<p>Target Locations:</p>
						</div>
						<div class="col-md-8">
							<form action="" method="post">
								<input type="number" name="price" min="99" max="99999" required><br>
								<input type="number" name="days" min="1" max="7" required><br>
								<input type="time" name="start" required><br>
								<input type="time" name="end" required><br>
								<textarea name="target" required maxlength="500" id="auto"></textarea><br><br>
								<input type="submit" name="sumbit"><br>
							</form>							
						</div>
					</section>
					<center><span><strong>Note: </strong>Please input the right spelling</span></center>
				</section>
			</div>
			<div class="col-md-6">
				<center><h3>Existing Packages</h3></center><br>
				<?PHP
					if($package){
						while ($row1 = $package->fetch_array()) {
				?>
				<div class="package">
					<h5>Package id: <?PHP echo $row1['packageid']; ?></h5>
					<span id="edit">
						<a style="color: white;" href="./edit_packages.php?id=<?PHP echo $row1['packageid']; ?>">Edit</a>
					</span>
				</div>
				<section class="row">
					<div class="col-md-6">
						<p>Price:</p>
						<p>Days:</p>
						<p>Start Time:</p>
						<p>End Time:</p>
						<p>Target Locations:</p>
					</div>
					<div class="col-md-6" id="details">
						<p><?PHP echo $row1['price']; ?></p>
						<p><?PHP echo $row1['days']; ?></p>
						<p><?PHP echo $row1['starttime']; ?></p>
						<p><?PHP echo $row1['endtime']; ?></p>
						<p><?PHP echo $row1['target_loc']; ?></p>
					</div>
				</section>
				<div id="note"><p>*To add available dates press 'Edit' button</p></div>
				<?PHP
					}	}
				?>
			</div>
		</section><br>

		<h4>Orders</h4><br>
		<section class="row">
			<?php
				$order =  $conn->query("SELECT * from orders_tbl where guideid='$id' ORDER BY tour_date");
				while ($row2 = $order->fetch_array()) {
					$orderid = $row2['orderid'];
					$pid = $row2['packageid'];
					$date = date("d-m-Y",strtotime($row2['tour_date']));
					$lan = $row2['language'];
					$userid = $row2['userid'];
					$uquery = $conn->query("SELECT * from users_tbl where userid='$userid' Limit 1");
					while ($row3 = $uquery->fetch_array()) {
						$uname = $row3['username'];
						$age = $row3['age'];
						$country = $row3['country'];
					}
			?>
				<div class="col-md-6 outer" id="left">
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
	</section>

	<br><br><?php include '../footer.php';?>

	<script type="text/javascript">
		function show(){
			var x = document.getElementById("create");
			if(x.style.display === "none"){
				x.style.display = "block";
			}
			else{
				x.style.display = "none";
			}
		};

		textarea = document.querySelector("#auto");
		textarea.addEventListener('input', autoResize, false);
		function autoResize() {
			this.style.height = 'auto';
			this.style.height = this.scrollHeight + 'px';
		}

	</script>
</body>
</html>