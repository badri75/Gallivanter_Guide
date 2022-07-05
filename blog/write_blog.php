<?PHP
	session_start();

	$conn = new mysqli('localhost','root','','gallivanter_guide');
		if($conn->connect_error){
			die('Connection Failed : '.$conn->connect_error);
		}

	if (isset($_SESSION['userid'])||isset($_SESSION["adminid"])) {
		if(isset($_GET['id'])){
			$blogid = $_GET['id'];
			$rs=mysqli_query($conn,"SELECT * from blog_tbl where blogid ='$blogid'");
			while ($row = $rs->fetch_array()) {
				$title1 = $row['title'];
				$btext1 = $row['blog'];
				$userid = $row['userid'];
			}
			if((@$_SESSION['userid']==$userid)||isset($_SESSION["adminid"])) {
				if($_SERVER["REQUEST_METHOD"] == "POST") {
					$title = $conn->real_escape_string($_POST['title']);
					$btext = $conn->real_escape_string($_POST['blogtext']);

					$update = $conn->query("UPDATE blog_tbl SET title='$title', blog='$btext' WHERE blogid='$blogid'");
					if($update){
						echo '<script>
							alert("Successfully Edited");
					        window.location.href="./select_blog.php";
					      </script>';
					}
					else{
						echo "Oops!";
					}
					$conn->close();
				}
			}
		}
		else {
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				$title = $conn->real_escape_string($_POST['title']);
				$btext = $conn->real_escape_string($_POST['blogtext']);
				$userid = $_SESSION['userid'];

				$insert = $conn->query("INSERT into blog_tbl (userid, title, blog, date) values('".$userid."','".$title."','".$btext."',DATE(NOW()))");
				if($insert){
					echo '<script>
						alert("Successfully Added");
				        window.location.href="./select_blog.php";
				      </script>';
				}
				else{
					echo "Oops!";
				}
				$conn->close();
			}
		}
	}
	else {
		echo '<script>
	        alert("Login to start writing!");
	        window.location.href="../index.php";
	      </script>';
	}
?> 

<!DOCTYPE html>
<html>
<head>
	<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
	<script src="../ckfinder/ckfinder.js"></script>
	<title>Create Your Blog!</title>

	<style>
		#title{
			width: 40%;
		}
		#mytextarea {
			width: 100%;
			height: 400px;
		}
	</style>
</head>

<body>
	<?php include '../header.php';?>

	<!--  -->
	<center><h2>Write Your Blog!</h2></center><br>
	<nav class="container">
		<form action="" method="post">
			<div>
				<span>Blog Title</span><br>
				<input id="title" type="text" name="title" 
				value="<?php if(isset($_GET['id'])){ echo $title1; }?>" required>
			</div><br>
			<div>
				<span>Your Blog</span><br>
				<textarea id="mytextarea" name="blogtext" required>
					<?php if(isset($_GET['id'])){ echo $btext1; }?>
				</textarea>
			</div><br>
			<div>
				<span><input type="checkbox" name="t-nd-c" required>&nbsp;&nbsp;I agree to the <a href=""><u>Terms of Use</u></a> and <a href=""><u>Privacy Policy</u></a></span>
				<center>
					<input type="submit" name="sumbit" value="Submit">
				</center>
			</div><br>
		</form>
	</nav>

	<?php include '../footer.php';?>

	<script type="text/javascript">
	    var editor = CKEDITOR.replace('mytextarea',{width:"100%", height:"400px"});
		CKFinder.setupCKEditor( editor );
	</script>
</body>