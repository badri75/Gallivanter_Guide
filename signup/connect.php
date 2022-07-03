<?PHP
	$fullname = $_POST['fullname'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];
	$email = $_POST['email'];
	$country = $_POST['country'];
	$phncode = $_POST['phncode'];
	$phnno = $_POST['phnno'];
	$currency = $_POST['currency'];
	$pwd = $_POST['pwd'];

	$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		die('Connection Failed : '.$conn->connect_error);
	}
	else{
		$slctmail = "SELECT email from register where email = ? Limit 1";
		$slctphncode = "SELECT phonecode from register where phonecode = ? Limit 1";
		$slctphoneno = "SELECT phoneno from register where phonecode = ? Limit 1";

		$insert = "INSERT into register (fullname, gender, age, email, country, phonecode, phoneno, currency, password) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt1 = $conn->prepare($slctmail);
		$stmt1->bind_param("s",$email);
		$stmt1->execute();
		$stmt1->bind_result($email);
		$stmt1->store_result();
		$rnum1 = $stmt1->num_rows;

		$stmt2 = $conn->prepare($slctphncode);
		$stmt2->bind_param("i",$phncode);
		$stmt2->execute();
		$stmt2->bind_result($phncode);
		$stmt2->store_result();
		$rnum2 = $stmt2->num_rows;

		$stmt3 = $conn->prepare($slctphoneno);
		$stmt3->bind_param("i",$phnno);
		$stmt3->execute();
		$stmt3->bind_result($phnno);
		$stmt3->store_result();
		$rnum3 = $stmt3->num_rows;

		if($rnum1==0) {
			if(($rnum2==0) || ($rnum3==0)) {
				$stmt = $conn->prepare($insert);
				$stmt->bind_param("ssissiiss", $fullname, $gender, $age, $email, $country, $phncode, $phnno, $currency, $pwd);
				$stmt->execute();
				echo "New record is inserted sucessfully";
				$stmt->close();
			}
			else {
				echo "Someone have already registered using this Phone Number";
				header(index.html)
			}
		}
		else{
			echo "Someone have already registered using this E-mail";
		}

		$stmt3->close();
		$stmt2->close();
		$stmt1->close();
		$conn->close();
	}
?>