<?php

$msg = "";

$g11_connection = mysqli_connect("localhost", "root", "root", "bank");

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($g11_connection, "SELECT * FROM register WHERE token='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
          $g11_result = mysqli_query($g11_connection, "SELECT * FROM register WHERE token = '{$_GET['reset']}'");
	  $g11_row = mysqli_fetch_array($g11_result,MYSQLI_ASSOC);
	  	  $g11_email = $g11_row['email'];
            $g11_secretSalt = "g11.uit.nt213.m21.antt";
	    $g11_message = $g11_secretSalt.$g11_email;
            $g11_hashed = md5($g11_message);
            $g11_encryptionMethod = "AES-256-CBC"; 

//To encrypt
	    $g11_password = $_POST['password'];
            $g11_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_password);
            $g11_confirm_password = $_POST['confirm-password'];
	    $g11_confirm_crypt = openssl_encrypt($g11_hashed, $g11_encryptionMethod, $g11_confirm_password);
            if ($g11_crypt === $g11_confirm_crypt) {
                $query = mysqli_multi_query($g11_connection, "UPDATE login SET pwd='{$g11_crypt}'; UPDATE register SET token='' WHERE token='{$_GET['reset']}'");

                if ($query) {
                    header("refresh:0;url=../login/login.php");
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    header("Location: forgot-pwd.php");
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form - Brave Coder</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css1/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script>
	var filter_password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#\$%\^&\*]).{8,}$/;
	function myFunction() {
    	var x = document.getElementById("myTopnav");
    	if (x.className === "topnav") {
        	x.className += " responsive";
    	} else {
        	x.className = "topnav";
    	}
	}
	function validate() {
      var v1 = document.getElementById("new_password").value;
      var v2 = document.getElementById("new_password_confirmation").value;
      if(v1 != v2) {
        document.getElementById("msg").innerHTML = "Password do not match";
        return false;
      }
      else {
        document.getElementById("msg").innerHTML = "";
        return true;
      }
    }
    function checkPwd(){
	var pwd = document.getElementById("new_password").value;
	if ( !filter_password.test(pwd)){
	  document.getElementById("msgPwd").innerHTML = "Password must contain at least one number, one special character, one uppercase and lowercase letter, and at least 8 or more characters";
	  return false;
	}
	else {
	  document.getElementById("msgPwd").innerHTML ="";
	  return true;
	}
}
function checkAll(){
	if(checkPwd() && validate())
	{ return true;}
	else {
	alert ("Please enter all information correctly!");
	return false;}
}
</script>
</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image3.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Change Password</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                        <?php echo $msg; ?>
                        <form action="" onsubmit ="return checkAll()" method="post">
                            <input type="password" class="password" name="password" oninput="checkPwd()" id="new_password" placeholder="Enter Your Password" required>
                            <div style="color: red;" id="msgPwd"></div>
                            <input type="password" class="confirm-password" name="confirm-password" oninput="validate()" id="new_password_confirmation" placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Change Password</button>
                            <div style="color: red;" id="msg"></div>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>
