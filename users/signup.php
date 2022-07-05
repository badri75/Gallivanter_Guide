<?PHP
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST['username'];
		$gender = $_POST['gender'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$country = $_POST['country'];
		$phncode = $_POST['phncode'];
		$phnno = $_POST['phnno'];
		$currency = $_POST['currency'];
		$pwd = $_POST['pwd'];

		$conn = new mysqli('localhost','root','','gallivanter_guide');
		if($conn->connect_error) {
			die('Connection Failed : '.$conn->connect_error);
		}
		else {
			$slctmail = "SELECT email from users_tbl where email = ? Limit 1";
			$slctphncode = "SELECT phonecode from users_tbl where phoneno = '$phnno'";
			$slctphoneno = "SELECT phoneno from users_tbl where phoneno = ? Limit 1";

			$insert = "INSERT into users_tbl (username, gender, age, email, country, phonecode, phoneno, currency, password) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt1 = $conn->prepare($slctmail);
			$stmt1->bind_param("s",$email);
			$stmt1->execute();
			$stmt1->bind_result($email);
			$stmt1->store_result();
			$rnum1 = $stmt1->num_rows;

			$stmt2 = mysqli_query($conn,$slctphncode);
			$rnum2 = 0;
			while ($row = $stmt2->fetch_array()) {
				$result = $row['phonecode'];
				if($result == $phncode) {
					$rnum2 = 1;
					break;
				}
			}

			$stmt3 = $conn->prepare($slctphoneno);
			$stmt3->bind_param("i",$phnno);
			$stmt3->execute();
			$stmt3->bind_result($phnno);
			$stmt3->store_result();
			$rnum3 = $stmt3->num_rows;

			if($rnum1==0) {
				if(($rnum2==0) || ($rnum3==0)) {
					$stmt = $conn->prepare($insert);
					$stmt->bind_param("ssissiiss", $username, $gender, $age, $email, $country, $phncode, $phnno, $currency, $pwd);
					$stmt->execute();
	//				echo "success $rnum2 $rnum3";
					echo '<script>
			          alert("Your account has been registred sucessfully. Please login to continue");
			          window.location.href="../index.php";
			        </script>';
					$stmt->close();
				}
				else {
	//				echo "failed $rnum2 $rnum3";
					echo '<script>
			          alert("Someone have already registered using this Phone Number. Please try again");
			          window.location.href="./signup.php";
			        </script>';
				}
			}
			else{
				echo '<script>
			          alert("Someone have already registered using this e-mail. Please try again");
			          window.location.href="./signup.php";
			        </script>';
			}

			$stmt3->close();
			$stmt2->close();
			$stmt1->close();
			$conn->close();
		}
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
	<title>Gallivanter Guide - Signup</title>

	<style>
		body{
			background-image: url("../images/signup/bg2.jpg");
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;

		}
		h2{
			margin-top:50px !important;
		}
		.row{
			width: 100%;
		}
		.col-lg-6{
			border: 2px solid black;
			padding: 10px;
			margin-bottom: 10px;
			background-color: white;
			opacity: .8;
		}
		.col-lg-6 section{
			opacity: 1;
		}
		.col-lg-4 p{
			text-align: right;
			margin: 10px auto 10px auto;
			font-size: 1.1rem;
		}
		.wid{
			width: 80%;
			height: 26px;
			margin-top: 10px;
		}
		#gen{
			width: 10%;
			height: 13px;
			margin-top: 17px;
		}
		#phn{
			width: 65%;
			margin-top: 10px;
			height: 26px;
		}
		#t-nd-c{
			margin-top: 15px;
			margin-bottom: 10px;
		}
		#submit{
			width: 100px;
			background-color: lightblue;
			margin-right: 15px;
			margin-left: 25px;
		}
		#login{
			color: black;
		}
	</style>
</head>

<body>
	<div>
		<center><h2><u>Join with 1 Million+ Family</u></h2><br></center>
		<section class="row">
			<div class="col-lg-3 col-md-3"></div>
			<div class="col-lg-6 col-md-6">
				<section class="row">
					<div class="col-lg-4 col-md-4">
						<p>Name: </p>
						<p>Gender: </p>
						<p>Age: </p>
						<p>Email: </p>
						<p>Country: </p>
						<p>Mobile No: </p>
						<p>Currency: </p>
						<p>Password: </p>
						<p>Confirm Password: </p>
					</div>
					<div class="col-lg-8 col-md-8">
						<form action="" method="post">
							<div>
								<input class="wid" type="text" name="username" maxlength="20" required placeholder="Your Full Name">
							</div>
							<div>
								<input id="gen" type="radio" name="gender" value="m" required>Male
								<input id="gen" type="radio" name="gender" value="f">Female
								<input id="gen" type="radio" name="gender" value="o">Others
							</div>
							<div>
								<input class="wid" type="number" name="age" required placeholder="Your Age" min="18" max="80">
							</div>
							<div>
								<input class="wid" type="email" name="email" required placeholder="example@example.com">
							</div>
							<div>
								<select class="wid" id="cnt" name="country" required onchange="sugges();">
									<option value="Aus">Australia</option>
									<option value="Can">Canada</option>
									<option value="Ger">Germany</option>
									<option value="Ind" selected>India</option>
									<option value="Mex">Mexico</option>
									<option value="Pak">Pakistan</option>
									<option value="SL">Sri Lanka</option>
									<option value="USA">United States of America</option>
									<option value="Zim">Zimbabwe</option>
								</select>
							</div>
							<div>
								<select name="phncode" required onchange="clrsugges();">
									<option value="61">+61</option>
									<option value="1">+1</option>
									<option value="49">+49</option>
									<option value="91" selected>+91</option>
									<option value="52">+52</option>
									<option value="92">+92</option>
									<option value="94">+94</option>
									<option value="263">+263</option>
								</select>
								<input id="phn" type="tel" name="phnno" maxlength="10" pattern="\d{10}" placeholder="10 digit phone number" required>
							</div>
							<span id="recom"></span>
							<div>
								<select class="wid" name="currency">
									<option value="AUD">Australian Dollar (AUD)</option>
									<option value="CAD">Canadian Dollar (CAD)</option>
									<option value="EUR">EURO</option>
									<option value="INR" selected>Indian Rupee (INR)</option>
									<option value="MXN">Mexican Peso (MXN)</option>
									<option value="PKR">Pakistani Rupee (PKR)</option>
									<option value="LKR">Sri Lanka Rupee (LKR)</option>
									<option value="USD">USA Dollar (USD)</option>
									<option value="ZWD">Zimbabwe Dollar (ZWD)</option>
								</select>
							</div>
							<div>
								<input class="wid" id="pwd" type="Password" name="pwd" required placeholder="Create new password (minimum 8 characters)" maxlength="25" minlength="8">
								<i class="far fa-eye" id="togglePassword1"></i>
							</div>
							<div>
								<input class="wid" id="confirm-pwd" type="Password" name="confirm-pwd" required placeholder="Re-enter the same password as above" maxlength="25" onkeyup='check();'>
							</div>
							<span id="message"></span>
							<div id="t-nd-c">
								<input type="checkbox" name="t-nd-c" required>&nbsp;&nbsp;I agree to the <a href=""><u>Terms of Use</u></a> and <a href=""><u>Privacy Policy</u></a>
							</div>
							<div>
								<input id="submit" type="submit" name="submit" value="Sign Up">
								<a href=""><u>Learn More</u></a>
							</div>
						</form>
					</div>
				</section>
			</div>
		</section>
		<center><a id="login" href="../index.php"><u>Already have an Account? Login here</u></a></center>
	</div>

	<script>
	//Password Validation      
	    var check = function() {
		  if (document.getElementById('pwd').value != document.getElementById('confirm-pwd').value){
		    document.getElementById('message').style.color = 'red';
		    document.getElementById('message').innerHTML = 'Passwords not Matching';
		    document.getElementById("submit").disabled = true;
		  }
		  else{
		  	document.getElementById('message').innerHTML = '';
		  	document.getElementById("submit").disabled = false;
		  }
		}

	//Password Visibility
		const togglePassword = document.querySelector('#togglePassword1');
		const password = document.querySelector('#pwd');
		togglePassword.addEventListener('click', function (e) {
		    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		    password.setAttribute('type', type);
		    this.classList.toggle('fa-eye-slash');
		});

	//Country Code Recommendation
		function sugges() {
		  var mylist = document.getElementById("cnt");
		  var mylist2 = mylist.options[mylist.selectedIndex].text;
		  document.getElementById('recom').style.color = 'red';
		  if(mylist2 == "Australia") {
		  	document.getElementById('recom').innerHTML = "Country code for Australia: +61";
		  } else if(mylist2 == "Canada") {
		  	document.getElementById('recom').innerHTML = "Country code for Canada: +1";
		  } else if(mylist2 == "Germany") {
		  	document.getElementById('recom').innerHTML = "Country code for Germany: +49";
		  }	else if(mylist2 == "Mexico") {
		  	document.getElementById('recom').innerHTML = "Country code for Mexico: +52";
		  }	else if(mylist2 == "India") {
		  	document.getElementById('recom').innerHTML = "";
		  } else if(mylist2 == "Pakistan") {
		  	document.getElementById('recom').innerHTML = "Country code for Pakistan: +92";
		  } else if(mylist2 == "Sri Lanka") {
		  	document.getElementById('recom').innerHTML = "Country code for Sri Lanka: +94";
		  }	else if(mylist2 == "United States of America") {
		  	document.getElementById('recom').innerHTML = "Country code for USA: +1";
		  }	else if(mylist2 == "Zimbabwe") {
		  	document.getElementById('recom').innerHTML = "Country code for Zimbabwe: +263";
		  }
		}
	//Clear Suggestion
		function clrsugges(){
			document.getElementById('recom').innerHTML = '';
		}
		
    </script>
</body>
</html>