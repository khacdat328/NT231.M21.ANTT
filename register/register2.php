<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  session_start();
  if(isset($_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['email'], $_SESSION['password'])){
    $g11_fname = $_SESSION['firstname'];
    $g11_lname = $_SESSION['lastname'];
    $g11_email = $_SESSION['email'];
    $g11_password = $_SESSION['password'];
    $_SESSION['firstname'] = $g11_fname;
    $_SESSION['lastname'] = $g11_lname;
    $_SESSION['email'] = $g11_email;
    $_SESSION['password'] = $g11_password;
    $g11_connection = mysqli_connect("localhost", "root", "root", "bank");
    $g11_con = mysqli_connect("localhost","root","root","transactions");
    require '../vendor/autoload.php';
    if (!$g11_connection || !$g11_con) {
      die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_POST['submit'])){
      $g11_fname = $_SESSION['firstname'];
      $g11_lname = $_SESSION['lastname'];
      $g11_email = $_SESSION['email'];
      $g11_password = $_SESSION['password'];
      $g11_token = mysqli_real_escape_string($g11_connection, md5(rand()));
      $g11_phone = $_POST['phone'];
      $g11_acc_type = $_POST['acc_type'];
      $g11_birthday = $_POST['birthday'];
      $g11_person_id = $_POST['person_id'];
      $g11_gender = $_POST['gender'];
      $g11_address = $_POST['address'];
      $g11_district = $_POST['district'];
      $g11_city = $_POST['city'];
      $g11_country = $_POST['country'];
      $g11_nationality = $_POST['nationality'];
      $g11_account_no = rand(999999999,10000000000);
      while (1) {
        $g11_result = mysqli_query($g11_connection, "SELECT account_no FROM login WHERE account_no='$g11_account_no'");
        $g11_count = mysqli_num_rows($g11_result);
        if($g11_count==0)
        {
          break;
        }
        $g11_account_no = rand(999999999,10000000000);
      }
      $g11_date = date("Y-m-d");
      if (mysqli_num_rows(mysqli_query($g11_connection, "SELECT * FROM register WHERE email='{$g11_email}'")) > 0) {
        echo "<script> alert('{$g11_email} - This email address has been already exists.')</script>";
        header("refresh:0;url=register.php");
      } else {
        $g11_s = mysqli_multi_query($g11_connection, "insert into login(id, pwd, account_no) values ('$g11_email',  '$g11_password', '$g11_account_no'); insert into register(account_no, firstname, lastname, email, status, token, phone, acc_type, birthday, person_id, gender, address, district, city, country, nationality) values ('$g11_account_no', '$g11_fname',  '$g11_lname',  '$g11_email', '0', '$g11_token', '$g11_phone',  '$g11_acc_type',  '$g11_birthday',  '$g11_person_id',  '$g11_gender',  '$g11_address',  '$g11_district',  '$g11_city',  '$g11_country',  '$g11_nationality'); insert into balance(account_no, balance, online_limit, card_limit, upi_limit, online_no, card_no, upi_no) values ('$g11_account_no', '1000', null, null, null, null, null, null);");
        $g11_c = mysqli_multi_query($g11_con, "create table `$g11_account_no`(`date` VARCHAR(10) NOT NULL ,`remark` VARCHAR(200) NOT NULL ,`debit` INT(6) NOT NULL ,`credit` INT(6) NOT NULL ,`balance` INT(8) NOT NULL); INSERT INTO `$g11_account_no` (date, remark, debit, credit, balance) VALUES('$g11_date', 'New Account', null, '1000', '1000');");
        if($g11_s && $g11_c) {
          /*$_SESSION['account_no'] = $g11_account_no;
          header("refresh:0;url=../login/login.php");*/
          echo "<div style='display: none;'>";          
          $mail = new PHPMailer(true);

          try {
              //Server settings
              $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
              $mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Username   = '19520223@gm.uit.edu.vn';                     //SMTP username
              $mail->Password   = '1614205866';                               //SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
              $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

              //Recipients
              $mail->setFrom('19520223@gm.uit.edu.vn');
              $mail->addAddress($g11_email);

              //Content
              $mail->isHTML(true);                                  //Set email format to HTML
              $mail->Subject = 'NO REPLY';
              $mail->Body    = 'Here is the verification link <b><a href="http://localhost/NT213.M21.ANTT/login/login.php/?verification='.$g11_token.'">http://localhost/NT213.M21.ANTT/login/login.php/?verification='.$g11_token.'</a></b>';

              $mail->send();
              echo 'Message has been sent';
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
          echo "</div>";
          echo "<script>alert('We have send a verification link on your email address.')</script)";
          header("refresh:0;url=../login/login.php");
          unset($_SESSION['firstname']);
          unset($_SESSION['lastname']);
          unset($_SESSION['email']);
          unset($_SESSION['password']);
        }
        else {
          echo"<script> alert('Something wrong went.')</script>";
        }
      }
    }
  }
  else{
    $message = "You do not have access to this page.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh:0;url=register.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Singhal Bank</title>
  <link rel="icon" href="../img/l.png" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/response.css">
<link rel="stylesheet" href="../css/style.css">

<script>
var filter_phone = /^[0-9]{10}$/;
var filter_bday = /^(?:0[1-9]|[12]\d|3[01])([\/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/;
var filter_pid = /^[0-9]{9}$|^[0-9]{12}$/;
var filter_var = /^[A-Za-z\s]+$/;
var filter_addr = /^[[A-Za-z\d\s,./]+$/;
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
function checkAll() {
	if( checkPhone() && checkPid() && checkAddr() && checkDistrict() && checkCity() && checkCountry() && checkNationality())
	{
	return true; }
	else
	{
		alert ("Please enter all information correctly!");
		return false;
	}
}
function checkPhone(){
	var phone = document.getElementById("phone").value;
	if ( !filter_phone.test(phone)){
	  document.getElementById("msgPhone").innerHTML = "Invalid mobile phone!";
	  return false;
	}
	else {
	  document.getElementById("msgPhone").innerHTML ="";
	  return true;

	}
}

function checkPid(){
	var pid = document.getElementById("person_id").value;
	if ( !filter_pid.test(pid)){
	  document.getElementById("msgPid").innerHTML = "Invalid personal id!";
	  return false;
	}
	else {
	  document.getElementById("msgPid").innerHTML ="";
	  return true;

	}
}
function checkAddr(){
	var addr = document.getElementById("address").value;
	if ( !filter_addr.test(addr)){
	  document.getElementById("msgAddr").innerHTML = "Invalid address!";
	  return false;
	}
	else {
	  document.getElementById("msgAddr").innerHTML ="";
	  return true;

	}
}
function checkDistrict(){
	var district = document.getElementById("district").value;
	if ( !filter_var.test(district)){
	  document.getElementById("msgDistrict").innerHTML = "Invalid input";
	  return false;
	}
	else {
	  document.getElementById("msgDistrict").innerHTML ="";
	  return true;

	}
}
function checkCity(){
	var city = document.getElementById("city").value;
	if ( !filter_var.test(city)){
	  document.getElementById("msgCity").innerHTML = "Invalid input";
	  return false;
	}
	else {
	  document.getElementById("msgCity").innerHTML ="";
	  return true;

	}
}
function checkCountry(){
	var country = document.getElementById("country").value;
	if ( !filter_var.test(country)){
	  document.getElementById("msgCountry").innerHTML = "Invalid input";
	  return false;
	}
	else {
	  document.getElementById("msgCountry").innerHTML ="";
	  return true;

	}
}
function checkNationality(){
	var nationality = document.getElementById("nationality").value;
	if ( !filter_var.test(nationality)){
	  document.getElementById("msgNationality").innerHTML = "Invalid input";
	  return false;
	}
	else {
	  document.getElementById("msgNationality").innerHTML ="";
	  return true;

	}
}
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="../img/lg.png" height="44" width="204.8">
  <a href="../index.html" class="active"><i class="fa fa-fw fa-home "></i>Home</a>
  <a href="../login/login.php" style="float: right"><i class="fa fa-fw fa-sign-in "></i>Login</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
  <center>
    <div style="background-color: #4CAF50; height: 80px; width: 100%; align-items: center; color: white "><h1>Registration : Step 2</h1>
  <p>* All Field are Mandatory</p></div>
  <br>
  <hr class="colorgraph">
  <form method="post" onsubmit=" return checkAll()" >
    <table width="80%" cellspacing="8">
      <col width="400">
      <col width="400">
      <tr>
        <td>
          <input type="text" name="phone" oninput="checkPhone()" class="question" id="phone" required autocomplete="off" />
          <label for="phone"><span>Mobile Number*</span></label>
          <div style="color: red;" id="msgPhone"></div>
        </td>
        <td>
          <select class="question" id="acc_type" name="acc_type" required autocomplete="off">
            <option value="saving">Saving Account</option>
            <option value="current">Currrent Account</option>
          </select>
          <label for="acc_type"><span>Account Type*</span></label>
        </td>
      </tr>
    </table>
    <table width="80%" cellspacing="8">
      <tr>
        <td>
          <label for="birthday">Your birthday*</label>
          <input type="date" name="birthday" class="question" id="birthday" min="1920-01-01" max="2004-12-31" required autocomplete="off" />
          <!--<div style="color: red;" id="msgBday"></div>-->
        </td>
      </tr>
    </table>
    <table width="80%" cellspacing="8">
      <tr>
        <td>
          <input type="text" name="person_id" oninput="checkPid()" class="question" id="person_id" required autocomplete="off" />
          <label for="person_id"><span>Personal ID *</span></label>
          <div style="color: red;" id="msgPid"></div>
        </td>
      </tr>
    </table>
    <table width="80%" cellspacing="8">
      <tr>
        <td>
          <select class="question" id="gender" name="gender" required autocomplete="off">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <label for="gender"><span>Gender*</span></label>
        </td>
        <td>
          <input type="text" name="address" oninput="checkAddr()" class="question" id="address" required autocomplete="off" />
          <label for="address"><span>Address *</span></label>
          <div style="color: red;" id="msgAddr"></div>
        </td>
        <td>
          <input type="text" name="district" oninput="checkDistrict()" class="question" id="district" required autocomplete="off" />
          <label for="district"><span>District *</span></label>
          <div style="color: red;" id="msgDistrict"></div>
        </td>
      </tr>
    </table>
    <table width="80%" cellspacing="8">
      <tr>
        <td>
          <input type="text" name="city" oninput="checkCity()" class="question" id="city" required autocomplete="off" />
          <label for="city"><span>City *</span></label>
          <div style="color: red;" id="msgCity"></div>
        </td>
        <td>
          <input type="text" name="country" oninput="checkCountry()" class="question" id="country" required autocomplete="off" />
          <label for="country"><span>Country *</span></label>
          <div style="color: red;" id="msgCountry"></div>
        </td>
        <td>
          <input type="text" name="nationality" oninput="checkNationality()" class="question" id="nationality" required autocomplete="off" />
          <label for="nationality"><span>Nationality*</span></label>
          <div style="color: red;" id="msgNationality"></div>
        </td>
      </tr>
    </table>
    <hr class="colorgraph">
    <table width="80%">
      <tr>
        <td align="center">
          <input type="submit" name="submit" value="REGISTER ME" style="height: 45px; width: 250px; font-size: 25px; color: white; background-color: #4CAF50">
        </td>
      </tr>
    </table>
  </form>
  </center>
</body>
</html>
