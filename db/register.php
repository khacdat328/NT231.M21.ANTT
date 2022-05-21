<?php
$g11_connection = mysqli_connect("localhost", "root", "12345678", "bank");
$g11_con = mysqli_connect("localhost","root","12345678","transactions");
session_start();
if(isset($_POST['submit'])){
  $g11_fname = $_SESSION['firstname'];
  $g11_lname = $_SESSION['lastname'];
  $g11_email = $_SESSION['email'];
  $g11_password = $_SESSION['password'];
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
  $g11_s = mysqli_multi_query($g11_connection, "insert into login(id, pwd, account_no) values ('$g11_email',  '$g11_password', '$g11_account_no'); insert into register(account_no, firstname, lastname, email, phone, acc_type, birthday, person_id, gender, address, district, city, country, nationality) values ('$g11_account_no', '$g11_fname',  '$g11_lname',  '$g11_email',  '$g11_phone',  '$g11_acc_type',  '$g11_birthday',  '$g11_person_id',  '$g11_gender',  '$g11_address',  '$g11_district',  '$g11_city',  '$g11_country',  '$g11_nationality'); insert into balance(account_no, balance, online_limit, card_limit, upi_limit, online_no, card_no, upi_no) values ('$g11_account_no', '1000', null, null, null, null, null, null);");
  $g11_c = mysqli_multi_query($g11_con, "create table `$g11_account_no`(`date` VARCHAR(10) NOT NULL ,`remark` VARCHAR(200) NOT NULL ,`debit` INT(6) NOT NULL ,`credit` INT(6) NOT NULL ,`balance` INT(8) NOT NULL); INSERT INTO `$g11_account_no` (date, remark, debit, credit, balance) VALUES('$g11_date', 'New Account', null, '1000', '1000');");
  if($g11_s && $g11_c) {
    $_SESSION['account_no'] = $g11_account_no;
    header("refresh:0;url=../profile/dashboard.php");
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    }
  else {
  	print(c);
  }
}
?>
