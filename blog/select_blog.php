<?PHP
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}	
	if (isset($_SESSION['userid'])) {
		$userid = $_SESSION['userid'];
	}
	if(isset($_GET['id'])) {		
		$rs = mysqli_query($conn, "SELECT * from blog_tbl where userid='$userid'");
		if(mysqli_num_rows($rs)<1) {
			if (isset($_SESSION['userid'])) {
				echo '<script>
			        alert("You have not written any blogs. Write Some?");
			        window.location.href="write_blog.php";
			    </script>';
			}
			else {
				echo '<script>
			        alert("Please Login first");
			        window.location.href="../index.php";
			      </script>';
			}
		}
	} else {
		$rs = mysqli_query($conn, "SELECT * from blog_tbl");
	}	
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Page Design</title>
    <style type="text/css">
    	*{
    		box-sizing: border-box;
    	}
    	#right {
    		text-align: right;
    		font-size: 1.2rem;
    	}
    	.inner {
    		border: 2px solid black; 
    		height: 228px; 
    		overflow: hidden; 
    		transition: transform .2s; 		
    	}
    	.inner:hover{
    		transform: scale(1.07);
    	}
    	#edit {
    		float: right;
    		position: relative;
    		bottom: 215px;
    		right: 8px;
    		border: 2px solid black;
			background-color: black;			
			border-radius: 20px;
			padding: 0.1rem 0.6rem!important;
			opacity: 0.8;
    	}
    	#title {
    		background-color: #000;
    		color: #fff;
    		height: 30px;
    	}
    	img {
    		display: block;
    		overflow: hidden;
    	}
    	#write{
    		font-size: 1.2rem;
    	}
    </style>
</head>

<body>
	<?php include '../header.php';?>

	<nav class="container">
		<center><h3><u>Select a Blog to read</u></h3></center>
		<?PHP if(isset($_GET['id'])): ?>
			<div id="right">
				<a href="select_blog.php">View All Blogs</a>
			</div>
			<h4>Displaying Your Blogs</h4>
		<?PHP elseif(isset($_SESSION['userid'])): ?>
			<div id="right">
				<a href="select_blog.php?id=<?PHP echo $userid; ?>">View Your Blogs</a>
			</div><br>
		<?PHP endif ?>
		<nav class="row">
			<?PHP while ($row = $rs->fetch_array()) {
				$title = $row['title'];
				$blog = $row['blog'];
				$blogid = $row['blogid'];

				$doc = new DOMDocument();
				$doc->loadHTML($blog);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); 
				?>
			    <div class="col-md-4 col-sm-6 outer" style="height: 240px;">
			    	<div class="inner">
			    		<a href="./display_blog.php?id=<?PHP echo $blogid; ?>">
				        	<center>
					        	<img alt="Sorry! No Image to Display" width="100%" height="200" src="<?PHP echo "$src"; ?>">
				        		<div id="title"><?PHP echo "$title"; ?></div>
				        	</center>
				        </a>
				        <?PHP if(isset($_GET['id'])): ?>
			    			<span id="edit">
			    				<a style="color: white;" href="./write_blog.php?id=<?PHP echo $blogid; ?>">Edit</a>
			    			</span>
			    		<?PHP endif ?>
			        </div>
			    </div>	
			<?PHP } ?>
		</nav>
		<center><div><a id="write" href="write_blog.php"><u>Write Your Own Blog</u></a></div></center><br>
	</nav>

	<?php include '../footer.php';?>

</body>
</html>