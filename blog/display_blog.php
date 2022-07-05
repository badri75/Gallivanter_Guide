<?PHP
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	if(isset($_GET['id'])){
	  $blogid = $_GET['id'];
	} else {
	  echo "failed";
	}

	$rs = mysqli_query($conn, "SELECT * from blog_tbl where blogid = '".$blogid."'");
	while ($row = $rs->fetch_array()) {
		$title = $row['title'];
		$blog = $row['blog'];
		$date = $row['date'];
		$userid = $row['userid'];
	}
	$datenew = date("d-m-Y",strtotime($date));

	$rs1 = mysqli_query($conn, "SELECT username from users_tbl where userid = '$userid'");
	while ($row1 = $rs1->fetch_array()) {
		$username = $row1['username'];
	}

	$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Gallivanter Guide - Blogs</title>

	<style type="text/css">
		#user {
			position: absolute;
			right: 50px;
			padding: 5px;
			border: 2px solid black;
			background-color: white;
		}
		#para {
			overflow: hidden;
			font-size: 1.1rem;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?>

	<nav class="container">
		<div>
			<center><h2><?PHP echo "$title"; ?></h2></center>
		</div><br>
		<div id="user">
			Posted by <?PHP echo "$username"; ?><br>
			<center>on <?PHP echo "$datenew"; ?></center>
		</div><br><br><br><br>
		<div id="para">
			<?PHP echo "$blog"; ?>
		</div>
	</nav>

	<?php include '../footer.php';?>
</body>
</html>
