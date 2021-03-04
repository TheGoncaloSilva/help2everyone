<?php
include('./../inicligacao.ini');
$ermsg=false;
session_start();

  if((isset ($_SESSION['tokenorg']) == true)){
    $token=$_SESSION['tokenorg'];

    $verificar=mysqli_query($conn,"select * from tblrecuperarorg where Token='".$token."'");
    $con=mysqli_fetch_array($verificar);
    $IdOrganizacao=htmlspecialchars($con['IdOrganizacao']);

    $verificare=mysqli_query($conn,"select * from tblorganizacao where Id=".$IdOrganizacao);
    $cone=mysqli_fetch_array($verificare);
    $nome=htmlspecialchars($cone['Nome']);
    $email=htmlspecialchars($cone['Email']);

    if($IdOrganizacao==null){
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
    $pass6=hash('sha256', $nome);
    $pass8=hash('sha256', $email);

    if($pass==$pass1 or $pass==$pass2 or $pass==$pass3 or $pass==$pass4 or $pass==$pass6 or $pass==$pass8 ){
      $ermsg=2;
    }else if($pass!=$conpass){
      $ermsg=3;
    }else{
      mysqli_query($conn,"update tblorganizacao set Password='".$pass."' where Id=".$IdOrganizacao);
      mysqli_query($conn,"delete from tblrecuperarorg where IdOrganizacao=".$IdOrganizacao);
      $_SESSION['nome']=$nome;
      header('Location: ./../index.php');

    }

  }

?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Registar Organização</title>
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
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<span class="login100-form-title">
						Recupere a Palavra-Passe!!!
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Password requerida">
            <input class="input100" type="password" name="Password" placeholder="Palavra-Passe" minlength=4 maxlength="100">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

          <div class="wrap-input100 validate-input" data-validate = "Password requerida">
            <input class="input100" type="password" name="ConfirmarPassword" placeholder="Confirme a Palavra-Passe" minlength=4 maxlength="100">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Atualizar
						</button>
					</div>

					<div class="text-center p-t-12">
						<i class="fa fa-arrow-left" aria-hidden="true"></i>
						<a class="txt2" href="./index.php">
							Login
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
