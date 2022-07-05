<?PHP
	session_start();
	if(isset($_SESSION['userid'])) {
	 	session_destroy();
    	unset($_SESSION['userid']);
    }elseif(isset($_SESSION['guideid'])){
    	session_destroy();
    	unset($_SESSION['guideid']);
    }

    if(isset($_SESSION['adminid'])){
	    header("location: ./admin.php");
	}

    $conn = mysqli_connect("localhost","root","","gallivanter_guide");
	if (mysqli_connect_errno()){
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$adminid = $_POST['uname'];
    	$pwd = $_POST['password'];

    	$rs=mysqli_query($conn,"SELECT * from admin_tbl where adminid ='$adminid'");

	    if(mysqli_num_rows($rs)<1) {
			echo '<script>
				alert("Invalid email. Try again");
				window.location.href="login.php";
			</script>';
			session_destroy();
	    }
	    else {
	    	while ($row = $rs->fetch_array()) {
	    		$pwd1 = $row['password'];
	    	}
	    	if($pwd!=$pwd1) {
	    		echo '<script>
					alert("Invalid Password. Try again");
					window.location.href="login.php";
				</script>';
		    	session_destroy();
			}
			else {
        		$_SESSION["adminid"]=$adminid; 
				echo "<script>
					alert('Welcome $adminid');
					window.location.href='./admin.php';
				</script>";
			}
	    }
	}
?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.bottomed{
			position: fixed;
			bottom: 0px;
			right: 0px;
			left: 0px;
		}
		.col-md-6 p{
			text-align: right;
			font-size: 1.1rem;
			padding-top: 5px;
			margin-bottom: 25px;
		}
		.btn{
			margin-left: 35px;
		}
		.note{
			width: 100%;
			text-align: center;
		}
	</style>
	<title></title>
</head>

<body>
	<?php include '../header.php';?>

	<br><center><h2><u>Login to Continue</u></h2></center><br>
	<section class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-lg-6 col-md-6">
				<section class="row">
					<div class="col-md-4">
						<p>Username :</p>
						<p>Password :</p>
					</div>
					<div class="col-lg-6">
						<form action="" method="post">
							<div class="form-group">
								<input type="text" name="uname"  class="form-control" placeholder="Enter Username" required>
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password" id="pwd" maxlength ="25" required>
								<i class="far fa-eye" id="togglePassword1" style="
									float: right;
								    position: relative;
								    margin-top: -25px;
								    margin-right: 7px;	">
								</i>
								<a href=""><p>Forgot Password?</p></a>
							</div>
							<div class="col-lg-12 col-sm-12 col-12">
								<button type="submit" class="btn btn-success col-4">Login</button>
							</div>
						</form>
					</div>
					<div class="note">
						<p style="text-align: center;"><b>Note:</b> This page is only for Admins.<br>
						If you're an User or Guide, please <a href="../index.php">login here.</a></p>
					</div>
				</section>
			</div>
		</div>
	</section>

	<section class="bottomed">	<?php include '../footer.php';?>	</section>

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