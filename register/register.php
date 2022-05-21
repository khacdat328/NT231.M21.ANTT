<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $g11_fname = $_POST['firstname'];
  $g11_lname = $_POST['lastname'];
  $g11_email = $_POST['email'];
  $g11_password = $_POST['password'];
$g11_secretSalt = "g11.uit.nt213.m21.antt";
$g11_message = $g11_secretSalt.$g11_email;
$g11_hashed = md5($g11_message);
$g11_encryptionMethod = "AES-256-CBC"; 

//To encrypt
$g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
  session_start();
    $_SESSION['firstname'] = $g11_fname;
    $_SESSION['lastname'] = $g11_lname;
    $_SESSION['email'] = $g11_email;
    $_SESSION['password'] = $g11_crypt;
    header("refresh:0;url=register2.php");
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
	var filter_name = /^[A-Za-z\s]+$/;
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
function checkAll(){
	if(validate() && checkfName() && checklName() && checkEmail() && checkPwd() )
	{ return true; }
	else { 
		alert ("Please enter all information correctly!");
		return false;
	}
}

function validate() {
      var v1 = document.getElementById("password").value;
      var v2 = document.getElementById("password_confirmation").value;
      if(v1 != v2) {
        document.getElementById("msg").innerHTML = "Password do not match";
        return false;
      }
      else {
        document.getElementById("msg").innerHTML = "";
        return true;
      }
    }
function checkfName(){
	var fname = document.getElementById("firstname").value;
	if ( !filter_name.test(fname)){
	  document.getElementById("msgName1").innerHTML = "Username must have alphabet characters only";
	  return false;
	}
	else {
	  document.getElementById("msgName1").innerHTML ="";
	  return true;

	}
}
function checklName(){
	var lname = document.getElementById("lastname").value;
	if ( !filter_name.test(lname)){
	  document.getElementById("msgName2").innerHTML = "Username must have alphabet characters only";
	  return false;
	}
	else {
	  document.getElementById("msgName2").innerHTML ="";
	  return true;
	}
}
function checkEmail(){
	var email = document.getElementById("email").value;
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
	  document.getElementById("msgPwd").innerHTML = "Password must contain at least one number, one special character, one uppercase and lowercase letter, and at least 8 or more characters";
	  return false;
	}
	else {
	  document.getElementById("msgPwd").innerHTML ="";
	  return true;
	}
}
/*
function next(){
	if( validate() && checkfName() && checklName() && checkEmail())
	{
		return true;
	}
	else{
	    return header("refresh:0;url=register.php");
	  }
	}*/	
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="../img/lg.png" height="44" width="204.8">
  <a href="../index.html" class="active"><i class="fa fa-fw fa-home "></i>Home</a>
  <a href="../login/login.html" style="float: right"><i class="fa fa-fw fa-sign-in "></i>Login</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
  <center>
    <div style="background-color: #4CAF50; height: 80px; width: 100%; align-items: center; color: white "><h1>New User Registration</h1>
  <p>* All Field are Mandatory</p></div>
  <br><br>
  <hr class="colorgraph">
  <form name = "Register" method="POST" onsubmit ="return checkAll()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table cellspacing="20">
      <col width="400">
      <tr>
        <td>
          <input type="text" name="firstname" oninput="checkfName()" class="question" id="firstname" required autocomplete="off" />
          <label for="firstname"><span>First Name*</span></label>
          <div style="color: red;" id="msgName1"></div>
        </td>
        <td>
          <input type="text" name="lastname" oninput="checklName()" class="question" id="lastname" required autocomplete="off"/>
          <label for="lastname"><span>Last Name*</span></label>
          <div style="color: red;" id="msgName2"></div>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="text" name="email" oninput="checkEmail()" class="question" id="email" required autocomplete="off" />
          <label for="email"><span>Email Address*</span></label>
          <div style="color: red;" id="msgEmail"></div>
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="password" oninput="checkPwd()" class="question" id="password" required autocomplete="off" />
          <label for="password"><span>Password*</span></label>
          <div style="color: red;" id="msgPwd"></div>
        </td>
        <td>
          <input type="password" name="password_confirmation" oninput="validate()" class="question" id="password_confirmation" required autocomplete="off" />
          <label for="password_confirmation"><span>Confirm Password*</span></label>
          <div style="color: red;" id="msg"></div>
        </td>
      </tr>
      <tr>
        <td><a style="color: blue" onmouseover="this.style.color = 'red'" onmouseleave="this.style.color = 'blue'" href="../login/login.html">Already A User?</a></td>
      </tr>
    </table>
    <hr class="colorgraph">
    <br>
    <input type="submit" name="submit" id = "next" value="NEXT" style="height: 45px; width: 250px; font-size: 25px; color: white; background-color: #4CAF50">
  </form>
  </center>
</body>
</html>
