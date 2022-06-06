<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_POST['sendOTP']))
{
	
	$g11_otp = rand(100000, 999999);
	$g11_debit_account = $_SESSION['account_no'];
	$g11_conn = mysqli_connect("localhost","root","root","bank");
	$g11_result = mysqli_query($g11_conn, "SELECT account_no FROM register WHERE account_no='$g11_debit_account'");
	$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
        $g11_count = mysqli_num_rows($g11_result);
	$g11_email = $g11_row["email"];
	require '../vendor/autoload.php';
	if ($g11_count > 0) {
        $query = mysqli_query($g11_connection, "UPDATE register SET token='{$g11_otp}' WHERE email='{$g11_email}'");
	if ($query) {   
		echo "<div style='display: none;'>";
            //Create an instance; passing `true` enables exceptions
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
              $mail->Subject = 'NO REPLY';
              $mail->Body    = $g11_otp." is your transfer verification code.";

              $mail->send();
              }
             catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";        
            echo "<script> alert(We've send a verification link on your email address.)</script>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$g11_email - This email address do not found.</div>";
    }
}
?>
