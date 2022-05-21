<?php
session_start();
if(isset($_SESSION['account_no'])){
$g11_account_no = $_SESSION['account_no'];
$g11_con = mysqli_connect("localhost","root","12345678","bank");
$g11_resultb = mysqli_query($g11_con, "SELECT * FROM balance WHERE account_no = '$g11_account_no'");
$g11_resultr = mysqli_query($g11_con, "SELECT * FROM register WHERE account_no = '$g11_account_no'");
$g11_rowb = mysqli_fetch_array($g11_resultb,MYSQLI_ASSOC);
$g11_rowr = mysqli_fetch_array($g11_resultr,MYSQLI_ASSOC);
$g11_balance = $g11_rowb['balance'];
$g11_online_limit = $g11_rowb['online_limit'];
$g11_card_limit = $g11_rowb['card_limit'];
$g11_firstname = $g11_rowr['firstname'];
$g11_lastname = $g11_rowr['lastname'];
echo'
	<script type="text/javascript">
        sessionStorage.setItem("login", true);
        </script>';
}
else {
	header("refresh:0;url=../login/loginW.html");
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
<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
let data = sessionStorage.getItem("login");
console.log(data);
</script>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img style="float:right; right:1" src="../img/lg.png" height="44" width="204.8">
  <a href="dashboard.php" class="active"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
  <a href="profile.php"><i class="fa fa-fw fa-id-card-o "></i>Profile</a>
  <a href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer Money</a>
  <a href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
  <a href="limit.php"><i class="fa fa-fw fa-sliders "></i>Set Limit</a>
  <a href="logout.php" style="float: right"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
<h4 align="right" style="color: red; width: 95%">Welcome <?php echo $g11_firstname . " " . $g11_lastname ?></h4>
<center><table bgcolor="#ffe6e6">
  <col width="869">
  <tr>
    <td>
      <h2 align="center">My Bank Account</h2>
    </td>
  </tr>
</table>
<table bgcolor="#ffe6e6" cellspacing="80">
  <tr>
    <td>
      <table style="border-collapse: collapse; border: 1px solid black">
        <col width="80">
        <col width="200">
        <tr>
          <td><img src="../img/d1.jpg" height="110px"; width="110px"></td>
          <td ><center><h4>My Balance</h4><p id="balance">Rs. <?php echo $g11_balance ?></p></center></td>
        </tr>
      </table>
    </td>
    <td>
      <table style="border-collapse: collapse; border: 1px solid black">
        <col width="80">
        <col width="200">
        <tr>
          <td><img src="../img/d2.jpg" height="110px"; width="110px"></td>
          <td ><center><h4>Total Limit</h4><p id="tlimit">Rs. <?php echo $g11_online_limit + $g11+card_limit ?></p></center></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table style="border-collapse: collapse; border: 1px solid black">
        <col width="80">
        <col width="200">
        <tr>
          <td><img src="../img/d3.jpg" height="110px"; width="110px"></td>
          <td ><center><h4>Online Transaction Limit</h4><p id="olimit">Rs. <?php echo $g11_online_limit ?></p></center></td>
        </tr>
      </table>
    </td>
    <td>
      <table style="border-collapse: collapse; border: 1px solid black">
        <col width="80">
        <col width="200">
        <tr>
          <td><img src="../img/d4.jpg" height="110px"; width="110px"></td>
          <td ><center><h4>Card Limit</h4><p id="climit">Rs. <?php echo $g11_card_limit ?></p></center></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
</body>
</html>
