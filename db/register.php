<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$g11_connection = mysqli_connect("localhost", "root", "root", "bank");
$g11_con = mysqli_connect("localhost","root","root","transactions");
session_start();
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
    $msg = "<div class='alert alert-danger'>{$g11_email} - This email address has been already exists.</div>";
  } else {
    $g11_s = mysqli_multi_query($g11_connection, "insert into login(id, pwd, account_no) values ('$g11_email',  '$g11_password', '$g11_account_no'); insert into register(account_no, firstname, lastname, email, token phone, acc_type, birthday, person_id, gender, address, district, city, country, nationality) values ('$g11_account_no', '$g11_fname',  '$g11_lname',  '$g11_email',  '$g11_token', '$g11_phone',  '$g11_acc_type',  '$g11_birthday',  '$g11_person_id',  '$g11_gender',  '$g11_address',  '$g11_district',  '$g11_city',  '$g11_country',  '$g11_nationality'); insert into balance(account_no, balance, online_limit, card_limit, upi_limit, online_no, card_no, upi_no) values ('$g11_account_no', '1000', null, null, null, null, null, null);");
    $g11_c = mysqli_multi_query($g11_con, "create table `$g11_account_no`(`date` VARCHAR(10) NOT NULL ,`remark` VARCHAR(200) NOT NULL ,`debit` INT(6) NOT NULL ,`credit` INT(6) NOT NULL ,`balance` INT(8) NOT NULL); INSERT INTO `$g11_account_no` (date, remark, debit, credit, balance) VALUES('$g11_date', 'New Account', null, '1000', '1000');");
    if($g11_s && $g11_c) {
      $_SESSION['account_no'] = $g11_account_no;
      header("refresh:0;url=../login/login.php");
      unset($_SESSION['firstname']);
      unset($_SESSION['lastname']);
      unset($_SESSION['email']);
      unset($_SESSION['password']);

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
          $mail->Subject = 'no reply';
          $mail->Body    = 'Here is the verification link <b><a href="http://localhost/register/?verification='.$g11_token.'">http://localhost/register/?verification='.$g11_token.'</a></b>';

          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
      echo "</div>";
      $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
    }
    else {
      $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
    }
  }
}
?>
