<?php
include('./inicligacao.ini');
$ermsg=false;
session_start();

if((isset ($_SESSION['admin']) == true)){
  session_destroy();
  unset($_SESSION['admin']);
}else if((isset ($_SESSION['user']) == true)){
  session_destroy();
  unset($_SESSION['user']);
}else if ((isset ($_SESSION['nome']) == true)) {
  session_destroy();
  unset($_SESSION['nome']);
}

if ($_SERVER['REQUEST_METHOD']=='POST') {

  if (!empty($_POST['email'])) {
    $email=htmlspecialchars($_POST['email']);
  }
	if (!empty($_POST['passe'])) {
		$pass=htmlspecialchars($_POST['passe']);
		$pass=hash('sha256',$pass);
	}
	  $conta=mysqli_query($conn,"SELECT * from tbladmin where Email='".$email."' && Password='".$pass."'");
		$linha=mysqli_fetch_array($conta);

    if($linha[0]!=null){
      date_default_timezone_set('Europe/Lisbon');
      $dh = date('Y-m-d H:i');
      $conta=htmlspecialchars($linha['Nome']);

      $realize=mysqli_query($conn,"insert into tbllogs(Id_Admin,DataHora,NomeAdmin,EmailAdmin) values(".$linha[0].",'".$dh."','".$conta."','".$email."')");
      $_SESSION['admin']=$email;
      header('Location: ./index.php');
    }else{
      $ermsg=true;
    }
    unset($_POST);
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="./img/logo.ico">

  <title>H2E: Login_Admin</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block "style="background-image: url('./img/vol.png');"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <?php
                  if($ermsg==true){
                    echo "<div class='alert alert-warning' role='alert'>
                          Utilizador/Palavra-Passe Inválidos!!!
                          </div>";
                  }
                  ?>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4" style="padding-top:25%;">Iniciar Sessão</h1>
                  </div>
                  <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                      <input type="email" maxlength="100" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" required placeholder="Insira o Email">
                    </div>
                    <div class="form-group">
                      <input type="password" maxlength="300" name="passe" class="form-control form-control-user" id="exampleInputPassword" required placeholder="Insira a Palavra-Passe">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <p>Para fins de Avaliação uma conta predefenida é: (admin@gmail.com) e (administrador)</p>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Iniciar Sessão
                    </button>
                    <hr>
                    <a href="./../help2everyone/index.php" class="btn btn-google btn-user btn-block">
                      <i class="fas fa-home fa-fw"></i> Retroceder para Home!
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">

                  </div>
                  <div class="text-center">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
<?php
include('./inicligacao.ini');
?>
