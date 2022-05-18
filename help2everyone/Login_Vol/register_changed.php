<?php
include('./../inicligacao.ini');
include('./../classes/Mail.php');

$ermsg=0;
session_start();

if ($_SERVER['REQUEST_METHOD']=='GET') {

	if (!empty($_GET['Nome'])) {
		$InserirNome = htmlspecialchars(stripslashes($_GET['Nome']));
	}
	if (!empty($_GET['Apelido'])) {
		$Inserirapelido = htmlspecialchars(stripslashes($_GET['Apelido']));
	}
	if (!empty($_GET['Email'])) {
		$Inseriremail = htmlspecialchars(stripslashes($_GET['Email']));
	}
	if (!empty($_GET['User'])) {
		$Inseriruser = htmlspecialchars(stripslashes($_GET['User']));
	}
	if (!empty($_GET['msg'])) {
		$ermsg = htmlspecialchars(stripslashes($_GET['msg']));
	}
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
	
	$data = [];
	if (!empty($_POST['Nome'])) {
		$array["nome"] = $InserirNome = htmlspecialchars(stripslashes($_POST['Nome']));
	}
	if (!empty($_POST['Apelido'])) {
		$array["apelido"] = $Inserirapelido = htmlspecialchars(stripslashes($_POST['Apelido']));
	}
	if (!empty($_POST['Email'])) {
		$array["email"] = $Inseriremail = htmlspecialchars(stripslashes($_POST['Email']));
	}
	if (!empty($_POST['User'])) {
		$array["user"] = $Inseriruser = htmlspecialchars(stripslashes($_POST['User']));
	}
	if (!empty($_POST['Pass'])) {
		$array["pass"] = hash('sha256', htmlspecialchars(stripslashes($_POST['Pass'])));
		//$pass=htmlspecialchars($_POST['Pass']);
		//$pass=hash('sha256', $pass);
	}
	if (!empty($_POST['ConfirmarPass'])) {
		$conpass = hash('sha256', htmlspecialchars(stripslashes($_POST['ConfirmarPass'])));
		//$conpass=htmlspecialchars($_POST['ConfirmarPass']);
		//$conpass=hash('sha256', $conpass);
	}

	/* Erros
	1 - Utilizador já registado
	2 - Email já registado
	3 - Password fraca
	4 - As passwords não coincidem
	*/

	$searchUser = select_tblvoluntario(["Utilizador"], ["Utilizador"], $array["user"]);
	$searchEmail = select_tblvoluntario(["Email"], ["Email"], $array["email"]);

	if($array["pass"] != $conpass)
		$ermsg = 4;
	else if($array["pass"] == hash('sha256', '1234')
		|| $array["pass"] == hash('sha256', '4321')
		|| $array["pass"] == hash('sha256', '123456')
		|| $array["pass"] == hash('sha256', '654321')
		|| $array["pass"] == hash('sha256', $array['user'])
		|| $array["pass"] == hash('sha256', $array['nome'])
		|| $array["pass"] == hash('sha256', $array['apelido'])
		|| $array["pass"] == hash('sha256', $array['email']))
		$ermsg = 3;
	else if($searchEmail->num_rows > 0)
		$ermsg = 2;
	else if($searchUser->num_rows > 0)
		$ermsg = 1;
		
	$array['foto'] = 'userimg.png';
	$array['data'] = date('y-m-d');

	/*
	$userinc=mysqli_query($conn,"SELECT Utilizador FROM tblvoluntario WHERE Utilizador='".$user."'");
	$linha=mysqli_fetch_array($userinc);

	$emailinc=mysqli_query($conn,"SELECT Email FROM tblvoluntario WHERE Email='".$email."'");
	$coluna=mysqli_fetch_array($emailinc);*/
	
	if($ermsg == 0){
		//if(insert_tblvoluntario($array)){
		$ar = 1;
		if($ar == 0){
			/* Mail::sendMail('Bem-vindo ao Help2Everyone!',"A sua Conta como Voluntário foi criada, a partir de agora vai poder ajudar mais os outros do que pensa.</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver
      		desejado, simplesmente ignore-o ou apague-o.)</p>",$email); */ 
			$_SESSION['user']=$user;
			//header('Location: ./../index.php');
		}else{
			$ermsg = 5;
		}
	}
	//header("Location: ".$_SERVER['PHP_SELF']."?msg=".$ermsg);
    /*if($linha[0]!=null){
      $ermsg=1;
    }else if($coluna[0]!=null){
      $ermsg=2;
	}*/

	/*mysqli_query($conn,"insert into tblvoluntario(Nome,Apelido,Email,Utilizador,Password,Registo,Foto) values('".$nome."','".$apelido."','".$email."','".$user."','".$pass."','".$data."','".$foto."')");
	Mail::sendMail('Bem-vindo ao Help2Everyone!',"A sua Conta como Voluntário foi criada, a partir de agora vai poder ajudar mais os outros do que pensa.</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver
	desejado, simplesmente ignore-o ou apague-o.)</p>",$email);
	$_SESSION['user']=$user;
	//header('Location: ./../index.php');*/
}

function insert_tblvoluntario($array) : boolval{
	// Using mysqli to prevent agains sql injection
	$success = True;
	
	// Prepared statement, stage 1: prepare
	if (!($query = $mysqli->prepare("INSERT INTO tblvoluntario(Nome, Apelido, Email, Utilizador, Password, Registo, Foto) VALUES (?,?,?,?,?,?,?)"))) {
		//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$success = 	False;
   	}

	// Prepared statement, stage 2: bind and execute 
	if (!$success || !$query->bind_param('sssssss',$array['nome'], $array['apelido'], $array['email'], 
	$array['user'], $array['pass'], $array['data'], $array['foto'])) {
		//echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
		$success = False;
	}
	
	if (!$success || !$query->execute()) {
		//echo "Execute failed: (" . $query->errno . ") " . $query->error;
		$success = False;
	}

	// Close the statement 
	$query->close();

	return $success;
}

function select_tblvoluntario($select_fields, $cond_fields, $array_data){
	$success = True;
	// Build the condition fields
	for($i = 0; $i < count($cond_fields); $i++){
		$questions .= $cond_fields[$i].' = ?';
		if(($i+1) < count($cond_fields))
			$questions.= ', ';
	}
	// Build the select fields
	for($i = 0; $i < count($select_fields); $i++){
		$conditions .= $select_fields[$i];
		if(($i+1) < count($cond_fields))
			$conditions.= ', ';
	}
	$types = str_repeat('s', count($array_data));
	$sql = "SELECT {$conditions} FROM tblvoluntario WHERE {$questions} ";

/*	// Prepared statement, stage 1: prepare
	if (!($query = $mysqli->prepare($sql))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$success = 	False;
	}
	/*
	// Prepared statement, stage 2: bind and execute 
	if (!$success || !$query->bind_param($types, $array_data)) {
		//echo "Binding parameters failed: (" . $query->errno . ") " . $query->error;
		$success = False;
	}
	
	if (!$success || !$query->execute()) {
		//echo "Execute failed: (" . $query->errno . ") " . $query->error;
		$success = False;
	}

	$res = $query->get_result();

	// Close the statement 
	$query->close();
	*/
	return $res;
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
	if($ermsg == 1){
		echo "<div class='alert alert-warning' role='alert'>
					Utilizador já registado!!!
					</div>";
	}else if($ermsg == 2){
		echo "<div class='alert alert-warning' role='alert'>
					Email já registado!!!
					</div>";
	}else if($ermsg == 3){
		echo "<div class='alert alert-warning' role='alert'>
					Palavra-Passe fraca!!!
					</div>";
	}else if($ermsg == 4){
		echo "<div class='alert alert-warning' role='alert'>
					As Palavras-Passe não coincidem, por favor tente novamente!!!
					</div>";
	}else if($ermsg == 5){
		echo "<div class='alert alert-warning' role='alert'>
					Ocorreu um erro ao criar a conta, por favor tente novamente!!!
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
