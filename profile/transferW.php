<?php
session_start();
$g11_account_nom = $_SESSION['account_no'];
$g11_con = mysqli_connect("localhost","root","12345678","bank");
$g11_connection = mysqli_connect("localhost","root","12345678","transactions");
$g11_resultm = mysqli_query($g11_con, "SELECT * FROM balance WHERE account_no = '$g11_account_nom'");
$g11_rowm = mysqli_fetch_array($g11_resultm,MYSQLI_ASSOC);
$g11_my_balance = $g11_rowm['balance'];
$g11_online_limit = $g11_rowm['online_limit'];
$g11_online_no = $g11_rowm['online_no'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $g11_account_noo = $_POST['account_noo'];
  $g11_amount = $_POST['amount'];
  $g11_resulto = mysqli_query($g11_con, "SELECT * FROM balance WHERE account_no = '$g11_account_noo'");
  $g11_count = mysqli_num_rows($g11_resulto);
  if($g11_count==1)
  {
    $g11_rowo = mysqli_fetch_array($g11_resulto,MYSQLI_ASSOC);
    $g11_other_balance = $g11_rowo['balance'];
    $g11_my_balance = $g11_my_balance - $g11_amount;
    $g11_other_balance = $g11_other_balance + $g11_amount;
    $g11_online_limit = $g11_online_limit - $g11_amount;
    $g11_online_no = $g11_online_no - 1;
    $g11_date = date("Y-m-d");
    $g11_remarkm = "transfer to ".$g11_account_noo;
    $g11_remarko = "from ".$g11_account_nom;
    $g11_c = mysqli_multi_query($g11_con, "update balance set balance = '$g11_my_balance', online_limit = '$g11_online_limit', online_no = '$g11_online_no' where account_no = '$g11_account_nom'; update balance set balance = $g11_other_balance where account_no = '$g11_account_noo';");
    $g11_s = mysqli_multi_query($g11_connection, "INSERT INTO `$g11_account_nom` (date, remark, debit, credit, balance) VALUES('$g11_date', '$g11_remarkm', '$g11_amount', null, '$g11_my_balance'); INSERT INTO `$g11_account_noo` (date, remark, debit, credit, balance) VALUES('$g11_date', '$g11_remarko', null, '$g11_amount', '$g11_other_balance');");
    if($g11_c && $g11_s) {header("refresh:0;url=success.html"); } else {echo "no";}
    }
  else {
    header("refresh:0;url=transferW.php");
  }
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
var filter_account = /^[0-9]{10}$/;
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
function validate() {
      var v = document.getElementById("amount").value;
      if(isNaN(v)) {
        document.getElementById("msg").innerHTML = "Should be a Number";
      }
      else {
        document.getElementById("msg").innerHTML = "";
      }
    }
function checkAccount(){
	var account = document.getElementById("account_noo").value;
	if ( !filter_account.test(account)){
	  document.getElementById("msgAccount").innerHTML = "Invalid account!";
	  return false;
	}
	else {
	  document.getElementById("msgAccount").innerHTML ="";
	  return true;

	}
}
function checkAll(){
	if(checkAccount() && validate())
	{ return true;}
	else {
	alert ("Please enter all information correctly!");
	return false;}
}
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img style="float:right; right:1" src="../img/lg.png" height="44" width="204.8">
  <a href="dashboard.php"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
  <a href="profile.php"><i class="fa fa-fw fa-id-card-o "></i>Profile</a>
  <a href="transfer.php" class="active"><i class="fa fa-fw fa-cogs "></i>Transfer Money</a>
  <a href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
  <a href="limit.php"><i class="fa fa-fw fa-sliders "></i>Set Limit</a>
  <a href="logout.php" style="float: right"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
<center>
  <div style="background-color: #4CAF50; height: 45px; width: 100%; color: white; "><h1>Transfer Money</h1></div>
  <br>
  <div><p style="color: red">Account Number do not Exist</p></div>
  <form method="POST" onsubmit ="return checkAll()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table width="40%">
      <tr>
	<td>
          <input type="text" name="account_noo" oninput="checkAccount()"class="question" id="account_noo" required autocomplete="off" />
          <label for="account_noo"><span>Account Number</span></label>
          <div style="color: red;" id="msgAccount"></div>
        </td>
      </tr>
    </table>
    <table width="40%">
      <tr>
        <td>
          <input type="text" name="amount" class="question" id="amount" required autocomplete="off" oninput="validate()" />
          <label for="amount"><span>Amount(in Rs.)</span></label>
          <div style="color: red;" id="msg"></div>
        </td>
      </tr>
    </table>
    <br>
    <table width="80%">
      <tr>
        <td align="right"><input type="submit" name="submit" value="PAY NOW" style="height: 40px; width: 150px; font-size: 20px; color: white; background-color: #4CAF50"></td>
      </tr>
    </table>
  </form>
</center>
</body>
</html>
