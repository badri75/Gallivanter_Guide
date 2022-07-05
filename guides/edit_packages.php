<?php
	session_start();
	if ((!isset($_SESSION['guideid']))&&(!isset($_SESSION['adminid']))) {
		echo '<script>
	        alert("Unauthorized");
	        window.location.href="../index.php";
	      </script>';
	}

	$conn = new mysqli('localhost','root','','gallivanter_guide');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}

	$begin = new DateTime('2021-05-01');
    $end = new DateTime('2021-05-31');

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$package= mysqli_query($conn, "SELECT * from package_tbl where packageid='$id'");
		if($package){
			while ($row1 = $package->fetch_array()) {
				$guideid = $row1['guideid'];
				$price = $row1['price'];
				$days = $row1['days'];
				$start = $row1['starttime'];
				$end = $row1['endtime'];
				$target = $row1['target_loc'];
				$ava_date = $row1['available_dates'];
			}
			if(((@$_SESSION['guideid'])!=$guideid)&&(!isset($_SESSION['adminid']))) {
				echo '<script>
			        alert("Unauthorized1");
			        window.location.href="../index.php";
			      </script>';
			}
		}
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['submit'])) {
				$price1 = $_POST['price'];
				$days1 = $_POST['days'];
				$start1 = $_POST['start'];
				$end1 = $_POST['end'];
				$target1 = $conn->real_escape_string($_POST['target']);

				$update = $conn->query("UPDATE package_tbl SET price='$price1', days='$days1', starttime='$start1', endtime='$end1', target_loc='$target1' WHERE packageid='$id'");
				if($update){
					echo '<script>
						alert("Successfully Edited");
				        window.location.href="./profile.php";
				      </script>';
				}
				else{
					echo ("Oops! ".$conn->error);
				}
			}
			if (isset($_POST['submit1'])) {
				$str='';
				foreach ($period as $dt) {
	                $date = $dt->format("d-m-Y");
	                $str = $str.$_POST[$date].',';
	            }
	            $str = $conn->real_escape_string($str);
	            $insert_dt = $conn->query("UPDATE package_tbl SET available_dates = '$str' where packageid = '$id'");
	            if($insert_dt){
	            	echo '<script>
						alert("Successfully Added");
				        window.location.href="./profile.php";
				      </script>';
	            }
	            else{
	            	echo ("Oops! ".$conn->error);
	            }
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Packages</title>
	<style type="text/css">
		.row{
			font-size: 1.2rem;
		}
		.col-md-4 p{
			text-align: right;
		}
		.col-md-7 input{
			margin-bottom: 9px;
		}
		#rad{
			padding-left: 20px;
		}
		#no{
			margin-left: 20px;
		}
		#auto{
			width: 80%;
			height: 250px;
			resize: none;
			overflow: hidden;
		}
		#dt{
			width: 300px;
			height: 125px;
		}
	</style>
</head>
<body>
	<?php include '../header.php';?><br>

	<nav class="container">
		<section class="row">
			<div class="col-md-7">
				<center><h4>Edit Details</h4></center><br>
				<section class="row">
					<div class="col-md-4">
						<p>Price:</p>
						<p>Days:</p>
						<p>Start Time:</p>
						<p>End Time:</p>
						<p>Target Locations:</p>
					</div>
					<div class="col-md-8">
						<form action="" method="post">				
							<input type="number" name="price" value="<?PHP echo $price; ?>"><br>
							<input type="number" name="days" value="<?PHP echo $days; ?>"><br>
							<input type="time" name="start" value="<?PHP echo $start; ?>"><br>
							<input type="time" name="end" value="<?PHP echo $end; ?>"><br>
							<textarea name="target" id="auto"><?PHP echo $target; ?></textarea><br>
							<input type="submit" name="submit" value="Update">
						</form>
					</div>
				</section>
			</div>
			<div class="col-md-5">
<!--				<div class="form-group">
					<form name="add_name" id="add_name"> 
					  <div class="table-responsive">  
					       <table class="table table-bordered" id="dynamic_field">  
					            <tr>  
					                 <td><input type="date" name="name[]" class="form-control name_list" onchange="func()" id="date" /></td>  
					                 <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
					            </tr>  
					       </table> 
					       <center><input type="button" name="submit1" id="submit1" class="btn btn-info" value="Submit" /></center>
					  </div>  
					</form>  
				</div>  				-->
				<?php  if(isset($_GET['id'])): ?>
				<center><h4>Are you available for the following dates?</h4></center><br>
				<form action="" method="post">
					<?php foreach ($period as $dt) {  ?>
						<section class="row">
							<div class="col-md-6">
								<?php
									$date = $dt->format("d-m-Y");
									echo $date."&nbsp&nbsp";
									echo $dt->format("l\n");
									$slct = mysqli_query($conn,"SELECT available_dates from package_tbl where available_dates like '%$date%' and packageid = '$id'");
								?>
							</div>
						    <div class="col-md-6" id="rad">
						    	<input type="radio" id="yes" name="<?php echo $date; ?>" value="<?php echo $date; ?>" <?php if(mysqli_num_rows($slct)!=0): ?> checked <?php endif ?> required>
						        <label for="yes">Yes</label>
						        <input type="radio" id="no" name="<?php echo $date; ?>" value="" <?php if(mysqli_num_rows($slct)==0): ?> checked <?php endif ?> >
						        <label for="no">No</label>
						    </div>
					    </section>
					<?php  $slct = '';  }   ?><br>
				<center><input type="submit" name="submit1"></center>
				</form>
				<?php endif ?>
			</div>
		</section>
	</nav><br>

	<?php include '../footer.php';?>

	<script type="text/javascript">
		textarea = document.querySelector("#auto");
		textarea.addEventListener('input', autoResize, false);
		function autoResize(){
			this.style.height = 'auto';
			this.style.height = this.scrollHeight + 'px';
		}

	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>  
/*		$(document).ready(function(){  
		  	var i=1;  
		  	$('#add').click(function(){  
		       	i++;  
		       	$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="date" name="name[]" class="form-control name_list" onchange="func()" id="date" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" />X</button></td></tr>');  
		  	});  
		  	$(document).on('click', '.btn_remove', function(){  
		    	var button_id = $(this).attr("id");   
		    	$('#row'+button_id+'').remove();  
		  	});  
		  	$('#submit1').click(function(){         
		    	$.ajax({
		    		url:"new.php",	             
		            method:"POST",  
	                data:$('#add_name').serialize(),  
	                success:function(data)	{  
		                $("#dt").text(data);  
		                $('#add_name')[0].reset();  
		            }
		     	});  
			});
		});  */
	</script>
</body>
</html>