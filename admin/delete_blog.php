<?php 
	session_start();
	$conn = mysqli_connect("localhost","root","","gallivanter_guide");
	if (mysqli_connect_errno()){
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if(!isset($_SESSION['adminid'])){
		echo '<script>
	        alert("Unauthorized");
	        window.location.href="../index.php";
	      </script>';
	}
	else{
		if(isset($_GET['id'])) {
			$blogid = $_GET['id'];
			$del = $conn->query("DELETE FROM blog_tbl where blogid = '$blogid'");
			if($del === TRUE){
				echo '<script>
			        alert("Deleted Successfully");
			        window.location.href="../index.php";
			      </script>';
			}
			else{
				echo "Failed";
			}
		}
	}
?>