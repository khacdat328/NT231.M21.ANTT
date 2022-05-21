<?php
session_start();
$g11_account_no = $_SESSION['account_no'];
$g11_con = mysqli_connect("localhost","root","12345678","bank");
$g11_result = mysqli_query($g11_con, "SELECT * FROM register WHERE account_no = '$g11_account_no'");
$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
$g11_firstname = $g11_row['firstname'];
$g11_lastname = $g11_row['lastname'];
$g11_email = $g11_row['email'];
$g11_phone = $g11_row['phone'];
$g11_gender = $g11_row['gender'];
$g11_district = $g11_row['district'];
$g11_birthday = $g11_row['birthday'];
$g11_person_id = $g11_row['person_id'];
$g11_gender = $g11_row['gender'];
$g11_address = $g11_row['address'];
$g11_city = $g11_row['city'];
$g11_country = $g11_row['country'];
$g11_nationality = $g11_row['nationality'];
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
</script>
<style type="text/css">
  table { border: 1px solid black; border-collapse: collapse; }
  table td {border: 1px solid black; border-right: 1px solid white; border-left: 1px solid white}
</style>
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
  <div style="background-color: #4CAF50; height: 45px; width: 100%; color: white; "><h1>My Profile</h1></div>
  <table cellpadding="10">
    <col width="400">
    <col width="600">
    <tr>
      <td colspan="2" align="right" style="border-top: 1px solid white;"><input type="button" name="changepwd" value="CHANGE PASSWORD" onclick="window.location.href='password/password.php'" style="height: 40px; width: 180px; color: white; background-color: #cc33ff"><input type="button" name="editprofile" value="EDIT PROFILE" onclick="window.location.href='editprofile.php'" style="height: 40px; width: 150px; color: white; background-color: #cc33ff"></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>Name : </b></td>
      <td><?php echo $g11_firstname . " " . $g11_lastname ?></td>
    </tr>
    <tr>
      <td><b>Account Number : </b></td>
      <td><?php echo $g11_account_no ?></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>Email ID : </b></td>
      <td><?php echo $g11_email ?></td>
    </tr>
    <tr>
      <td><b>Phone Number : </b></td>
      <td><?php echo $g11_phone ?></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>Gender: </b></td>
      <td><?php echo $g11_gender ?></td>
    </tr>
    <tr>
      <td><b>Birthday : </b></td>
      <td><?php echo $g11_birthday ?></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>Person ID : </b></td>
      <td><?php echo $g11_person_id ?></td>
    </tr>
    <tr>
      <td><b>Address : </b></td>
      <td><?php echo $g11_address ?></td>
    </tr>
    <tr>
      <td><b>District : </b></td>
      <td><?php echo $g11_district ?></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>City : </b></td>
      <td><?php echo $g11_city ?></td>
    </tr>
    <tr>
      <td><b>Country : </b></td>
      <td><?php echo $g11_country ?></td>
    </tr>
    <tr bgcolor="#ffffe6">
      <td><b>Nationality : </b></td>
      <td><?php echo $g11_nationality ?></td>
    </tr>
  </table>
</center>
</body>
</html>
