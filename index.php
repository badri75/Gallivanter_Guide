<?PHP
	session_start();
	if (isset($_GET['logout'])) { 
	    session_destroy();
	    if(isset($_SESSION['userid'])) {
	    	unset($_SESSION['userid']);
	    }
	    elseif (isset($_SESSION['guideid'])) {
	     	unset($_SESSION['guideid']);
	    }
	    elseif(isset($_SESSION['adminid'])){
	    	unset($_SESSION['adminid']);
	    }

	    if((isset($_SESSION["date"]))&&(isset($_SESSION["lang"]))&&(isset($_SESSION["search"]))){
		    	unset($_SESSION['search']);
		    	unset($_SESSION["date"]);
		    	unset($_SESSION["lang"]);
	    }
	    header("location: index.php"); 
	} 
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/230e68782e.js" crossorigin="anonymous"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles.css">
	<title>Welcome to Gallivanter Guide!</title>
</head>

<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-inner">
		<a class="navbar-brand" href="index.php">Gallivanter Guide</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav ml-auto">
<!--			<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  		Guides
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					  <a class="dropdown-item" href="#">USD($)</a>
					  <a class="dropdown-item" href="#">INR(₹)</a>
					  <a class="dropdown-item" href="#">EURO(€)</a>
					  <a class="dropdown-item" href="#">YEN(¥)</a>
	        		</div>
      			</li>						-->
      			<li class="nav-item">
      				<?php  if (isset($_SESSION['guideid'])) : ?>
						<a class="nav-link" href="guides/profile.php">Guides</a>
					<?php else:?>
						<a class="nav-link" href="guides/login.php"  onclick="return confirm('This section is exclusively for Guides. If you continue, you will be logged out from other accounts');">Guides</a>
					<?php endif ?> 
				</li>
				<li class="nav-item">
					<a class="nav-link" href="blog/select_blog.php">Blog</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Help</a>
				</li>
				<li class="nav-item">
					<?php  if (isset($_SESSION['userid'])) : ?>
						<a class="nav-link" href="users/profile.php">Profile&nbsp;</a>
					
					<?php else:?>
						<a class="nav-link" href="users/signup.php">Sign Up&nbsp;</a>
					<?php endif ?> 
				</li>
				<li class="nav-item">
					<?php  if ((isset($_SESSION['userid']))||(isset($_SESSION['guideid']))||(isset($_SESSION["adminid"]))) : ?>
						<a class="nav-link btn btn-danger trigger-btn" id="login-btn" href="index.php?logout='1'">
							Logout
						</a>
					<?php else:?>
						<a class="nav-link btn btn-danger trigger-btn" id="login-btn" href="#myModal" data-toggle="modal">
							Login
						</a>
						<script>
						    $(document).ready(function(){
						        $("#myModal").modal('show');
						    });
						</script>
					<?php endif ?> 
				</li>
    		</ul>
  		</div>
	</nav>

	<!-- Login -->
	<section id="login">
		<div id="myModal" class="modal fade text-center">
			<div class="modal-dialog">
				<div class="col-lg-10 col-sm-10 col-12 main-section">
					<div class="modal-content">

					<div class="col-lg-12 col-sm-12 col-12 user-name">
						<h1>User Login</h1>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<div class="col-lg-12 col-sm-12 col-12 form-input">
						<form action="users/login.php" method="post">
							<div class="form-group">
								<input type="email" name="emailid"  class="form-control" placeholder="Enter email" required>
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password" id="pwd" maxlength ="25" required>
								<i class="far fa-eye" id="togglePassword1" style="
									float: right;
								    position: relative;
								    margin-top: -25px;
								    margin-right: 7px;	">
								</i>
								<a href="">Forgot Password?</a>
							</div>
							<div class="col-lg-12 col-sm-12 col-12">
								<button type="submit" class="btn btn-success col-4">Login</button>
							</div>
						</form>
					</div>

					<div class="col-lg-12 col-12 link-part">
						<div id="margin-btm-5px" class="col-lg-12">Sign in using your other accounts</div>
						<button id="margin-btm-5px" type="submit" class="btn-primary col-lg-8"><i class="fab fa-facebook-square"></i>&nbsp;&nbsp;&nbsp;Sign in with Facebook</button>
						<button id="margin-btm-5px" type="submit" class="btn-danger col-lg-8"><i class="fab fa-google-plus-g"></i>&nbsp;&nbsp;Sign in with Google</button>
					</div>

					<div class="col-lg-12 col-12 link-part">
						<a href="./users/signup.php">Don't have an account? Create one</a>
					</div>

					</div>
				</div>
			</div>
	    </div>
	  </section>

	<!-- Searchbar -->
	<center>
	<form action="select/assign.php" method="post" autocomplete="off">
	<div class="container1"> 
		<div id="st-box" class="autocomplete"> 
			<label>Destination&nbsp;&nbsp;&nbsp;</label> 
			<input type="search" name="search" id="myInput" placeholder="search cities" required>
		</div> 
		
		<div id="st-box"> 
			<label>Travel Date&nbsp;&nbsp;&nbsp;</label> 
			<input type="date" name="date" required>
		</div> 
		
		<div id="st-box"> 
			<label id="lan">Preferred Language&nbsp;&nbsp;</label>
			 <div class="dropdown" id="dd">
<!--
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Language
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">English</a>
					<a class="dropdown-item" href="#">Hindi</a>
					<a class="dropdown-item" href="#">Spanish</a>
				</div>				-->
				<select name="language" style="width: 115px;" required>
					<option value="Tamil">Tamil</option>
					<option value="English">English</option>
					<option value="Hindi">Hindi</option>
					<option value="French">French</option>
					<option value="Spanish">Spanish</option>
				</select>
			</div>
		</div> 
	</div> 

	<!-- Search Button -->
	<div id="searching">
		<button class="btn btn-default" id="btn1" type="submit">
			Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search" id="btn2" aria-hidden="true"></i>
		</button>
	</div>
	</form>
	</center>

	<!-- Carousel -->
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-100" src="./images/home/main-caro/img1.jpg" alt="First slide">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="./images/home/main-caro/img2.jpg" alt="Second slide">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="./images/home/main-caro/img3.jpg" alt="Third slide">
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<!-- Top Pick Destinations -->
	<br>
	<center><h2>Top Pick Destinations</h2></center>
	<div class="container top-pick">
		<section class="row">
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/kodaik.jpg">
							<span id="place">Kodaikanal&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<br>
								<span>5,372 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹999</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/ooty.jpg">
							<span id="place">Ooty&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<br>
								<span>3,645 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹1,499</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/kannya.jpg">
							<span id="place">Kanyakumari&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<br>
								<span>2,469 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹2,199</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/mysore.jpg">
							<span id="place">Mysore&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<br>
								<span>3,289 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹3,499</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/rames.jpg">
							<span id="place">Rameswaram&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<br>
								<span>1,538 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹3,999</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-4 outer">
				<div class="inner">
					<a href="">
						<div class="category-tile">
							<img width="100%" height="200" src="./images/home/top-dest/madurai.jpg">
							<span id="place">Madurai&nbsp;&nbsp;</span>
						</div>
						<div class="ratin-amnt">
							<div class="ratin">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<br>
								<span>1,457 Ratings</span>
							</div>
							<div class="amnt">
								<span>from</span>
								<span><h3>₹5,100</h3></span>
							</div>
						</div>
					</a>
				</div>
			</div>
		</section>
	</div>
	<br>
	<hr>

	<!-- Promotions -->
	<center><h2><u>Why Gallivanter Guide?</u></h2></center>
	<br>
	<div class="container">
		<section class="row">
			<div class="col-md-4">
				<center>
					<div class="category-tile">
						<span><i id="prom-icons" class="fa fa-compass fa-7x"></i></span>
					</div>
					<div>
						<span id="prom-text">Experienced Guides & 100% Safe Exploration</span>
					</div>
				</center>
			</div>

			<div class="col-md-4">
				<center>
					<div class="category-tile">
						<span><i id="prom-icons" class="fa fa-ban fa-7x"></i></span>
					</div>
					<div>
						<span id="prom-text">Free Cancellation Policy even before 100 hours</span>
					</div>
				</center>
			</div>

			<div class="col-md-4">
				<center>
					<div class="category-tile">
						<span><i id="prom-icons" class="fa fa-info-circle fa-7x"></i></span>
					</div>
					<div>
						<span id="prom-text">24/7 Helpline for every customer Worldwide</span>
					</div>
				</center>
			</div>
		</section>
	</div>
	<br><br>
	<center><h3>Enjoy your Exploration with us</h3></center>
	<hr><br>

	<!-- Top Travelogues of the Month -->
	<center><h2><u>Top Travelogues of the Month</u></h2></center>
	<br>
	<div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-100" src="./images/home/blogs/kodak-blog.png" alt="First slide">
				<div class="carousel-caption d-none d-md-block">
					<div id="author">
						<h3>My Kodaikkanal Journey</h3>
						<h4>-By Sergio Ramos</h4>
					</div>
					<div id="preview">
						Kodaikanal is a city in the hills of the taluk division of the Dindigul district in the state of Tamil Nadu, India. Its name in the Tamil language means “The Gift of the Forest” . Kodaikanal is referred to as the “Princess of Hill stations.” Although nearby hill stations like Ooty and Munnar have become highly commercialised, Kodaikanal still enjoys the advantage of being a quaint hill station. As, it doesn’t have so much of foot fall. So, it retains all its essence. It mostly comprises of a close community, a few beautiful schools, hospital, other basic infrastructure. And, on top of that, it has some beautiful visiting spots. And then, it’s economy is mostly driven by the hospitality industry...
					</div>
				</div>
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="./images/home/blogs/mysore.jpg" alt="Second slide">
				<div class="carousel-caption d-none d-md-block">
					<div id="author">
						<h3>Marvellous Mysore</h3>
						<h4>-By Paul Pogba</h4>
					</div>
					<div id="preview">
						I had been planning a Rameswaram trip for nearly three years and every time it got finalized something or the other creeping up. Either it was a train timing mismatch or the whole vacation itself got diverted to another direction. After all visiting one of the southernmost part of mainland India has its own challenges due to its extreme south location along with limited train connectivity from the rest of India. Rameswaram has been an important tourist spot due to its religious significance and as the name suggests it’s all to do with Lord Ram after all this is the place from which Ram Setu was built by the Vanar Sena to mainland Lanka (Sri Lanka). 
					</div>
				</div>
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="./images/home/blogs/rameswaram.jpg" alt="Third slide">
				<div class="carousel-caption d-none d-md-block">
					<div id="author">
						<h3>Rameswaram Diaries</h3>
						<h4>-By Karim Benzema</h4>
					</div>
					<div id="preview">
						Hello, my name is Karim Benzema. Mysore, locally known as Mysuru was the prominent city of Karnataka prior to Bangalore. This mystical and mythological city derives its name from the buffalo headed demon Mahishasur who is known to have been slain atop the Chamundi Hills by Goddess Chamundeshwari, an avatar of Parvati. The 10 day dussehra festival is organized every year to celebrate this victory of the good over the evil. The city can boast of its rich past given to it generously by the dynasty of the Wodeyars, which has created such an appealing charm about the city that it can enthrall tourists even to this day.
					</div>
				</div>
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<br>
	<center>
		<div>
			<a href="blog/select_blog.php">
				<button class="btn btn-success" type="submit">View All</button>
			</a>
		</div>
	</center>
	<hr><br>

	<!-- Free Advice -->
	<div class="container free-advice">
		<section class="row">
			<div class="col-md-6">
				<center><h3><u>Don't Know how to plan your next trip? Contact us for free advice</u></h3></center>
				<form action="select/query.php" method="post">
				<section class="row">
					<div class="col-md-6">
						<label>Name:</label><br>
						<input type="text" name="name" maxlength="25" required><br>
						<label>Email:</label><br>
						<input type="email" name="email" maxlength="25" required><br>
					</div>
					<div class="col-md-6">
						<label>City:</label><br>
						<input type="text" name="city" maxlength="15"><br>
						<label>Mobile No:</label><br>
						<input type="mobile" name="mobile" maxlength="10"><br>
					</div>
					<div class="col-md-12">
						<label>Message:</label><br>
						<textarea id="msg" name="query" required></textarea><br>
						<center>
							<button class="btn btn-info" type="submit">Submit</button>
						</center>
					</div>
				</section>
				</form>
			</div>
			<div class="col-md-6">
				<img width="100%" id="help-img" src="./images/home/help/hcwhy1.png">
			</div>
		</section>
	</div><br>

	<!-- Footer -->
	<div class="footer">
	<div class="container footer">
		<section class="row">
			<div class="col-md-8">
				<section class="row">
					<span class="col-md-4">Gallivanter Guide</span>
					<a href="" id="footer-links">Home</a>
					<a href="" id="footer-links">FAQ & Help</a>
					<a href="" id="footer-links">Blog</a>
					<a href="guides/signup.php" id="footer-links">Join Us</a>
					<a href="admin/login.php" id="footer-links">Admin</a>
				</section><br>
				<p>Copyright 2020 RBN & Co. Pvt. Ltd. All Rights Reserved</p>
			</div>
			<div class="col-md-4">
				<div><i class="fas fa-phone-square-alt"></i><a id="blue-link" href="tel:+919876543210"> +91 98765 43210</a></div>
				<div><i class="fas fa-envelope-square"></i><a id="blue-link" href="mailto:help@gallivanterguide.com">
					<span>&nbsp;info@gallivanterguide.com</span>
				</a></div>
				<section class="row">
					<div class="col-md-3" id="smedia">
						<a href=""><i id="white-link" class="fab fa-facebook-square"></i></a>
					</div>
					<div class="col-md-3" id="smedia">
						<a href=""><i id="white-link" class="fab fa-instagram"></i></a>
					</div>
					<div class="col-md-3" id="smedia">
						<a href=""><i id="white-link" class="fab fa-twitter-square"></i></a>
					</div>
					<div class="col-md-3" id="smedia">
						<a href=""><i id="white-link" class="fab fa-youtube"></i></a>
					</div>
				</section>
			</div>
		</section>
	</div>
	</div>

	<script>
		const togglePassword = document.querySelector('#togglePassword1');
		const password = document.querySelector('#pwd');
		togglePassword.addEventListener('click', function (e) {
		    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		    password.setAttribute('type', type);
		    this.classList.toggle('fa-eye-slash');
		});
	</script>
	<script>
	function autocomplete(inp, arr) {
	  /*the autocomplete function takes two arguments,
	  the text field element and an array of possible autocompleted values:*/
	  var currentFocus;
	  /*execute a function when someone writes in the text field:*/
	  inp.addEventListener("input", function(e) {
	      var a, b, i, val = this.value;
	      /*close any already open lists of autocompleted values*/
	      closeAllLists();
	      if (!val) { return false;}
	      currentFocus = -1;
	      /*create a DIV element that will contain the items (values):*/
	      a = document.createElement("DIV");
	      a.setAttribute("id", this.id + "autocomplete-list");
	      a.setAttribute("class", "autocomplete-items");
	      /*append the DIV element as a child of the autocomplete container:*/
	      this.parentNode.appendChild(a);
	      /*for each item in the array...*/
	      for (i = 0; i < arr.length; i++) {
	        /*check if the item starts with the same letters as the text field value:*/
	        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
	          /*create a DIV element for each matching element:*/
	          b = document.createElement("DIV");
	          /*make the matching letters bold:*/
	          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
	          b.innerHTML += arr[i].substr(val.length);
	          /*insert a input field that will hold the current array item's value:*/
	          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
	          /*execute a function when someone clicks on the item value (DIV element):*/
	          b.addEventListener("click", function(e) {
	              /*insert the value for the autocomplete text field:*/
	              inp.value = this.getElementsByTagName("input")[0].value;
	              /*close the list of autocompleted values,
	              (or any other open lists of autocompleted values:*/
	              closeAllLists();
	          });
	          a.appendChild(b);
	        }
	      }
	  });
	  /*execute a function presses a key on the keyboard:*/
	  inp.addEventListener("keydown", function(e) {
	      var x = document.getElementById(this.id + "autocomplete-list");
	      if (x) x = x.getElementsByTagName("div");
	      if (e.keyCode == 40) {
	        /*If the arrow DOWN key is pressed,
	        increase the currentFocus variable:*/
	        currentFocus++;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 38) { //up
	        /*If the arrow UP key is pressed,
	        decrease the currentFocus variable:*/
	        currentFocus--;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 13) {
	        /*If the ENTER key is pressed, prevent the form from being submitted,*/
	        e.preventDefault();
	        if (currentFocus > -1) {
	          /*and simulate a click on the "active" item:*/
	          if (x) x[currentFocus].click();
	        }
	      }
	  });
	  function addActive(x) {
	    /*a function to classify an item as "active":*/
	    if (!x) return false;
	    /*start by removing the "active" class on all items:*/
	    removeActive(x);
	    if (currentFocus >= x.length) currentFocus = 0;
	    if (currentFocus < 0) currentFocus = (x.length - 1);
	    /*add class "autocomplete-active":*/
	    x[currentFocus].classList.add("autocomplete-active");
	  }
	  function removeActive(x) {
	    /*a function to remove the "active" class from all autocomplete items:*/
	    for (var i = 0; i < x.length; i++) {
	      x[i].classList.remove("autocomplete-active");
	    }
	  }
	  function closeAllLists(elmnt) {
	    /*close all autocomplete lists in the document,
	    except the one passed as an argument:*/
	    var x = document.getElementsByClassName("autocomplete-items");
	    for (var i = 0; i < x.length; i++) {
	      if (elmnt != x[i] && elmnt != inp) {
	        x[i].parentNode.removeChild(x[i]);
	      }
	    }
	  }
	  /*execute a function when someone clicks in the document:*/
	  document.addEventListener("click", function (e) {
	      closeAllLists(e.target);
	  });
	}

	/*An array containing all the country names in the world:*/
	var countries = ["Goa","Manali","Andaman & Nicobar","Coorg","Agra","Udaipur","Jaipur","Leh Ladakh","Delhi","Varanasi","Jaisalmer","Mumbai","Rishikesh","Alleppey","Munnar","Bangalore","Varkala","Jodhpur","Shimla","Gangtok","Srinagar","Darjeeling","Kolkata","Amristar","Nainital","Ooty","Hyderabad","Mussoorie","Pondicherry","Khajuraho","Chennai","Vaishno Devi","Dalhousie","Ajanta and Ellora Caves","Haridwar","Kanyakumari","Pune","Kodaikanal","Kochi","Ahmedabad","Mysore","Chandigarh","Lonavala","Mamallapuram","Wayanad","Hampi"];

	/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	autocomplete(document.getElementById("myInput"), countries);
	</script>
	<style type="text/css">
		.autocomplete-items {
		  position: absolute;
		  border: 1px solid #d4d4d4;
		  border-bottom: none;
		  border-top: none;
		  z-index: 99;
		  /*position the autocomplete items to be the same width as the container:*/
		  top: 100%;
		  left: 150px;
		  right: 0;
		  width: 150px;
		}

		.autocomplete-items div {
		  padding: 10px;
		  cursor: pointer;
		  background-color: white; 
		  border-bottom: 1px solid #d4d4d4; 
		}

		/*when hovering an item:*/
		.autocomplete-items div:hover {
		  background-color: #e9e9e9; 
		}

		/*when navigating through the items using the arrow keys:*/
		.autocomplete-active {
		  background-color: DodgerBlue !important; 
		  color: #ffffff; 
		}
	</style>

</body>
</html>