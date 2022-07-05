<?PHP
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$guidename = $_POST['guidename'];
		$gender = $_POST['gender'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$city = $_POST['city'];
		$phnno = $_POST['phnno'];
		$lan = $_POST['languages'];
		$exp = $_POST['experience'];
		$pwd = $_POST['pwd'];
		$image = file_get_contents($_FILES['myimg']['tmp_name']);

		$conn = new mysqli('localhost','root','','gallivanter_guide');
		if($conn->connect_error) {
			die('Connection Failed : '.$conn->connect_error);
		}
		else {
			$slctmail = "SELECT email from guides_tbl where email = ? Limit 1";
			$slctphoneno = "SELECT phoneno from guides_tbl where phoneno = ? Limit 1";

			$query = "INSERT into guides_tbl (guidename, gender, age, email, city, phoneno, languages, experience, password, image) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt1 = $conn->prepare($slctmail);
			$stmt1->bind_param("s",$email);
			$stmt1->execute();
			$stmt1->bind_result($email);
			$stmt1->store_result();
			$rnum1 = $stmt1->num_rows;

			$stmt3 = $conn->prepare($slctphoneno);
			$stmt3->bind_param("i",$phnno);
			$stmt3->execute();
			$stmt3->bind_result($phnno);
			$stmt3->store_result();
			$rnum3 = $stmt3->num_rows;

			if($rnum1==0) {
				if($rnum3==0) {
					$stmt = $conn->prepare($query);
					$stmt->bind_param("ssissisiss", $guidename, $gender, $age, $email, $city, $phnno, $lan, $exp, $pwd, $image);
					$stmt->execute();
					echo '<script>
			          alert("Your account has been registred sucessfully. Please login to continue");
			          window.location.href="./login.php";
			        </script>';
					$stmt->close();
				}
				else {
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
	<title>Guide - Signup</title>
	<style type="text/css">
		.col-lg-4 p{
			text-align: right;
			font-size: 1.1rem;
			margin-bottom: 15px;
		}
		.wid{
			width: 93%;
			height: 26px;
			margin-bottom: 1rem;
		}
		#gen{
			width: 10%;
			height: 13px;
			margin-bottom: 1rem;
		}
		#war{
			font-size: 0.9rem;
			color: red;
		}
		#t-nd-c{
			margin-bottom: 1rem;
		}
		#submit{
			width: 100px;
			background-color: lightblue;
			margin-right: 55px;
			margin-left: 25px;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?>

	<center><h2>Guide Sign Up!</h2></center><br>
	<section class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-lg-7 col-md-7">
				<section class="row">
					<div class="col-lg-4 col-md-4">
						<p>Name: </p>
						<p>Gender: </p>
						<p>Age: </p>
						<p>Email: </p>
						<p>City: </p>
						<p>Mobile No: </p>
						<p>Languages Known: </p>
						<p>Experience: </p>
						<p style="margin-bottom: 27px;">Profile Photo: </p>
						<p>Password: </p>
						<p>Confirm Password: </p>
					</div>
					<div class="col-lg-8 col-md-8">
						<form action="" method="post" enctype="multipart/form-data">
							<div>
								<input class="wid" type="text" name="guidename" maxlength="20"  placeholder="Your Full Name">
							</div>
							<div>
								<input id="gen" type="radio" name="gender" value="m" required>Male
								<input id="gen" type="radio" name="gender" value="f">Female
								<input id="gen" type="radio" name="gender" value="o">Others
							</div>
							<div>
								<input class="wid" type="number" name="age"  placeholder="Your Age" min="18" max="80">
							</div>
							<div>
								<input class="wid" type="email" name="email"  placeholder="example@example.com">
							</div>
							<div>
								<input class="wid" type="text" name="city"  placeholder="Enter Your Guide City">
							</div>
							<div>
								<input class="wid" id="phn" type="tel" name="phnno" maxlength="10" pattern="\d{10}" placeholder="10 digit phone number" >
							</div>
							<div>
								<input class="wid" type="text" name="languages" maxlength="50" placeholder="Communication Languages">
							</div>
							<div>
								<input class="wid" type="number" name="experience"  placeholder="Your Experience as a Guide" max="40" min="1">
							</div>
							<div>
								<input type="file" id="file" name="myimg" accept="image/*"><br>
								<span id="war">*Upload a file size in between 50 kb and 200kb</span>
							</div>
							<div>
								<input class="wid" id="pwd" type="Password" name="pwd"  placeholder="Create new password (minimum 8 characters)" maxlength="25" minlength="8">
								<i class="far fa-eye" id="togglePassword1"></i>
							</div>
							<div>
								<input class="wid" id="confirm-pwd" type="Password" name="confirm-pwd"  placeholder="Re-enter the same password as above" maxlength="25" onkeyup='check();'>
							</div>
							<span id="message"></span>
							<div id="t-nd-c">
								<input type="checkbox" name="t-nd-c" >&nbsp;&nbsp;I agree to the <a href=""><u>Terms of Use</u></a> and <a href=""><u>Privacy Policy</u></a>
							</div>
							<div>
								<input id="submit" type="submit" name="submit" value="Sign Up">
								<a href=""><u>Learn More</u></a>
							</div>
						</form>
					</div>
				</section>
			</div>
		</div>
	</section><br><br>

	<?php include '../footer.php';?>

	<script type="text/javascript">
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

		var uploadField = document.getElementById("file");
		uploadField.onchange = function() {
		    if ((this.files[0].size/1024/1024) > 0.2) {
		       alert("Can't choose. File is too Big");
		       this.value = "";
		    }
		    else if ((this.files[0].size/1024/1024) < 0.05) {
		    	alert("Can't choose. File is too Small");
		    	this.value = "";
		    };
		};
	</script>
</body>
</html>