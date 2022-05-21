<?php
  session_start();
  $g11_fname = $_SESSION['firstname'];
  $g11_lname = $_SESSION['lastname'];
  $g11_email = $_SESSION['email'];
  $g11_password = $_SESSION['password'];
    $_SESSION['firstname'] = $g11_fname;
    $_SESSION['lastname'] = $g11_lname;
    $_SESSION['email'] = $g11_email;
    $_SESSION['password'] = $g11_password;
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
	alert("Congratulations, you have successfully registered an account!"); 
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
  <a href="../login/login.html" style="float: right"><i class="fa fa-fw fa-sign-in "></i>Login</a>
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
  <form action="../db/register.php" method="post" onsubmit=" return checkAll()" >
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
