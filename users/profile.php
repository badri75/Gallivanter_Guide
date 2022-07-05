<?PHP
	session_start();
	$id = $_SESSION['userid'];
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	if(isset($_SESSION['userid'])){
		$rs=mysqli_query($conn,"SELECT * from users_tbl where userid ='$id'");
		while ($row = $rs->fetch_array()) {
			$email = $row['email'];
		    $name = $row['username'];
		    $gender = $row['gender'];
		    $age = $row['age'];
			$country = $row['country'];
			$phncode = $row['phonecode'];
			$phnno = $row['phoneno'];
			$currency = $row['currency'];
			$pwd = $row['password'];
		}

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$username1 = $_POST['username'];
			$gender1 = $_POST['gender'];
			$age1 = $_POST['age'];
	//		$email1 = $_POST['email'];
			$country1 = $_POST['country'];
			$phncode1 = $_POST['phncode'];
			$phnno1 = $_POST['phnno'];
			$currency1 = $_POST['currency'];
			$pwd1 = $_POST['pwd'];

			$slctphn = "SELECT phonecode, phoneno from users_tbl where phoneno = '$phnno1' and email!='$email'";
	//		$slctemail = "SELECT email from users_tbl where email!='$email";
			$sql = "UPDATE users_tbl SET username='$username1', age='$age1', country='$country1', phonecode='$phncode1', phoneno='$phnno1', currency='$currency1', password='$pwd1' WHERE email='$email'";

			$stmt = mysqli_query($conn,$slctphn);
			$rnum = 0;
			while ($row = $stmt->fetch_array()) {
				$result1 = $row['phonecode'];
				$result2 = $row['phoneno'];
				if(($result1 == $phncode1) && ($result2 == $phnno1)) {
					$rnum = 1;
					break;
				}
			}

	/*		$stmt3 = mysqli_query($conn,$slctemail);
			$rnum3 = 0;
			while ($row = $stmt3->fetch_array()) {
				$result = $row['email'];
				if($result == $email1) {
					$rnum3 = 1;
					break;
				}
			}
	*/
			if($rnum==0) {
				if ($conn->query($sql) === TRUE) {
				  echo '<script>
			        alert("Record Updated Sucessfully");
			        window.location.href="../index.php";
			      </script>';
				} else {
				  echo "Error updating record: " . $conn->error;
				}
			} else {
				echo '<script>
			        alert("Phone Number already exists");
			        window.location.href="profile.php";
			      </script>';
			}

			$stmt->close();
		}
	} else {
		echo '<script>
	        alert("Please Login first");
	        window.location.href="../index.php";
	      </script>';
	}
?> 

<!DOCTYPE html>
<html>
<head>
	
	<title>Profile</title>

	<style>
		center{
			height: 50px;
		}
		h4{
			width: 100%;
			background-color: #1a2b49;
			padding: 8px;
			border: 1px solid black;
			color: white;
		}
		.col-md-4 p{
			text-align: right;
			margin: 13px auto 10px auto;
			font-size: 1.1rem;
		}
		.row{
			width: 100%;
		}
		.wid{
			width: 80%;
			height: 26px;
			margin-top: 15px;
		}
		#gen{
			width: 10%;
			height: 13px;
			margin-top: 17px;
		}
		#phn{
			width: 68%;
			margin-top: 10px;
			height: 26px;
		}
		#submit{
			margin: 25px 80px auto 40px!important;
			width: 100px;
			background-color: lightblue;
		}
		.cancel{
			float: right;
			position: relative;
			margin-right: 100px;
		}
		.outer{
			margin-bottom: 20px;
		}
		.inner{
			border: 2px solid black;
			padding: 10px;
		}
		#right p{
			font-size: 1.2rem;
			text-align: right;
			font-weight: bold;
			margin-bottom: 11px;
		}
		#details p{
			text-align: left;
			font-weight: normal;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?><br>

	<center><h3><u><?php echo "$name"; ?>'s Profile</u></h3></center><br>
  	<nav class="container">
  		<h4>Edit Details</h4>
  		<section class="row">
  			<div class="col-md-4">
  				<p>Name: </p>
				<p>Gender: </p>
				<p>Age: </p>
				<p>Email: </p>
				<p>Country: </p>
				<p>Mobile No: </p>
				<p>Currency: </p>
				<p>Password: </p>
  			</div>
  			<div class="col-md-6">
				<form action="" method="post">
					<div>
						<input class="wid" type="text" name="username" maxlength="20" value="<?php echo"$name" ?>">
					</div>
					<div>
						<input id="gen" type="radio" name="gender" <?php if($gender=="m"):?> checked <?php endif ?> value="m">Male
						<input id="gen" type="radio" name="gender" <?php if($gender=="f"):?> checked <?php endif ?> value="f">Female
						<input id="gen" type="radio" name="gender" <?php if($gender=="o"):?> checked <?php endif ?> value="o">Others
					</div>
					<div>
						<input class="wid" type="number" name="age" value="<?php echo"$age" ?>" min="18" max="80">
					</div>
					<div class="wid">
						<?php echo"$email" ?>
					</div>
					<div>
						<select class="wid" id="cnt" name="country">
							<option value="Aus" <?php if($country=="Aus"):?> selected <?php endif ?> >Australia</option>
							<option value="Can" <?php if($country=="Can"):?> selected <?php endif ?> >Canada</option>
							<option value="Ger" <?php if($country=="Ger"):?> selected <?php endif ?> >Germany</option>
							<option value="Ind" <?php if($country=="Ind"):?> selected <?php endif ?> >India</option>
							<option value="Mex" <?php if($country=="Mex"):?> selected <?php endif ?> >Mexico</option>
							<option value="Pak" <?php if($country=="Pak"):?> selected <?php endif ?> >Pakistan</option>
							<option value="SL" <?php if($country=="SL"):?> selected <?php endif ?> >Sri Lanka</option>
							<option value="USA" <?php if($country=="USA"):?> selected <?php endif ?> >United States of America</option>
							<option value="Zim" <?php if($country=="Zim"):?> selected <?php endif ?> >Zimbabwe</option>
						</select>
					</div>
					<div>
						<select name="phncode" required onchange="clrsugges();">
							<option value="61" <?php if($phncode=="61"):?> selected <?php endif ?> >+61</option>
							<option value="1" <?php if($phncode=="1"):?> selected <?php endif ?> >+1</option>
							<option value="49" <?php if($phncode=="49"):?> selected <?php endif ?> >+49</option>
							<option value="91" <?php if($phncode=="91"):?> selected <?php endif ?> >+91</option>
							<option value="52" <?php if($phncode=="52"):?> selected <?php endif ?> >+52</option>
							<option value="92" <?php if($phncode=="92"):?> selected <?php endif ?> >+92</option>
							<option value="94" <?php if($phncode=="94"):?> selected <?php endif ?> >+94</option>
							<option value="263" <?php if($phncode=="263"):?> selected <?php endif ?> >+263</option>
						</select>
						<input id="phn" type="tel" name="phnno" maxlength="10" pattern="\d{10}" value="<?php echo "$phnno"; ?>">
					</div>
					<span id="recom"></span>
					<div>
						<select class="wid" name="currency">
							<option value="AUD" <?php if($currency=="AUD"):?> selected <?php endif ?> >Australian Dollar (AUD)</option>
							<option value="CAD" <?php if($currency=="CAD"):?> selected <?php endif ?> >Canadian Dollar (CAD)</option>
							<option value="EUR" <?php if($currency=="EUR"):?> selected <?php endif ?> >EURO</option>
							<option value="INR" <?php if($currency=="INR"):?> selected <?php endif ?> >Indian Rupee (INR)</option>
							<option value="MXN" <?php if($currency=="MXN"):?> selected <?php endif ?> >Mexican Peso (MXN)</option>
							<option value="PKR" <?php if($currency=="PKR"):?> selected <?php endif ?> >Pakistani Rupee (PKR)</option>
							<option value="LKR" <?php if($currency=="LKR"):?> selected <?php endif ?> >Sri Lanka Rupee (LKR)</option>
							<option value="USD" <?php if($currency=="USD"):?> selected <?php endif ?> >USA Dollar (USD)</option>
							<option value="ZWD" <?php if($currency=="ZWD"):?> selected <?php endif ?> >Zimbabwe Dollar (ZWD)</option>
						</select>
					</div>
					<div>
						<input class="wid" id="pwd" type="Password" name="pwd" maxlength="25" minlength="8" value="<?php echo "$pwd"; ?>">
						<i class="far fa-eye" id="togglePassword1">  
						</i>
					</div>
					<div style="position: absolute;">
						<input id="submit" type="submit" name="update" value="Update">
					</div>
				</form>
				<div  class="cancel">
					<a href="" onclick="enable()">
						<button id="submit" name="cancel">Cancel</button>
					</a>
				</div>
  			</div>
  		</section><br>
  		<h4>Order History</h4><br>
  		<section class="row">
			<?php
				$order = $conn->query("SELECT * from orders_tbl where userid='$id'");
				while ($row2 = $order->fetch_array()) {
					$orderid = $row2['orderid'];
					$pid = $row2['packageid'];
					$date = date("d-m-Y",strtotime($row2['tour_date']));
					$lan = $row2['language'];
					$guideid = $row2['guideid'];
					$uquery = $conn->query("SELECT * from guides_tbl where guideid='$guideid' Limit 1");
					while ($row3 = $uquery->fetch_array()) {
						$guname = $row3['guidename'];
						$city = $row3['city'];
						$email3 = $row3['email'];
						$mobile = $row3['phoneno'];
					}
			?>
				<div class="col-md-6 outer">
					<section class="inner">
						<section class="row" id="right">
							<div class="col-md-6">
								<p>Orderid: </p>
								<p>Packageid: </p>
								<p>Guide Name: </p>
								<p>Travel Date: </p>
								<p>Preferred Language: </p>
								<p>Travel City: </p>
								<p>Guide's Email: </p>
								<p>Guide's Mobile No: </p>
							</div>
							<div class="col-md-6" id="details">
								<p><?php echo $orderid; ?></p>
								<p><?php echo $pid; ?></p>
								<p><?php echo $guname; ?></p>
								<p><?php echo $date; ?></p>
								<p><?php echo $lan; ?></p>
								<p><?php echo $city; ?></p>
								<p><?php echo $email3; ?></p>
								<p><?php echo $mobile; ?></p>
							</div>
						</section>
					</section>
				</div>
			<?php 	$uquery='';	}	?>
		</section>
  	</nav><br><br>

	<?php include '../footer.php';?>

  	<script>
  		const togglePassword = document.querySelector('#togglePassword1');
		const password = document.querySelector('#pwd');
		togglePassword.addEventListener('click', function (e) {
		    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		    password.setAttribute('type', type);
		    this.classList.toggle('fa-eye-slash');
		});
  	</script>
</body>
</html>
