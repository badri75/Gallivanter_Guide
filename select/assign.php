<?php
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION["search"] = $_POST['search'];
		$_SESSION["date"] = date("d-m-Y", strtotime($_POST['date']));
		$_SESSION["lang"] = $_POST['language'];

		echo '<script>
	        window.location.href="./select_packages.php";
	      </script>';
	}
?>