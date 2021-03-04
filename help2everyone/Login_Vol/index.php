<?php
include('./../inicligacao.ini');
include_once 'gpConfig.php';
$ermsg=false;
unset($_SESSION['tokens']);

//Reset OAuth access token
$gClient->revokeToken();
if((isset ($_SESSION['user']) == true)){
  session_destroy();
  unset($_SESSION['user']);
}else if ((isset ($_SESSION['nome']) == true)) {
  session_destroy();
  unset($_SESSION['nome']);
}
unset($_SESSION['tokens']);

//Reset OAuth access token
$gClient->revokeToken();
if ($_SERVER['REQUEST_METHOD']=='POST') {

  if (!empty($_POST['User'])) {
    $user=htmlspecialchars($_POST['User']);
  }
	if (!empty($_POST['Password'])) {
		$pass=htmlspecialchars($_POST['Password']);
		$pass=hash('sha256',$pass);
	}
	  $conta=mysqli_query($conn,"SELECT Id from tblvoluntario where Utilizador='".$user."' && Password='".$pass."'");
		$linha=mysqli_fetch_array($conta);

    if($linha[0]!=null){
      $_SESSION['user']=$user;
      header('Location: ./../index.php');
    }else{
      $ermsg=true;
    }

}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Login Voluntário</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/logo.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main1.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
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
				<form class="login100-form validate-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<span class="login100-form-title p-b-43">
						Entre na sua conta
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Inserir Utilizador">
						<input class="input100" type="text" value="<?php if(isset($user)){echo $user;} ?>" name="User" maxlength="100">
						<span class="focus-input100"></span>
						<span class="label-input100">Utilizador</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password requerida">
						<input class="input100" type="password" name="Password" maxlength="100">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<span class="txt2">
								Não tens conta:
							</span>
							<a href="./register.php" class="txt1">
								Regista-te!!!
							</a>

						</div>
            <div>
              <a class="txt1" href="./forgot.php">
                <i class="fa fa-key" aria-hidden="true"></i>
                Esqueceu palavra-passe?
              </a>
            </div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Entrar
						</button>
					</div>

					<div class="text-center p-t-30 p-b-20">
						<a class="txt1" href="./../index.php">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Sair
						</a>
					</div>

          <div class="text-center  p-b-20">
            <span class="txt2">
              Iniciar Sessão com:
            </span>
          </div>

          <div class="login100-form-social flex-c-m">
            <a href="index2.php" class="login100-form-social-item flex-c-m bg1 m-r-5">
              <img src="images/google.png">
            </a>
          </div>
				</form>

				<div class="login100-more" style="background-image: url('images/13.jpg');">
					<a href="./../index.php" class="tired">
					<img src="images/close.png">
					</a>
				</div>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<?php
include('./../fechligacao.ini');
?>
