<?php
$g11_id = $_POST['id'];
$g11_password = $_POST['password'];
$g11_secretSalt = "g11.uit.nt213.m21.antt";
$g11_message = $g11_secretSalt.$g11_id;
$g11_hashed = md5($g11_message);
$g11_encryptionMethod = "AES-256-CBC"; 

//To encrypt
$g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
session_start();
$g11_con = mysqli_connect("localhost","root","12345678","bank");
$g11_result = mysqli_query($g11_con, "SELECT * FROM login WHERE id='$g11_id' && pwd='$g11_crypt'");
$g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
$g11_accno = $g11_row['account_no'];
$g11_count = mysqli_num_rows($g11_result);
if($g11_count==1)
{
	$_SESSION['account_no'] = $g11_accno;
	header("location: ../profile/dashboard.php");
/*echo'
	<script type="text/javascript">
        sessionStorage.setItem("login", true);
        let data = sessionStorage.getItem("login");
	console.log(data);
        </script>';*/

}
else
{
	header("refresh:0;url=../login/loginW.html");
}
?>
