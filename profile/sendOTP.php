<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_POST['sendOTP']))
{
	
	$g11_otp = rand(100000, 999999);
	$_SESSION['otp'] = $g11_otp;
	$g11_debit_account = $_SESSION['account_no'];
	$g11_conn = mysqli_connect("localhost","nhom11","Thanh@19522235","bank2");
	$g11_result = mysqli_query($g11_conn, "SELECT * FROM register WHERE account_no = '$g11_debit_account'");
	$g11_row = mysqli_fetch_array($g11_result_sender_2,MYSQLI_ASSOC);
	$g11_email = $g11_row["email"];
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
              $mail->addAddress('19522235@gm.uit.edu.vn');

              //Content
              $mail->isHTML(true);                                  //Set email format to HTML
              $mail->Subject = 'NO REPLY';
              $mail->Body    = $g11_otp." is your transfer verification code.";

              $mail->send();
              }
            catch(Exception $e) {
                return;
            }  
	echo "OTP da duoc gui den gmail cua ban";
}
else
{
	echo "fail";
} 
?>
