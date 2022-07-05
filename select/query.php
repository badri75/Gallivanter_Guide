<?php
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$cnt1 = 0;
		$cnt2 = 0;
		$query = $conn->real_escape_string($_POST['query']);
		
		if ((isset($_POST['city'])) && (isset($_POST['mobile']))) {
			$city = $_POST['city'];
			$mobile = $_POST['mobile'];
			$sql2 = mysqli_query($conn, "INSERT into queries_tbl (name,email,city,phoneno,queries) values ('".$name."','".$email."','".$city."','".$mobile."','".$query."')");
			if($sql2) {
				echo '<script>
					alert("We received your Query.");
			        window.location.href="../index.php";
			      </script>';
			}
			else{
				echo ("Oops! ".$conn->error);
			}
		}
		else{
			$sql1 = mysqli_query($conn, "INSERT into queries_tbl (name,email,queries) values('".$name."','".$email."','".$query."')");
			if ($sql1) {
				echo '<script>
					alert("We received your Query.");
			        window.location.href="../index.php";
			      </script>';
			}
		}
	}
?>