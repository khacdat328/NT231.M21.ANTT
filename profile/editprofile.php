<?php
session_start();
$g11_account_no = $_SESSION['account_no'];
$g11_con = mysqli_connect("localhost","root","12345678","bank");
$g11_result = mysqli_query($g11_con, "SELECT * FROM register WHERE account_no = '$g11_account_no'");
$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
$g11_firstname = $g11_row['firstname'];
$g11_lastname = $g11_row['lastname'];
/*$g11_email = $g111_row['email'];*/
$g11_phone = $g11_row['phone'];
$g11_birthday = $g11_row['birthday'];
$g11_person_id = $g11_row['person_id'];
$g11_gender = $g11_row['gender'];
$g11_address = $g11_row['address'];
$g11_district = $g11_row['district'];
$g11_city = $g11_row['city'];
$g11_country = $g11_row['country'];
$g11_nationality = $g11_row['nationality'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $g11_firstname = $_POST['firstname'];
  $g11_lastname = $_POST['lastname'];
  /*$g11_email = $_POST['email'];*/
  $g11_phone = $_POST['phone'];
  $g11_birthday = $_POST['birthday'];
  $g11_person_id = $_POST['person_id'];
  $g11_gender = $_POST['gender'];
  $g11_address = $_POST['address'];
  $g11_district = $_POST['district'];
  $g11_city = $_POST['city'];
  $g11_country = $_POST['country'];
  $g11_nationality = $_POST['nationality'];
  $g11_c = mysqli_multi_query($g11_con, "update register set firstname = '$g11_firstname', lastname = '$g11_lastname', phone = '$g11_phone', birthday = '$g11_birthday', person_id = '$g11_person_id', gender = '$g11_gender', address = '$g11_address', district = '$g11_district', city = '$g11_city', country = '$g11_country', nationality = '$g11_nationality' where account_no = '$g11_account_no';");
  if($g11_c) {header("refresh:0;url=profile.php"); } else { echo "no";}
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
var filter_phone = /^[0-9]{10}$/;
/*var filter_bday = /^(?:0[1-9]|[12]\d|3[01])([\/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/;*/
var filter_pid = /^[0-9]{9}$|[0-9]{12}$/;
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
function checkAll(){
	if(checkfName() && checklName() && checkEmail() && checkPhone() && checkPid() && checkAddr() && checkDistrict() && checkCity() && checkCountry() && checkNationality() )
	{ return true; }
	else { 
		alert ("Please enter all information correctly!");
		return false;
	}
}
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img style="float:right; right:1" src="../img/lg.png" height="44" width="204.8">
  <a href="dashboard.php"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
  <a href="profile.php" class="active"><i class="fa fa-fw fa-id-card-o "></i>Profile</a>
  <a href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer Money</a>
  <a href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
  <a href="limit.php"><i class="fa fa-fw fa-sliders "></i>Set Limit</a>
  <a href="logout.php" style="float: right"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
<center>
  <div style="background-color: #4CAF50; height: 45px; width: 100%; color: white; "><h1>Edit Profile</h1></div>
  <form method="POST" onsubmit=" return checkAll()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table width="80%">
      <tr>
        <td>
          <input type="text" name="firstname" oninput="checkfName()" class="question" id="firstname" value="<?php echo $g11_firstname ?>" required autocomplete="off" />
          <label for="firstname"><span>First Name*</span></label>
          <div style="color: red;" id="msgName1"></div>
        </td>
        <td>
          <input type="text" name="lastname" oninput="checklName()" class="question" id="lastname" value="<?php echo $g11_lastname ?>" required autocomplete="off" />
          <label for="lastname"><span>Last Name*</span></label>
          <div style="color: red;" id="msgName2"></div>
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
      <tr>
<!--        <td>
          <input type="text" name="email" oninput="checkEmail()" class="question" id="email" value="<?php echo $g11_email ?>" required autocomplete="off" />
          <label for="email"><span>Email*</span></label>
          <div style="color: red;" id="msgEmail"></div>
        </td>-->
        <td>
          <input type="text" name="phone" oninput="checkPhone()" class="question" id="phone" value="<?php echo $g11_phone ?>" required autocomplete="off" />
          <label for="phone"><span>Mobile Number*</span></label>
          <div style="color: red;" id="msgPhone"></div>
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
      <tr>
        <td>
          <label for="birthday">Your birthday*</label>
          <input type="date" name="birthday" class="question" id="birthday" min="1920-01-01" max="2004-12-31" required autocomplete="off" />
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
      <tr>
        <td>
          <input type="text" name="person_id" oninput="checkPid()" class="question" id="person_id" value="<?php echo $g11_person_id ?>" required autocomplete="off" />
          <label for="person_id"><span>Person ID *</span></label>
          <div style="color: red;" id="msgPid"></div>
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
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
          <input type="text" name="address" oninput="checkAddr()" class="question" id="address" value="<?php echo $g11_address ?>" required autocomplete="off" />
          <label for="address"><span>Address *</span></label>
          <div style="color: red;" id="msgAddr"></div>
        </td>
        <td>
          <input type="text" name="district" oninput="checkDistrict()" class="question" id="district" value="<?php echo $g11_district ?>" required autocomplete="off" />
          <label for="district"><span>District *</span></label>
          <div style="color: red;" id="msgDistrict"></div>
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
      <tr>
        <td>
          <input type="text" name="city" oninput="checkCity()" class="question" id="city" value="<?php echo $g11_city ?>" required autocomplete="off" />
          <label for="city"><span>City *</span></label>
          <div style="color: red;" id="msgCity"></div>
        </td>
        <td>
          <input type="text" name="country" oninput="checkCountry()" class="question" id="country" value="<?php echo $g11_country ?>" required autocomplete="off" />
          <label for="country"><span>Country *</span></label>
          <div style="color: red;" id="msgCountry"></div>
        </td>
        <td>
          <input type="text" name="nationality" oninput="checkNationality()" class="question" id="nationality" value="<?php echo $g11_nationality ?>" required autocomplete="off" />
          <label for="nationality"><span>Nationality *</span></label>
          <div style="color: red;" id="msgNationality"></div>
        </td>
      </tr>
    </table>
    <hr width="80%">
    <table width="80%">
      <tr>
        <td colspan="2" align="right" style="border-top: 1px solid white;"><input type="submit" name="submit" value="SUBMIT" style="height: 40px; width: 150px; color: white; background-color: #4CAF50"></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>
