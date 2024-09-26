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
  <title>UIT Bank</title>
  <link rel="icon" href="../asset/img/logo-uit.png" type="image/x-icon">
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
      if (isNaN(v)) {
        document.getElementById("msg").innerHTML = "Should be a Number";
      }
      else {
        document.getElementById("msg").innerHTML = "";
      }
    }
    function checkAccount() {
      var account = document.getElementById("account_noo").value;
      if (!filter_account.test(account)) {
        document.getElementById("account_noo").setCustomValidity("Invalid account number!");
        document.getElementById("account_noo").reportValidity();
        return false;
      }
      else {
        document.getElementById("account_noo").setCustomValidity("")
        return true;
      }
    }
    function checkAll() {
      if (checkAccount() && validate()) { return true; }
      else {
        alert("Please enter all information correctly!");
        return false;
      }
    }
  </script>
</head>

<body>
  <div id="header">
    <div class="header-content">
      <div class="home-direct">
        <a href="">
          <img src="../asset/img/banner_0.png" alt="" height="60">
        </a>
      </div>
      <div class="direct-container">
        <a class="direct-link" href="dashboard.php"><i class="fa fa-fw fa-calculator "></i>Dashboard</a>
        <a class="direct-link" href="profile.php" class="active"><i class="fa fa-fw fa-id-card-o "></i>Profile</a>
        <a class="direct-link" href="transfer.php"><i class="fa fa-fw fa-cogs "></i>Transfer</a>
        <a class="direct-link" href="transactions.php"><i class="fa fa-fw fa-file-text "></i>Transactions</a>
      </div>
      <div class="direct-container">
        <a class="direct-link " href="logout.php"><i class="fa fa-fw fa-sign-out "></i>Logout</a>
      </div>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <div class="transfer1 form-body">
    <div class="transfer1 transfer form-content">
      <div class="register2 user-profile form-title">
        <img src="../asset/img/logo-uit.png" alt="" width="30" height="30">
        <h2>UIT Bank</h2>
      </div>

      <form method="POST" onsubmit ="return checkAll()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-section transfer1">
        <div class="tab inner-form transfer1 transfer">
          <div class="transfer1 transfer inner-block input-account">
            <div class="transfer1 block-item block-column user-account">
              <input type="text" name="account_noo" placeholder=" " oninput="checkAccount()" class="transfer1 transfer question"
                id="account_noo" required autocomplete="off" />
              <label for="account_noo"><span>Account Number</span></label>
            </div>
            
            <!-- CHECK -->
            <div class="transfer1 block-item block-column">
              <input type="submit" value="Check" name="findName" class="transfer1 transfer input-btn" id="findName" />
            </div>
          </div>

          <!-- Display ten tài khoản nhận tiền -->
          <div class="transfer1 block-item block-column account-name">
            <h3 class="account-name-display">CHAU KHAC DAT</h3>
          </div>
          <!-- NEXT -->
          <div class="transfer1 block-item block-column next-btn">
            <input type="submit" value="Next" name="Next" class="transfer1 transfer input-next-btn input-btn" id="Next">
          </div>
        </div>

      </form>
    </div>
  </div>
</body>

</html>
