<?php
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
	else{
		$userid = $_SESSION['userid'];
		$packageid = $_GET['id'];
		$or_date = $_SESSION['date'];
		$lang = $_SESSION["lang"];

		$guide = $conn->query("SELECT guideid from package_tbl where packageid='$packageid'");
		while ($row = $guide->fetch_array()) {
			$guideid =  $row['guideid'];
		}

		$gcheck = $conn->query("SELECT tour_date from orders_tbl where tour_date like '%$or_date%' and guideid='$guideid' Limit 1");
		$ucheck = $conn->query("SELECT tour_date from orders_tbl where tour_date like '%$or_date%' and userid='$userid' Limit 1");

		if((mysqli_num_rows($gcheck)>0)||(mysqli_num_rows($ucheck)>0)){
			echo '<script>
				alert("Oops Try Different date");
				window.history.back();
		      </script>';
		}
		else{
			$insert = $conn->query("INSERT into orders_tbl (userid, guideid, packageid, tour_date, language, order_time) values('".$userid."','".$guideid."','".$packageid."','".$or_date."','".$lang."',NOW())");

			if($insert){
				echo '<script>
					alert("Order Successfull");
			        window.location.href="../index.php";
			      </script>';
			}
		}
	}
?>