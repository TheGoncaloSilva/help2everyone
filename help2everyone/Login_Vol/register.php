<?php
include('./../inicligacao.ini');
include('./../classes/Mail.php');

$ermsg=0;
session_start();
if ($_SERVER['REQUEST_METHOD']=='GET') {

  if (!empty($_GET['Nome'])) {
    $InserirNome=htmlspecialchars($_GET['Nome']);
  }
  if (!empty($_GET['Apelido'])) {
    $Inserirapelido=htmlspecialchars($_GET['Apelido']);
  }
  if (!empty($_GET['Email'])) {
    $Inseriremail=htmlspecialchars($_GET['Email']);
  }
	if (!empty($_GET['User'])) {
		$Inseriruser=htmlspecialchars($_GET['User']);
	}
}

if ($_SERVER['REQUEST_METHOD']=='POST') {


  if (!empty($_POST['Nome'])) {
    $nome=htmlspecialchars($_POST['Nome']);
    $InserirNome=htmlspecialchars($_POST['Nome']);
  }
  if (!empty($_POST['Apelido'])) {
    $apelido=htmlspecialchars($_POST['Apelido']);
    $Inserirapelido=htmlspecialchars($_POST['Apelido']);
  }
  if (!empty($_POST['Email'])) {
    $email=htmlspecialchars($_POST['Email']);
    $Inseriremail=htmlspecialchars($_POST['Email']);
  }
	if (!empty($_POST['User'])) {
		$user=htmlspecialchars($_POST['User']);
    $Inseriruser=htmlspecialchars($_POST['User']);
	}
	if (!empty($_POST['Pass'])) {
		$pass=htmlspecialchars($_POST['Pass']);
    $pass=hash('sha256', $pass);
	}
  if (!empty($_POST['ConfirmarPass'])) {
    $conpass=htmlspecialchars($_POST['ConfirmarPass']);
    $conpass=hash('sha256', $conpass);
  }
    $foto='userimg.png';
  	  $userinc=mysqli_query($conn,"SELECT Utilizador FROM tblvoluntario WHERE Utilizador='".$user."'");
      $linha=mysqli_fetch_array($userinc);

      $emailinc=mysqli_query($conn,"SELECT Email FROM tblvoluntario WHERE Email='".$email."'");
      $coluna=mysqli_fetch_array($emailinc);

      $pass1=hash('sha256', '1234');
      $pass2=hash('sha256', '4321');
      $pass3=hash('sha256', '123456');
      $pass4=hash('sha256', '654321');
      $pass5=hash('sha256', $user);
      $pass6=hash('sha256', $nome);
      $pass7=hash('sha256', $apelido);
      $pass8=hash('sha256', $email);
      $data= date('y-m-d');

    if($linha[0]!=null){
      $ermsg=1;
    }else if($coluna[0]!=null){
      $ermsg=2;
		}else if($pass==$pass1 or $pass==$pass2 or $pass==$pass3 or $pass==$pass4 or $pass==$pass5 or $pass==$pass6 or $pass==$pass7 or $pass==$pass8 ){
			$ermsg=3;
		}else if($pass!=$conpass){
      $ermsg=4;
    }else{
      mysqli_query($conn,"insert into tblvoluntario(Nome,Apelido,Email,Utilizador,Password,Registo,Foto) values('".$nome."','".$apelido."','".$email."','".$user."','".$pass."','".$data."','".$foto."')");
      Mail::sendMail('Bem-vindo ao Help2Everyone!',"A sua Conta como Voluntário foi criada, a partir de agora vai poder ajudar mais os outros do que pensa.</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver
      desejado, simplesmente ignore-o ou apague-o.)</p>",$email);
      $_SESSION['user']=$user;
      header('Location: ./../index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Registar Voluntário</title>
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
	if($ermsg==1){
		echo "<div class='alert alert-warning' role='alert'>
					Utilizador já registado!!!
					</div>";
	}else if($ermsg==2){
		echo "<div class='alert alert-warning' role='alert'>
					Email já registado!!!
					</div>";
	}else if($ermsg==3){
		echo "<div class='alert alert-warning' role='alert'>
					Palavra-Passe fraca!!!
					</div>";
	}else if($ermsg==4){
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
						Registe-se
					</span>

					<div class="row">
						<div class="col-md-6">
							<div class="wrap-input100 validate-input" data-validate = "Inserir Nome">
								<input class="input100" type="text" name="Nome" maxlength="50" value="<?php if(isset($InserirNome)){echo $InserirNome;} ?>">
								<span class="focus-input100"></span>
								<span class="label-input100">Nome</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="wrap-input100 validate-input" data-validate = "Inserir Apelido">
								<input class="input100" type="text" name="Apelido" maxlength="50" value="<?php if(isset($Inserirapelido)){echo $Inserirapelido;} ?>">
								<span class="focus-input100"></span>
								<span class="label-input100">Apelido</span>
							</div>
						</div>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Email válido requerido: ex@abc.xyz">
						<input class="input100" type="text" name="Email" maxlength="100" value="<?php if(isset($Inseriremail)){echo $Inseriremail;} ?>">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Inserir Utilizador">
						<input class="input100" type="text" name="User" maxlength="100" value="<?php if(isset($Inseriruser)){echo $Inseriruser;} ?>">
						<span class="focus-input100"></span>
						<span class="label-input100">Utilizador</span>
					  </div>

          <div class="row">
						<div class="col-md-6">
							<div class="wrap-input100 validate-input" data-validate="Password requerida">
								<input class="input100" type="password" name="Pass" minlength=4 maxlength="100">
								<span class="focus-input100"></span>
								<span class="label-input100">Password</span>
							</div>
						</div>
            <div class="col-md-6">
              <div class="wrap-input100 validate-input" data-validate="Password requerida">
                <input class="input100" type="password" name="ConfirmarPass" minlength=4 maxlength="100">
                <span class="focus-input100"></span>
                <span class="label-input100">Confirmar Password</span>
              </div>
            </div>
					</div>



					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Registar
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<a class="txt1" href="./index.php">
							<i class="fa fa-arrow-left" aria-hidden="true"></i>
							Login
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
