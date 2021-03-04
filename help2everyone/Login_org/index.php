<?php
include('./../inicligacao.ini');
$ermsg=false;
session_start();

if((isset ($_SESSION['nome']) == true)){
  session_destroy();
  unset($_SESSION['nome']);
}else if ((isset ($_SESSION['user']) == true)) {
  session_destroy();
  unset($_SESSION['user']);
}

if ($_SERVER['REQUEST_METHOD']=='POST') {

  if (!empty($_POST['Email'])) {
    $email=htmlspecialchars($_POST['Email']);
  }
	if (!empty($_POST['Password'])) {
		$pass=htmlspecialchars($_POST['Password']);
		$pass=hash('sha256',$pass);
	}
	  $conta=mysqli_query($conn,"SELECT Nome from tblorganizacao where Email='".$email."' && Password='".$pass."'");
		$linha=mysqli_fetch_array($conta);

    if($linha[0]!=null){
      $_SESSION['nome']=$linha[0];
      header('Location: ./../index.php');
    }else{
      $ermsg=true;
    }

}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Login Organização</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/logo.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php
  if($ermsg==true){
    echo "<div class='alert alert-warning' role='alert'>
          Utilizador/Palavra-Passe Inválidos!!!
          </div>";
  }
  ?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<span class="login100-form-title">
						Entre na sua conta
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" value="<?php if(isset($email)){echo $email;} ?>" name="Email" placeholder="Email" maxlength="100">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" maxlength="100" name="Password" placeholder="Password" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Entrar
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Esqueceu:
						</span>
						<a class="txt2" href="forgot.php">
							Password?
						</a>
					</div>
					<div class="text-center p-t-136">
						<a class="txt2" href="./../index.php">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Sair
						</a>
					</div>

					<div class="text-center">
						<a class="txt2" href="./registar.php">
							Registe uma conta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<?php
include('./../fechligacao.ini');
?>
