<?php
if(isset($_SESSION['account_no'])){
	header("refresh:0;url=../profile/dashboard.php");
}
else{
	$g11_con = mysqli_connect("localhost","root","root","bank");
	if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($g11_con, "SELECT * FROM register WHERE token='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($g11_con, "UPDATE register SET token='', status='1' WHERE token='{$_GET['verification']}'");
            
            if ($query) {
                echo"<script>alert('Account verification has been successfully completed.')</script>";
                header("refresh:0;url=../login.php");
                
            }
        } else {
            header("refresh:0;url=../login.php");
        }
    }
}
if (isset($_POST['submit'])) {
  $g11_con = mysqli_connect("localhost","root","root","bank");
	$g11_id = $_POST['id'];
	$g11_password = $_POST['password'];
	$g11_secretSalt = "g11.uit.nt213.m21.antt";
	$g11_message = $g11_secretSalt.$g11_id;
	$g11_hashed = md5($g11_message);
	$g11_encryptionMethod = "AES-256-CBC"; 

	//To encrypt
	$g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
	session_start();
	$g11_result = mysqli_query($g11_con, "SELECT * FROM login WHERE id='$g11_id' && pwd='$g11_crypt'");
  $g11_result2 = mysqli_query($g11_con,"SELECT * FROM register WHERE email='$g11_id'");
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
  $g11_row2 = mysqli_fetch_array($g11_result2,MYSQLI_ASSOC);
	$g11_accno = $g11_row['account_no'];
	$g11_count = mysqli_num_rows($g11_result);
	if($g11_count==1)
	{
    if (empty($g11_row2['token']) && $g11_row2['status'] == 1 ) {
      $_SESSION['account_no'] = $g11_accno;
      header("refresh:0;url=../profile/dashboard.php");
    } else {
        echo"<script>alert('First verify your account and try again.')</script>";
    }
	}
	else
	{
		header("refresh:0;url=../login/login.php");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>UIT BANK</title>
  <link rel="icon" href="../img/l.png" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/response.css">
<link rel="stylesheet" href="../css/style.css">

<script>
var filter_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var filter_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#\$%\^&\*]).{8,}$/;
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
function checkEmail(){
	var email = document.getElementById("id").value;
	if ( !filter_email.test(email)){
	  document.getElementById("msgEmail").innerHTML = "Invalid email address!";
	  return false;
	}
	else {
	  document.getElementById("msgEmail").innerHTML ="";
	  return true;
	}
}
function checkPwd(){
	var pwd = document.getElementById("password").value;
	if ( !filter_password.test(pwd)){
	  document.getElementById("msgPwd").innerHTML = "Invalid password!";
	  return false;
	}
	else {
	  document.getElementById("msgPwd").innerHTML ="";
	  return true;
	}
}
function checkAll(){
	if(checkEmail() && checkPwd())
	{ return true;}
	else {
	alert ("Please enter all information correctly!");
	return false;}
}
/*$(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });*/
/*if ( typeof(Storage) !== 'undefined') {
    // Khởi tạo sesionStorage
    sessionStorage.setItem('login',true);
} else {
    alert('Trình duyệt của bạn không hỗ trợ!');
}*/
</script>
</head>
<body>
<div class="topnav" id="myTopnav">
  <img src="../img/lg.png" height="44" width="204.8">
  <a href="../index.html" class="active"><i class="fa fa-fw fa-home "></i>Home</a>
  <a href="../register/register.php" style="float: right"><i class="fa fa-fw fa-sign-in "></i>Sign Up</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
  <center>
    <div style="background-color: #4CAF50; height: 45px; width: 100%; align-items: center; color: white; "><h1>Login</h1></div>
  <br><br>
  <hr class="colorgraph">
  <form method="post" onsubmit ="return checkAll()">
    <table cellspacing="25">
      <col width="80%">
      <tr>
        <td>
          <input type="text" name="id" oninput="checkEmail()" class="question" id="id" required autocomplete="off" />
          <label for="id"><span>Your email</span></label>
          <div style="color: red;" id="msgEmail"></div>
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="password" oninput="checkPwd()" class="question" id="password" required autocomplete="off" />
          <label for="password"><span>Password</span></label>
          <div style="color: red;" id="msgPwd"></div>
        </td>
      </tr>
      <tr>
        <td><a style="color: blue" onmouseover="this.style.color = 'red'" onmouseleave="this.style.color = 'blue'" href="../register/register.php">New User?</a></td>
        <td><a style="color: blue" onmouseover="this.style.color = 'red'" onmouseleave="this.style.color = 'blue'" href="../profile/forgot-pwd.php">Forgot password?</a></td>
      </tr>
    </table>
    <hr class="colorgraph">
    <br>
    <input type="submit" name="submit" value="Submit" style="height: 45px; width: 200px; font-size: 25px; color: white; background-color: #4CAF50">
  </form>
  </center>
</body>
</html>
