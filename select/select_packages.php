<?php
	session_start();
	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	$city = $_SESSION['search'];
	$date = date("d-m-Y", strtotime($_SESSION['date']));
	$lan = $_SESSION["lang"];
	$sort = '';
	$srh = '';

	if((!isset($_SESSION['search']))||(!isset($_SESSION['date']))||(!isset($_SESSION['lang']))){
		echo '<script>
			alert("Oops! An Error Happened");
	        window.location.href="../index.php";
	      </script>';
	}

	$og_date = date("Y-m-d", strtotime($_SESSION['date']));

	if (isset($_SESSION['userid'])) {
		function chn_curr($price,$conn){
			$uid = $_SESSION['userid'];
			$sel_curr = mysqli_query($conn, "SELECT currency FROM users_tbl where userid = '$uid'");
			while ($set = $sel_curr->fetch_array()) {
				$curr = $set['currency'];
			}
			if($curr == 'INR'){
				return "₹".number_format((float)$price, 2, '.', '');
			}
			elseif($curr == 'USD'){
				return "$".number_format((float)$price*0.014, 2, '.', '');
			}
			elseif($curr == 'EUR'){
				return "€".number_format((float)$price*0.011, 2, '.', '');
			}
		}
	}

	$guides = mysqli_query($conn, "SELECT * FROM guides_tbl RIGHT JOIN package_tbl ON guides_tbl.guideid = package_tbl.guideid where city = '$city' and languages like '%".$lan."%' and available_dates like '%".$date."%'");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST['clear'])){
			$guides = mysqli_query($conn, "SELECT * FROM guides_tbl RIGHT JOIN package_tbl ON guides_tbl.guideid = package_tbl.guideid where city = '$city' and languages like '%".$lan."%' and available_dates like '%".$date."%'");
		}
		else {
			$srh = $conn->real_escape_string($_POST['search1']);
			$og_date = $_POST['date1'];
			$_SESSION['date'] = date("d-m-Y", strtotime($og_date));
			$date = date("d-m-Y", strtotime($og_date));
			$sort = $_POST['sort'];
			$start1 = $_POST['start1'];
			$start2 = $_POST['start2'];
			$end1 = $_POST['end1'];
			$end2 = $_POST['end2'];
			$slday = $_POST['day'];

		$guides = mysqli_query($conn, "SELECT * FROM guides_tbl RIGHT JOIN package_tbl ON guides_tbl.guideid = package_tbl.guideid where city = '$city' and languages like '%".$lan."%' and available_dates like '%".$date."%'and target_loc like '%".$srh."%' and starttime >= '$start1' and starttime <= '$start2' and endtime >= '$end1' and endtime <= '$end2' and days ".$slday." ORDER BY price $sort");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Select a Package</title>
	<style type="text/css">
		#text{
			display:inline;
			font-size: 1.1rem;
		}
		.outer{
			margin-bottom: 10px;
		}
		.inner {
    		border: 2px solid black; 
    		height: 340px; 
    		overflow: hidden; 
    		transition: transform .2s;
    		font-size: 1.1rem;
    		color: black!important;	
    	}
    	.sin{
    		height: 25px;
    		overflow: hidden;
    		margin: 5px;
    		color: black;
    	}
    	.price{
    		position: absolute;
    		float: right;
    		font-size: 2.0rem;
    		right: 25px;
    		bottom: 10px;
    	}
    	b{
    		color: #1a2b49;
    	}
    	#cen{
    		border-bottom: 2px solid black;
    	}
    	#title {
    		background-color: #000;
    		color: #fff;
    		height: 25px;
    	}
    	h5{
    		width: 100%;
    		text-align: center;
    		color: red;
    	}
    	<?php if(mysqli_num_rows($guides)==0): ?>
	    	.bottomed{
				position: fixed;
				bottom: 0px;
				right: 0px;
				left: 0px;
			}
		<?php endif ?>
	</style>
</head>
<body>
	<?php include '../header.php';?>

	<nav class="container">
		<center><h3>Select a Package</h3><br>
		<form action="" method="post">
		<nav class="row">
			<div class="col-md-4 col-sm-6">
				<p id="text">Search:&nbsp;&nbsp;</p>
				<input type="search" name="search1" placeholder="Specific Places" value="<?php if($srh!=''){echo $srh;} ?>">
				<button class="btn-info">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</div>
			<div class="col-md-4 col-sm-6">
				<p id="text">Change date:&nbsp;</p>
				<input type="date" name="date1" value="<?php echo $og_date; ?>">
				<button class="btn-info">
					<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
				</button>
			</div>
			<div class="col-md-4 col-sm-6">
				<p id="text">Sort Price by:&nbsp;&nbsp;</p>
				<select name="sort" style="font-size: 1.1rem;">
					
					<option value="ASC" <?php if($sort=="ASC"):?> selected <?php endif ?> >Ascending</option>
					<option value="DESC" <?php if($sort=="DESC"):?> selected <?php endif ?> >Descending</option>
				</select>
				<button class="btn-info">
					<i class="fa fa-filter" aria-hidden="true"></i>
				</button>
			</div>
		</nav><br>
		<nav class="row">
			<div class="col-md-4 col-sm-6">
				<p id="text">Start Time from</p>
				<input type="time" name="start1" value="<?php if(isset($start1)){echo $start1;} else{echo '00:00';}?>">
				<p id="text">&nbsp;to&nbsp;</p>
				<input type="time" name="start2" value="<?php if(isset($start2)){echo $start2;} else{echo '23:59';}?>">
				<button class="btn-info">
					<i class="fas fa-hourglass-start"></i>
				</button>
			</div>
			<div class="col-md-4 col-sm-6">
				<p id="text">End Time from&nbsp;</p>
				<input type="time" name="end1" value="<?php if(isset($end1)){echo $end1;} else{echo '00:00';}?>">
				<p id="text">&nbsp;to&nbsp;</p>
				<input type="time" name="end2" value="<?php if(isset($end2)){echo $end2;} else{echo '23:59';}?>">
				<button class="btn-info">
					<i class="fas fa-hourglass-end"></i>
				</button>
			</div>
			<div class="col-md-4 col-sm-6">
				<p id="text">Sort Number of  Travel Days by:&nbsp;</p>
				<select name="day" style="font-size: 1.1rem;">
					<option value="!=0">All</option>
					<option value="=1" <?php if(isset($slday)){ if($slday=="=1"){?> selected <?php }} ?> >&nbsp;1&nbsp;</option>
					<option value="=2" <?php if(isset($slday)){ if($slday=="=2"){?> selected <?php }} ?> >&nbsp;2&nbsp;</option>
					<option value="=3" <?php if(isset($slday)){ if($slday=="=3"){?> selected <?php }} ?> >&nbsp;3&nbsp;</option>
				</select>
				<button class="btn-info">
					<i class="fa fa-filter" aria-hidden="true"></i>
				</button>
			</div>
		</nav>
		</form><br>
		<?php
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				if((isset($_POST['search1']))||(isset($_POST['date1']))||(isset($_POST['sort']))||(isset($_POST['start1']))||(isset($_POST['start2']))||(isset($_POST['end1']))||(isset($_POST['end2']))||(isset($_POST['day']))){
		?>
		<div>
			<form action="" method="post">
				<button class="btn-danger" name="clear" value="clear">Clear Filters</button>
			</form>
		</div>
		<?php	}	}	?>
		</center><br>
		<nav class="row">
			<?php
			while ($row = $guides->fetch_assoc()) {
				$guideid = $row['guideid'];
				$chk_date = mysqli_query($conn, "SELECT tour_date from orders_tbl where tour_date='%$og_date%' and guideid='$guideid' Limit 1");

				if(mysqli_num_rows($chk_date)==0){
					$name = $row['guidename'];
					$img = $row['image'];
					$packageid = $row['packageid'];
					$start = date("G:i", strtotime($row['starttime']));
					$end = date("G:i", strtotime($row['endtime']));
					$target = $row['target_loc'];
					$days = $row['days'];
					if(isset($_SESSION['userid'])){
						$price = chn_curr($row['price'],$conn);
					}
					else {
						$price = "₹".number_format((float)$row['price'], 2, '.', '');
					}
					
			?>
			<div class="col-md-4 col-sm-6 outer" style="height: 350px;">
			    <div class="inner">
			    <a href="./guide_profile.php?id=<?PHP echo $packageid; ?>">
			    	<div id="cen">
				    	<center><?php echo "<img width='200px' height='200px' src='data:image;base64,".base64_encode($img)."' style='position:relative; overflow:hidden;'>"; ?>
				    		<div id="title"><?PHP echo "$name"; ?></div>
				    	</center>
			    	</div>
			    	<div class="sin">
			    		&nbsp;&nbsp;<i class="fas fa-location-arrow"></i>&nbsp;&nbsp;<?php echo $target; ?>
			    	</div>
			    	<div class="sin">
			    		&nbsp;&nbsp;<i class="fas fa-hourglass-start"></i>&nbsp;&nbsp;<b>Start time: </b><?php echo $start; ?>&nbsp;&nbsp;&nbsp;<i class="fas fa-hourglass-end"></i>&nbsp;&nbsp;<b>End time: </b><?php echo $end; ?>
			    	</div>
			    	<div class="sin">
			    		&nbsp;&nbsp;<i class="fas fa-calendar-day"></i>&nbsp;&nbsp;<b>Days: </b><?php echo $days; ?>
			    	</div>
			    	<div class="price">
			    		<b><?php echo $price; ?></b>
			    	</div>
			    </a>
			    </div>
			</div>
			<?php 
					}
					$chk_date = '';
				}
				if(mysqli_num_rows($guides)==0){
					echo "<h5><br><br>Oops! No Result. Try different Filters</h5>";
				}
			?>
		</nav>
	</nav>

	<br><br>
	<section class="bottomed">	<?php include '../footer.php';?>	</section>

</body>
</html>