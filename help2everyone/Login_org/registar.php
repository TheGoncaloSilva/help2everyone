<?php
include('./../inicligacao.ini');
include('./../classes/Mail.php');
$ermsg=0;
if ($_SERVER['REQUEST_METHOD']=='POST') {
  session_start();

  if (!empty($_POST['Nome'])) {
    $nome=htmlspecialchars($_POST['Nome']);
  }
  if (!empty($_POST['Email'])) {
    $email=htmlspecialchars($_POST['Email']);
  }
	if (!empty($_POST['Password'])) {
		$pass=htmlspecialchars($_POST['Password']);
    $pass=hash('sha256', $pass);
	}
  if (!empty($_POST['ConfirmarPassword'])) {
    $conpass=htmlspecialchars($_POST['ConfirmarPassword']);
    $conpass=hash('sha256', $conpass);
  }

    $foto='userimg.png';
      $emailinc=mysqli_query($conn,"SELECT Email FROM tblorganizacao WHERE Email='".$email."'");
      $coluna=mysqli_fetch_array($emailinc);
      $nomeorg=mysqli_query($conn,"SELECT Nome FROM tblorganizacao WHERE Nome='".$nome."'");
      $linha=mysqli_fetch_array($nomeorg);


      $pass1=hash('sha256', '1234');
      $pass2=hash('sha256', '4321');
      $pass3=hash('sha256', '123456');
      $pass4=hash('sha256', '654321');
      $pass6=hash('sha256', $nome);
      $pass8=hash('sha256', $email);
      $data= date('y-m-d');
    if($linha[0]!=null){
        $ermsg=1;
    }else if($coluna[0]!=null){
      $ermsg=2;
		}else if($pass==$pass1 or $pass==$pass2 or $pass==$pass3 or $pass==$pass4 or $pass==$pass6 or $pass==$pass8 ){
			$ermsg=3;
		}else if($pass!=$conpass){
      $ermsg=4;
    }else{
      $caminho=$_FILES['Comprovativo']['name'];
      $caminhoTmp=$_FILES['Comprovativo']['tmp_name'];
      $explode=(explode('.',$caminho));
      $caminho="Comp".time().'.'.$explode[1];
      $criar=move_uploaded_file($caminhoTmp,"./../Fotos/ComprovativoOrg/".$caminho);

      mysqli_query($conn,"insert into tblorganizacao(Nome,Email,Password,Foto,DataReg,Comprovativo) values('".$nome."','".$email."','".$pass."','".$foto."','".$data."','".$caminho."')");
      Mail::sendMail('Obrigado pelo registo',"Agradecemos por ter criado uma conta como Organização no Help2Everyone, no entanto o processo
       ainda não está totalmente acabado, por razões de segurança, a sua conta tem de ser verificada e aprovada pelo Administrador, daremos um veredito
       no mínimo de tempo possível. Obrigado por compreender.</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver
       desejado, simplesmente ignore-o ou apague-o.)</p>",$email);
      $_SESSION['nome']=$nome;
      header('Location: ./../ChooseLog/queue.php');
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
          Nome da Organização já registado!!!
          </div>";
 	}else if($ermsg==2){
		echo "<div class='alert alert-warning' role='alert'>
					Email já registado!!!
					</div>";
	}else if($ermsg==3){
		echo "<div class='alert alert-warning' role='alert'>
					Palavra-passe fraca!!!
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
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<span class="login100-form-title">
						Registe uma conta
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Insira o nome da Organização">
						<input class="input100" type="text" name="Nome" value="<?php if(isset($nome)){echo $nome;} ?>" required placeholder="Organização" maxlength="100">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Email válido requerido: ex@abc.xyz">
						<input class="input100" type="text" name="Email" value="<?php if(isset($email)){echo $email;} ?>" required placeholder="Email" maxlength="100">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password requerida">
            <input class="input100" type="password" name="Password" placeholder="Palavra-Passe" minlength=4 maxlength="100" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

          <div class="wrap-input100 validate-input" data-validate = "Password requerida">
            <input class="input100" type="password" name="ConfirmarPassword" placeholder="Confirme a Palavra-Passe" minlength=4 maxlength="100" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate = "Comprovativo requerido">
            <input class="btn btn-info" style="max-width:100%;" type="file" id="Comprovativo" name="Comprovativo" required title="Insira um Comprovativo que a Organização existe e que é uma conta fidedigna">
          </div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Registar
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
