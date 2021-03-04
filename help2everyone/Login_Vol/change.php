<?php
include('./../inicligacao.ini');
$ermsg=false;
session_start();

  if((isset ($_SESSION['token']) == true)){
    $token=$_SESSION['token'];

    $verificar=mysqli_query($conn,"select * from tblrecuperarvol where Token='".$token."'");
    $con=mysqli_fetch_array($verificar);
    $IdVoluntario=htmlspecialchars($con['IdVoluntario']);

    $verificare=mysqli_query($conn,"select * from tblvoluntario where Id=".$IdVoluntario);
    $cone=mysqli_fetch_array($verificare);
    $user=htmlspecialchars($cone['Utilizador']);
    $nome=htmlspecialchars($cone['Nome']);
    $apelido=htmlspecialchars($cone['Apelido']);
    $email=htmlspecialchars($cone['Email']);

    if($IdVoluntario==null){
      header('Location: ./index.php');
    }

  }else{
    session_destroy();
    unset($_SESSION['token']);
    header('Location: ./index.php');
  }

  if ($_SERVER['REQUEST_METHOD']=='POST') {

    if (!empty($_POST['Password'])) {
  		$pass=htmlspecialchars($_POST['Password']);
      $pass=hash('sha256', $pass);
  	}
    if (!empty($_POST['ConfirmarPassword'])) {
      $conpass=htmlspecialchars($_POST['ConfirmarPassword']);
      $conpass=hash('sha256', $conpass);
    }

    $pass1=hash('sha256', '1234');
    $pass2=hash('sha256', '4321');
    $pass3=hash('sha256', '123456');
    $pass4=hash('sha256', '654321');
    $pass5=hash('sha256', $user);
    $pass6=hash('sha256', $nome);
    $pass7=hash('sha256', $apelido);
    $pass8=hash('sha256', $email);

    if($pass==$pass1 or $pass==$pass2 or $pass==$pass3 or $pass==$pass4 or $pass==$pass5 or $pass==$pass6 or $pass==$pass7 or $pass==$pass8 ){
      $ermsg=2;
    }else if($pass!=$conpass){
      $ermsg=3;
    }else{
      mysqli_query($conn,"update tblvoluntario set Password='".$pass."' where Id=".$IdVoluntario);
      mysqli_query($conn,"delete from tblrecuperarvol where IdVoluntario=".$IdVoluntario);
      $_SESSION['user']=$user;
      header('Location: ./../index.php');

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
  if($ermsg==2){
		echo "<div class='alert alert-warning' role='alert'>
					Palavra-Passe fraca!!!
					</div>";
	}else if($ermsg==3){
		echo "<div class='alert alert-warning' role='alert'>
					As Palavras-Passe não coincidem, por favor tente novamente!!!
					</div>";
	}
  ?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<span class="login100-form-title p-b-43">
						Mude a sua Palavra-Passe!
					</span>

          <div class="wrap-input100 validate-input" data-validate="Password requerida">
						<input class="input100" type="password" name="Password" maxlength="100">
						<span class="focus-input100"></span>
						<span class="label-input100">Palavra-Passe</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password requerida">
						<input class="input100" type="password" name="ConfirmarPassword" maxlength="100">
						<span class="focus-input100"></span>
						<span class="label-input100">Confirmar Palavra-Passe</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Atualizar Dados
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<a class="txt1" href="./index.php">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Sair
						</a>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('images/13.jpg');">
          <a href="./index.php" class="tired">
					<img src="images/back.png">
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
