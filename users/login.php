<?php
 $conn = mysqli_connect("localhost","root","","gallivanter_guide");
  if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  session_start();
  if(isset($_SESSION['guideid'])) {
    session_destroy();
    unset($_SESSION['guideid']);
  }
 
 if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['emailid'];
    $pwd = $_POST['password'];

    $rs=mysqli_query($conn,"SELECT * from users_tbl where email ='$email'");

    if(mysqli_num_rows($rs)<1) {
      echo '<script>
        alert("Invalid email. Try again");
        window.location.href="../index.php";
      </script>';
      session_destroy();
    }
    else {
      while ($row = $rs->fetch_array()) {
        $name = $row['username'];
        $id = $row['userid'];
        $pwd1 = $row['password'];
      }
      if($pwd!=$pwd1) {
        echo '<script>
          alert("Invalid Password. Try again");
          window.location.href="../index.php";
        </script>';
        session_destroy();
      }
      else {
        $_SESSION["userid"]=$id;        
        echo "<script>
          alert('Welcome $name');
          window.location.href='../index.php';
        </script>";
      }   
    }
  }  
?>