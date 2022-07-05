<?PHP
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	$city = $_SESSION['search'];
	$date = $_SESSION["date"];
	$lan = $_SESSION["lang"];

	$og_date = date("Y-m-d", strtotime($_SESSION['date']));

	$guides = mysqli_query($conn, "SELECT * FROM guides_tbl RIGHT JOIN package_tbl ON guides_tbl.guideid = package_tbl.guideid where city = '$city' and languages like '%".$lan."%' and available_dates like '%".$date."%' ORDER BY price DESC");

	while ($row = $guides->fetch_assoc()) {
		echo $row['guideid']."<br>";
		echo $row['guidename']."<br>";
		echo $row['packageid']."<br>";
		echo $row['starttime']."<br>";
		echo $row['endtime']."<br>";
		echo $row['target_loc']."<br>";
		echo $row['days']."<br>";
		echo $row['price']."<br>";
		echo "<br><br>";
	}
?>