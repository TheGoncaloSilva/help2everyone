<?php
include('./../inicligacao.ini');
include('./../classes/Mail.php');
$ermsg=0;
session_start();

if ($_SERVER['REQUEST_METHOD']=='POST') {
  if (!empty($_POST['Email'])) {
    $email=htmlspecialchars($_POST['Email']);
  }
  $cstrong=True;
  $token=bin2hex(openssl_random_pseudo_bytes(64,$cstrong));

  $emailinc=mysqli_query($conn,"SELECT Id FROM tblorganizacao WHERE Email='".$email."'");
  $coluna=mysqli_fetch_array($emailinc);
  if($coluna[0]!=null){
    mysqli_query($conn,"insert into tblrecuperarorg(Token, IdOrganizacao) values('".$token."', ".$coluna[0].")");
    Mail::sendMail('Esqueceste-te da Palavra-Passe?',"Para Atualizar a Palavra-Passe da sua conta de Organizacao no Help2Everyone, por favor, abra o <a href='http://127.0.0.1/help2everyone/help2everyone/Login_org/redirect.php?token=$token'>Link</a> e siga os passos lá indicados</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver desejado, simplesmente ignore-o ou apague-o.)</p>",$email);
    $ermsg=1;
  }else{
    $ermsg=2;
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
  if($ermsg==1){
		echo "<div class='alert alert-warning' role='alert'>
					Email Enviado com sucesso, verifique e siga os passos indicados!!!
					</div>";
	}else if($ermsg==2){
		echo "<div class='alert alert-warning' role='alert'>
					Email Não registado!!!
					</div>";
	}
  else if($ermsg==3){
		echo "<div class='alert alert-warning' role='alert'>
					Email não enviado, caso o erro persista contacte o administrador de sistema!!!
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

          <?php
          if($ermsg==1){
            echo "<p class='mb-4 text-center'>O Email foi enviado para a tua conta com sucesso, caso queiras enviar outra vez, clica em 'Recuperar' para enviar novamente!</p>";
          }else{
            echo "<p class='mb-4 text-center font-weight-normal'>Nós compreendemos, situações acontecem. Introduz o email e enviaremos uma ligação para recuperar a Palavra-Passe!</p>";
          }
          ?>


					<div class="wrap-input100 validate-input" data-validate = "Email válido requerido: ex@abc.xyz">
						<input class="input100" type="text" name="Email" value="<?php if(isset($email)){echo $email;} ?>" placeholder="Insira o Email" maxlength="100">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Recuperar
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
