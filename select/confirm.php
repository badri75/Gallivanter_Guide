<?PHP
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	if (!isset($_SESSION['userid'])) {
		echo '<script>
			alert("Login First");
	        window.location.href="../index.php";
	      </script>';
	}

	if(isset($_GET['id'])){
	  $packageid = $_GET['id'];
	} else {
	  echo "failed";
	}

	if (isset($_SESSION['userid'])) {
		function chn_curr($price,$conn){
			$uid = $_SESSION['userid'];
			$sel_curr = mysqli_query($conn, "SELECT currency FROM users_tbl where userid = '$uid'");
			while ($set = $sel_curr->fetch_array()) {
				$curr = $set['currency'];
			}
			if($curr == 'INR'){
				return "₹".number_format((float)$price, 2, '.', '');
			}
			elseif($curr == 'USD'){
				return "$".number_format((float)$price*0.014, 2, '.', '');
			}
			elseif($curr == 'EUR'){
				return "€".number_format((float)$price*0.011, 2, '.', '');
			}
		}
	}

	$query = mysqli_query($conn, "SELECT * from package_tbl where packageid = '$packageid'");
	while ($row1 = $query->fetch_assoc()) {
		$guideid = $row1['guideid'];
		$start = $row1['starttime'];
		$end = $row1['endtime'];
		$target = $row1['target_loc'];
		$days = $row1['days'];
		if(isset($_SESSION['userid']))	{
			$price = chn_curr($row1['price'],$conn);
		}
		else {
			$price = "₹".number_format((float)$row1['price'], 2, '.', '');
		}
	}

	$query1 = mysqli_query($conn, "SELECT * from guides_tbl where guideid = '$guideid'");
	while ($row = $query1->fetch_assoc()) {
		$name = $row['guidename'];
		$city = $row['city'];
		$img = $row['image'];
	}
	$date = date("Y-m-d", strtotime($_SESSION['date']));
	$date1 = date("d-m-Y", strtotime($_SESSION['date']));
	for ($i=1; $i < $days; $i++) { 
		$date1 = $date1.', '.date('d-m-Y', strtotime($date. ' + '.$i.' days'));
		$date = $date.','.date('Y-m-d', strtotime($date. ' + '.$i.' days'));
	}
	$_SESSION['date'] = $date;
	$lang = $_SESSION["lang"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Confirm your Booking</title>
	<style type="text/css">
		#price{
			width: 40%;
			border: 2px solid black;
			padding: 5px;
		}
		#border{
			margin-left: 75px;
			margin-right: 75px;
			padding: 10px;
			border: 2px solid black;
			font-size: 1.2rem;
		}
		#right{
			text-align: right;
			font-weight: bold;
			color: darkblue;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?>

	<nav class="container">
		<center><h3><u>Confirm Your Booking</u></h3></center><br>
		<nav class="row">
			<div class="col-md-4">
				<center>
					<h3><?php echo $name ?></h3><br>
					<?php echo "<img width='250px' height='250px' src='data:image;base64,".base64_encode($img)."' style='position:relative; overflow:hidden;'>"; ?><br><br>
					<h4 id="price"><span style="color: red;">Price: </span><?php echo $price ?></h4>
				</center>
			</div>
			<div class="col-md-8">
				<section id="border">
					<section class="row">
						<div class="col-md-5" id="right">
							<p>City :</p>
							<p>Language :</p>
							<p>Days :</p>
							<p>Start Time :</p>
							<p>End Time :</p>
							<p>Date :</p>
							<p>Target Locations :</p>
						</div>
						<div class="col-md-7">
							<p><?php echo $city; ?></p>
							<p><?php echo $lang; ?></p>
							<p><?php echo $days; ?></p>
							<p><?php echo $start; ?></p>
							<p><?php echo $end; ?></p>
							<p><?php echo $date1; ?></p>
							<p><?php echo $target; ?></p>
						</div>
					</section>
				</section><br>
			</div>
		</nav><br>
		<center>
			<a href="./order.php?id=<?PHP echo $packageid; ?>">
			<button class="btn-success" style="font-size: 1.2rem;">Book Now</button>
			</a>
		</center>
	</nav><br><br>

	<?php include '../footer.php';?>
</body>
</html>