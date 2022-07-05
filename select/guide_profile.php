<?PHP
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
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
		if(isset($_SESSION['userid'])){
			$price = chn_curr($row1['price'],$conn);
		}
		else {
			$price = "₹".number_format((float)$row1['price'], 2, '.', '');
		}
	}
	$query1 = mysqli_query($conn, "SELECT * from guides_tbl where guideid = '$guideid'");
	while ($row = $query1->fetch_assoc()) {
		$name = $row['guidename'];
		$gen = $row['gender'];
		$age = $row['age'];
		$city = $row['city'];
		$lan = $row['languages'];
		$exp = $row['experience'];
		$img = $row['image'];
	}
	$date = $_SESSION["date"];
	$succ = 0;
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$date = date("d-m-Y", strtotime($_POST['date']));
		$check = mysqli_query($conn,"SELECT available_dates from package_tbl where packageid = '$packageid' and available_dates like '%".$date."%'");
		if($check->num_rows>0){
			$succ = 2;
			$_SESSION["date"] = date("Y-m-d", strtotime($date));
		}
		else{
			$succ = 1;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pacakge Details</title>
	<style type="text/css">
		#price{
			width: 40%;
			border: 2px solid black;
			padding: 5px;
		}
		#border,.btn-success{
			font-size: 1.2rem;
		}
		#border{
			margin-left: 75px;
			margin-right: 75px;
			padding: 10px;
			border: 2px solid black;
		}
		#right{
			text-align: right;
			font-weight: bold;
			color: darkblue;
		}
		#query{
			height: 30px;
			margin-bottom: 17px;
		}
		#contact{
			color: red;
			font-size: 1.0rem;
		}
		textarea{
			width: 75%;
			height: 125px;
			margin-bottom: 15px;
		}
	</style>
</head>
<body>
	<?php include '../header.php';?>

	<nav class="container">
		<nav class="row">
			<div class="col-md-4">
				<center>
					<h3><?php echo $name ?></h3><br>
					<?php echo "<img width='250px' height='250px' src='data:image;base64,".base64_encode($img)."' style='position:relative; overflow:hidden;'>"; ?><br><br>
					<a href="./confirm.php?id=<?PHP echo $packageid; ?>">
						<button class="btn-success">Proceed to Booking</button>
					</a><br><br>
					<h4 id="price"><span style="color: red;">Price: </span><?php echo $price ?></h4>
				</center>
			</div>
			<div class="col-md-8">
				<section id="border">
					<section class="row">
						<div class="col-md-6" id="right">
							<p>Gender :</p>
							<p>Age :</p>
							<p>City :</p>
							<p>Experience :</p>
							<p>Languages Known :</p>
						</div>
						<div class="col-md-6">
							<p><?php if($gen=='m'){echo "Male";} else{echo "Female";} ?></p>
							<p><?php echo $age ?></p>
							<p><?php echo $city ?></p>
							<p><?php echo $exp ?> years +</p>
							<p><?php echo $lan ?></p>
						</div>
					</section>
				</section><br><br>
				<section id="border">
					<p>
						<span id="right">Start time: </span><?php echo $start ?> IST
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span id="right">End time: </span><?php echo $end ?> IST
					</p>
					<p><span id="right">Target Locations: &nbsp;&nbsp;</span><?php echo $target ?></p>
				</section><br><br>
				<section id="border">
					<center><u><h4>Check Available Dates</h4></u></center><br>
					<form action="" method="post">
						<section class="row">
							<div class="col-md-6">
								<p id="right">Check Available Dates: </p>
							</div>
							<div class="col-md-6">
								<input type="date" name="date" value="<?php $date = date("Y-m-d", strtotime($date)); echo $date; ?>">
							</div>
						</section>
						<center>
							<?Php if($succ==2): ?>
								<p style="color: green">Available</p>
							<?php elseif($succ==1): ?>
								<p style="color: red">Oops! Try different date</p>
							<?php else: ?>
								<br>
							<?php endif ?>
							<input type="submit" name="submit">
						</center>
					</form>
				</section><br><br>
				<section id="border">
					<center><u><h4>Any Queries?</h4></u></center><br>
					<section class="row">
						<div class="col-md-4" id="right">
							<p>Name :</p>
							<p>E-Mail :</p>
							<p>Query :</p>
						</div>
						<div class="col-md-8">
							<form action="./query.php" method="post">
								<input id="query" type="text" name="name" placeholder="Enter Your Name" required><br>
								<input id="query" type="email" name="email" placeholder="Enter Your E-Mail" required><br>
								<textarea name="query" required></textarea><br>
								<p id="contact">*We will contact you as soon as possible</p>
								<input type="submit" name="" style="margin-left: 60px;">
							</form>
						</div>
					</section>
				</section>
			</div>
		</nav>
	</nav><br><br>

	<?php include '../footer.php';?>
</body>
</html>