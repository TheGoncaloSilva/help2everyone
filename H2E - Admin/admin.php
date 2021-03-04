<?php
include('./inicligacao.ini');
session_start();
if((isset ($_SESSION['admin']) == true)){
	$logado=$_SESSION['admin'];
	$result=mysqli_query($conn,"select Foto from tbladmin where Email='".$logado."'");
	$logf=mysqli_fetch_array($result);
	$logfoto=htmlspecialchars($logf['Foto']);
	$logfotof="./Fotos/FotosAdmin/".$logfoto;
	$login=true;
}else{
	$login=false;
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['nome']);
	header('Location: ./login.php');
	}
  $query=mysqli_query($conn,"select * from tbladmin where Email='".$logado."'");
  $resultq=mysqli_fetch_array($query);
  $Nome1_admin=htmlspecialchars($resultq['Nome']);
  $Apelido1_admin=htmlspecialchars($resultq['Apelido']);
	$msgvisos=0;
	$inserir=0;
	$saber=0;

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['EditarAdmin'])){
		$variavel=$_GET['EditarAdmin'];
		$comando=mysqli_query($conn,"select * from tbladmin where Id='".$variavel."'");
		$row=mysqli_fetch_array($comando);
		$Id_Admin=htmlspecialchars($row['Id']);
		$Foto_Admin=htmlspecialchars($row['Foto']);
		$Nome_Admin=htmlspecialchars($row['Nome']);
		$Apelido_Admin=htmlspecialchars($row['Apelido']);
		$Email_Admin=htmlspecialchars($row['Email']);
		$Tele_Admin=htmlspecialchars($row['Telemovel']);
		$CodPostal_Admin=htmlspecialchars($row['CodPostal']);
		$Pais_Admin=htmlspecialchars($row['Pais']);
		$Distrito_Admin=htmlspecialchars($row['Distrito']);
		$Morada_Admin=htmlspecialchars($row['Morada']);
		$Concelho_Admin=htmlspecialchars($row['Concelho']);
		$inserir=1;
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['limpar'])){
		$comando=null;
		$row=null;
		$Id_Admin=null;
		$Foto_Admin=null;
		$Nome_Admin=null;
		$Apelido_Admin=null;
		$Email_Admin=null;
		$Tele_Admin=null;
		$CodPostal_Admin=null;
		$Pais_Admin=null;
		$Distrito_Admin=null;
		$Morada_Admin=null;
		$Concelho_Admin=null;
		$inserir=0;
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['EliminarAdmin'])){
		$variavel=$_GET['EliminarAdmin'];
		mysqli_query($conn,"delete from tbladminnoticiacomentario where IdAdmin=".$variavel);
		if(mysqli_query($conn,"delete from tbladmin where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['InserirAdmin'])){
		if (!empty($_POST['Nome_Admin'])) {
			$Nome_Admin=htmlspecialchars($_POST['Nome_Admin']);
		}
		if (!empty($_POST['Apelido_Admin'])) {
			$Apelido_Admin=htmlspecialchars($_POST['Apelido_Admin']);
		}

		$caminho=$_FILES['upload']['name'];
		$caminhoTmp=$_FILES['upload']['tmp_name'];
		$explode=(explode('.',$caminho));
		$caminho=$Nome_Admin.time().'.'.$explode[1];
		$criar=move_uploaded_file($caminhoTmp, "./Fotos/FotosAdmin/".$caminho);

		if (!empty($_POST['Email_Admin'])) {
			$Email_Admin=htmlspecialchars($_POST['Email_Admin']);
		}
		if (!empty($_POST['Telemovel_Admin'])) {
			$Tele_Admin=htmlspecialchars($_POST['Telemovel_Admin']);
		}
		if (!empty($_POST['CodPostal_Admin'])) {
			$CodPostal_Admin=htmlspecialchars($_POST['CodPostal_Admin']);
		}
		if (!empty($_POST['Pais_Admin'])) {
			$Pais_Admin=htmlspecialchars($_POST['Pais_Admin']);
		}
		if (!empty($_POST['Distrito_Admin'])) {
			$Distrito_Admin=htmlspecialchars($_POST['Distrito_Admin']);
		}
		if (!empty($_POST['Concelho_Admin'])) {
			$Concelho_Admin=htmlspecialchars($_POST['Concelho_Admin']);
		}
		if (!empty($_POST['Morada_Admin'])) {
			$Morada_Admin=htmlspecialchars($_POST['Morada_Admin']);
		}
		if (!empty($_POST['Password_Admin'])) {
			$Password_Admin=htmlspecialchars($_POST['Password_Admin']);
			$Pass_admin=hash('sha256',$Password_Admin);
		}
		if(mysqli_query($conn,"insert into tbladmin(Foto,Nome,Apelido,Email,Telemovel,CodPostal,Pais,Distrito,Concelho,Morada,Password)
		values('".$caminho."','".$Nome_Admin."','".$Apelido_Admin."','".$Email_Admin."','".$Tele_Admin."','".$CodPostal_Admin."',
		'".$Pais_Admin."','".$Distrito_Admin."','".$Concelho_Admin."','".$Morada_Admin."','".$Pass_admin."')")){
			$msgvisos=1;
			$Id_Admin=null;
			$Foto_Admin=null;
			$Nome_Admin=null;
			$Apelido_Admin=null;
			$Email_Admin=null;
			$Tele_Admin=null;
			$CodPostal_Admin=null;
			$Pais_Admin=null;
			$Distrito_Admin=null;
			$Concelho_Admin=null;
			$Password_Admin=null;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['GuardarAdmin'])){
		$saber=htmlspecialchars($_POST['Id_Admin']);
		if (!empty($_POST['Nome_Admin'])) {
	    $Nome_Admin=htmlspecialchars($_POST['Nome_Admin']);
	  }
		if (!empty($_POST['Apelido_Admin'])) {
			$Apelido_Admin=htmlspecialchars($_POST['Apelido_Admin']);
		}

		$result=mysqli_query($conn,"select * from tbladmin where Id='".$saber."'");
		$entrada=mysqli_fetch_array($result);
		$foto_volz=htmlspecialchars($entrada['Foto']);

				$caminho=$_FILES['upload']['name'];
				$caminhoTmp=$_FILES['upload']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$Nome_Admin.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./Fotos/FotosAdmin/".$caminho);

						unlink("./Fotos/FotosAdmin/".$foto_volz);

				}else{
					$caminho=$foto_volz;
				}


		if (!empty($_POST['Email_Admin'])) {
			$Email_Admin=htmlspecialchars($_POST['Email_Admin']);
		}
		if (!empty($_POST['Telemovel_Admin'])) {
			$Tele_Admin=htmlspecialchars($_POST['Telemovel_Admin']);
		}
		if (!empty($_POST['CodPostal_Admin'])) {
			$CodPostal_Admin=htmlspecialchars($_POST['CodPostal_Admin']);
		}
		if (!empty($_POST['Pais_Admin'])) {
			$Pais_Admin=htmlspecialchars($_POST['Pais_Admin']);
		}
		if (!empty($_POST['Distrito_Admin'])) {
			$Distrito_Admin=htmlspecialchars($_POST['Distrito_Admin']);
		}
		if (!empty($_POST['Concelho_Admin'])) {
			$Concelho_Admin=htmlspecialchars($_POST['Concelho_Admin']);
		}
		if (!empty($_POST['Morada_Admin'])) {
			$Morada_Admin=htmlspecialchars($_POST['Morada_Admin']);
		}
		if (!empty($_POST['Password_Admin'])) {
			$Password_Admin=htmlspecialchars($_POST['Password_Admin']);
			$Pass_admin=hash('sha256',$Password_Admin);
			$query1=mysqli_query($conn,"update tbladmin set Foto='".$caminho."',Nome='".$Nome_Admin."',Apelido='".$Apelido_Admin."',Email='".$Email_Admin."',
			Telemovel='".$Tele_Admin."',CodPostal='".$CodPostal_Admin."',Pais='".$Pais_Admin."',Distrito='".$Distrito_Admin."',
			Concelho='".$Concelho_Admin."',Morada='".$Morada_Admin."',Password='".$Pass_admin."' where Id=".$saber);
		}else{
			$query1=mysqli_query($conn,"update tbladmin set Foto='".$caminho."' , Nome='".$Nome_Admin."' , Apelido='".$Apelido_Admin."' , Email='".$Email_Admin."' ,
			Telemovel='".$Tele_Admin."' , CodPostal='".$CodPostal_Admin."' , Pais='".$Pais_Admin."' , Distrito='".$Distrito_Admin."' ,
			Concelho='".$Concelho_Admin."' , Morada='".$Morada_Admin."' where Id=".$saber);
		}

		if($query1){
			$msgvisos=1;
			$Id_Admin=null;
			$Foto_Admin=null;
			$Nome_Admin=null;
			$Apelido_Admin=null;
			$Email_Admin=null;
			$Tele_Admin=null;
			$CodPostal_Admin=null;
			$Pais_Admin=null;
			$Distrito_Admin=null;
			$Concelho_Admin=null;
			$Password_Admin=null;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
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

	<title>H2E: Dashboard-Eventos</title>
  <link rel="icon" href="./img/logo.ico">
  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="./img/shortlogo1.png" class="d-inline-block align-top imgnav Logo_text" alt="Help2Everyone">
        </div>
        <div class="sidebar-brand-text mx-3"><img src="./img/shortext1.png" class="d-inline-block align-top imgnav Logo_text" alt="Help2Everyone"></div>
      </a>
			<?php
      $cmd=mysqli_query($conn,"select Id from tblreports where Visto=0");
      $lol=0;
      $info=array();
      while ($seg=mysqli_fetch_array($cmd)) {

        $info[$lol]=$seg[0];
        $lol++;
      }
      $taman=count($info);

			$cmd=mysqli_query($conn,"select Id from tblreportvol where Visto=0");
			$lol=0;
			$info=array();
			while ($seg=mysqli_fetch_array($cmd)) {

				$info[$lol]=$seg[0];
				$lol++;
			}
			$taman=$taman+count($info);

			$cmd=mysqli_query($conn,"select Id from tblreportorg where Visto=0");
			$lol=0;
			$info=array();
			while ($seg=mysqli_fetch_array($cmd)) {

				$info[$lol]=$seg[0];
				$lol++;
			}
			$taman=$taman+count($info);

      $cmd=mysqli_query($conn,"select Id from tblcontato where Vista=0");
      $lol=0;
      $info=array();
      while ($seg=mysqli_fetch_array($cmd)) {

        $info[$lol]=$seg[0];
        $lol++;
      }
      $tama=count($info);
      ?>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="report.php">
          <i class="fas fa-bug fa-bug-alt"></i>
          <span>Denúncias</span> <?php if($taman>=1){echo "<span class='badge badge-pill badge-warning'>".$taman."</span>";} ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./contato.php">
          <i class="fas fa-flag fa-flag-alt"></i>
          <span>Contatos</span> <?php if($tama>=1){echo "<span class='badge badge-pill badge-warning'>".$tama."</span>";} ?></a>
      </li>
			<li class="nav-item active">
				<a class="nav-link" href="./admin.php">
					<i class="fas fa-unlock-alt fa-unlock-alt"></i>
					<span>Admins</a>
			</li>

			<?php
			$cmd=mysqli_query($conn,"select Id from tblvolnoticiacomentario where Visto=0");
			$lol=0;
			$infos=array();
			while ($seg=mysqli_fetch_array($cmd)) {

				$infos[$lol]=$seg[0];
				$lol++;
			}
			$tcom=count($infos);
			?>
			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsenews" aria-expanded="true" aria-controls="collapseTwo">
					<i class="fas fa-newspaper fa-newspaper"></i>
					<span>Notícias </span><?php if($tcom>=1){echo "<span class='badge badge-pill badge-warning'>".$tcom."</span>";} ?>
				</a>
				<div id="collapsenews" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<h6 class="collapse-header">Notícias:</h6>
						<a class="collapse-item" href="news.php">Gerir Notícias</a>
						<a class="collapse-item" href="newscoment.php">Gerir Comentários <?php if($tcom>=1){echo "<span class='badge badge-pill badge-warning'>".$tcom."</span>";} ?></a>
					</div>
				</div>
			</li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Pesquisas
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsetabs" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book-open"></i>
          <span>Tabelas Eventos</span>
        </a>
        <div id="collapsetabs" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tabelas Eventos:</h6>
            <a class="collapse-item" href="index.php?abrirevent=1">Listagem Eventos</a>
            <a class="collapse-item" href="index.php?abrirevent=2">Avaliação Eventos</a>
            <a class="collapse-item" href="index.php?abrirevent=3">Comentários Eventos</a>
            <a class="collapse-item" href="index.php?abrirevent=4">Gostos Com. Voluntários</a>
            <a class="collapse-item" href="index.php?abrirevent=5">Comentários Organizações</a>
            <a class="collapse-item" href="index.php?abrirevent=6">Gostos Com. Organizações</a>
            <a class="collapse-item" href="index.php?abrirevent=7">Skills-Eventos</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecom" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building"></i>
          <span>Tabelas Organizações</span>
        </a>
        <div id="collapsecom" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tabelas Organizações:</h6>
						<a class="collapse-item" href="index.php?abrirorg=5">Pedidos de Registo</a>
						<a class="collapse-item" href="index.php?abrirorg=1">Listagem Organizações</a>
						<a class="collapse-item" href="index.php?abrirorg=2">Avaliação Organizações</a>
						<a class="collapse-item" href="index.php?abrirorg=3">Organizações Eventos</a>
						<a class="collapse-item" href="index.php?abrirorg=4">Skills-Organização</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesec" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-users"></i>
          <span>Tabelas Voluntários</span>
        </a>
        <div id="collapsesec" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tabelas Voluntários:</h6>
            <a class="collapse-item" href="index.php?abrirvol=1">Listagem Voluntários</a>
            <a class="collapse-item" href="index.php?abrirvol=2">Avaliação Voluntários</a>
            <a class="collapse-item" href="index.php?abrirvol=3">Voluntários Eventos</a>
            <a class="collapse-item" href="index.php?abrirvol=4">Skills-Voluntários</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

				<!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $Nome1_admin." ".$Apelido1_admin; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $logfotof; ?>">
              </a>
              <!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="admin.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Perfis
								</a>
								<a class="dropdown-item" href="logs.php">
									<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
									Logins
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Sair
								</a>
							</div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
					<?php
					if($msgvisos==1){
							echo "<div class='alert alert-success' role='alert'>
							<div class='row'>
								<div class='col-md-10'>
									<strong>sucesso! </strong>- Dados Atualizados com sucesso!!!
								</div>
								<div class='col-md-2'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i class='fa fa-times'></i></button>
								</div>
							</div>
							</div>";
							$msgvisos=0;
					}else if($msgvisos==2){
						echo "<div class='alert alert-danger' role='alert'>
						<div class='row'>
							<div class='col-md-10'>
								<strong>#ERRO# </strong>- Por Favor tente novamente, caso o erro persista contacte o administrador de sistema!!!
							</div>
							<div class='col-md-2'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><i class='fa fa-times'></i></button>
							</div>
						</div>
						</div>";
							$msgvisos=0;
						}
					?>
          <!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Contato</h1>
					</div>
					<div class="row">

					<?php
					$cmd=mysqli_query($conn,"select Id from tbladmin");
					$lol=0;
					$info=array();
					while ($seg=mysqli_fetch_array($cmd)) {

						$info[$lol]=$seg[0];
						$lol++;
					}
					$size1=count($info);
					?>

					<div class="col-xl-3 col-md-6 mb-4">
						<div class="card border-left-info shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Admins Inscritos</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size1; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-unlock-alt fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-sm-flex align-items-center justify-content-between mb-4">
					<h1 class="h3 mb-0 text-gray-800">Gerir Admins</h1>
				</div>

					<div class="row">
						<div class="col-md-4">
							<div class="card shadow mb-12">
		            <div class="card-header py-3">
		              <h6 class="m-0 font-weight-bold text-primary">Inserir/Editar Admins</h6>
		            </div>
		            <div class="card-body">
									<div class="row">
										<form action="./admin.php" method="POST" enctype="multipart/form-data">
											<input type="text" name="Id_Admin" id="Id_Admin" value="<?php if(isset($Id_Admin)){echo $Id_Admin;} ?>" hidden>
									<div class="col-md-12" style="padding-bottom:5px;">
										<label style="color:black;font-weight:bold;">Foto: </label>
											 <input type="file" name="upload" class="form-control btn btn-primary" accept="image/png, image/jpeg" <?php if(!isset($Foto_Admin)){echo "required";} ?>>
									 </div>
									<div class="col-md-12" style="padding-bottom:5px;">
										<label style="color:black;font-weight:bold;">Nome: </label>
											 <input class="form-control" maxlength="50" type="text" name="Nome_Admin" placeholder="Insira o Nome do admin" required value="<?php if(isset($Nome_Admin)){echo $Nome_Admin;} ?>">
									 </div>
									 <div class="col-md-12" style="padding-bottom:5px;">
										 <label style="color:black;font-weight:bold;">Apelido: </label>
												<input class="form-control" maxlength="50" type="text" name="Apelido_Admin" placeholder="Insira o Apelido do admin" required value="<?php if(isset($Apelido_Admin)){echo $Apelido_Admin;} ?>">
										</div>
										<div class="col-md-12" style="padding-bottom:5px;">
											<label style="color:black;font-weight:bold;">Email: </label>
												 <input class="form-control" maxlength="100" type="email" name="Email_Admin" placeholder="Insira o Email do admin" required value="<?php if(isset($Email_Admin)){echo $Email_Admin;} ?>">
										 </div>
										 <div class="col-md-12" style="padding-bottom:5px;">
											 <label style="color:black;font-weight:bold;">Telemóvel: </label>
													<input class="form-control" maxlength="12" type="number" name="Telemovel_Admin" placeholder="Insira o nº de Telemóvel do admin" required value="<?php if(isset($Tele_Admin)){echo $Tele_Admin;} ?>">
											</div>
											<div class="col-md-12" style="padding-bottom:5px;">
												<label style="color:black;font-weight:bold;">Código Postal: </label>
													 <input title="Insira o Código Postal com o formato ****-***" pattern="\d{4}-\d{3}" class="form-control" maxlength="8" type="text" name="CodPostal_Admin" placeholder="Insira o Código Postal do admin" required value="<?php if(isset($CodPostal_Admin)){echo $CodPostal_Admin;} ?>">
											 </div>
											 <div class="col-md-12" style="padding-bottom:5px;">
												 <label style="color:black;font-weight:bold;">País: </label>
														<input class="form-control" maxlength="70" type="text" name="Pais_Admin" placeholder="Insira o Pais do admin" required value="<?php if(isset($Pais_Admin)){echo $Pais_Admin;} ?>">
												</div>
												<div class="col-md-12" style="padding-bottom:5px;">
													<label style="color:black;font-weight:bold;">Distrito: </label>
														 <input class="form-control" maxlength="50" type="text" name="Distrito_Admin" placeholder="Insira o Distrito do admin" required value="<?php if(isset($Distrito_Admin)){echo $Distrito_Admin;} ?>">
												 </div>
												 <div class="col-md-12" style="padding-bottom:5px;">
													 <label style="color:black;font-weight:bold;">Concelho: </label>
															<input class="form-control" maxlength="50" type="text" name="Concelho_Admin" placeholder="Insira o Concelho do admin" required value="<?php if(isset($Concelho_Admin)){echo $Concelho_Admin;} ?>">
													</div>
												 <div class="col-md-12" style="padding-bottom:5px;">
													 <label style="color:black;font-weight:bold;">Morada: </label>
															<input class="form-control" maxlength="300" type="text" name="Morada_Admin" placeholder="Insira a Morada do admin" required value="<?php if(isset($Morada_Admin)){echo $Morada_Admin;} ?>">
													</div>
													 <div class="col-md-12" style="padding-bottom:5px;">
														 <label style="color:black;font-weight:bold;">Palavra-Passe: </label>
																<input class="form-control" maxlength="12" <?php if($inserir==0){echo "required placeholder='Insira a palavra-passe'";}else{echo "placeholder='Mudar a palavra-passe'";} ?> type='password' name="Password_Admin">
														</div>
														 <div class="col-md-12 text-center" style="padding-top:5px;">
															 <button class="btn btn-secondary" type="submit" name="limpar"><i class="fas fa-times"></i> Cancelar</button>
															 <?php
															 if($inserir==0){
																 echo "<button class='btn btn-success' type='submit' name='InserirAdmin'><i class='fas fa-plus'></i> Inserir</button></div>";
															 }else{
																 echo "<button class='btn btn-success' type='submit' name='GuardarAdmin'><i class='fas fa-save'></i> Guardar</button></div>";
															 }
															 ?>
														</form>
									</div>
		            </div>
		          </div>

					</div>
					<div class="col-md-8">
          <!-- DataTales Example -->
          <div class="card shadow mb-12">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Visualizar Admins</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
	                    <tr>
												<th>Id</th>
												<th>Foto</th>
												<th>Nome</th>
												<th>Apelido</th>
												<th>Email</th>
												<th>Código-Postal</th>
												<th><i class='fas fa-cog'></i></th>
											</tr>
	                  </thead>
	                  <tfoot>
										<tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Nome</th>
												<th>Apelido</th>
                        <th>Email</th>
                        <th>Código-Postal</th>
												<th><i class='fas fa-cog'></i></th>
												</tr>
	                   </tr>
	                  </tfoot>
                  <tbody>
										<?php
											$cmd=mysqli_query($conn,"select Id from tbladmin order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tbladmin where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $IdVoluntario=htmlspecialchars($entrada['Id']);
						              $NomeVoluntario=htmlspecialchars($entrada['Nome']);
                          $ApelidoVoluntario=htmlspecialchars($entrada['Apelido']);
						              $FotoVoluntario=htmlspecialchars($entrada['Foto']);
						              $EmailVoluntario=htmlspecialchars($entrada['Email']);
						              $CodPostalVoluntario=htmlspecialchars($entrada['CodPostal']);
													$Pic="./Fotos/FotosAdmin/".$FotoVoluntario;

														echo "
														<tr>
															<td class='text-center'>".$IdVoluntario."</td>
															<td class='text-center'><img style='width:50px;height:50px;' src='".$Pic."'></td>
															<td class='text-center'>".$NomeVoluntario."</td>
                              <td class='text-center'>".$ApelidoVoluntario."</td>
															<td class='text-center'>".$EmailVoluntario."</td>
															<td class='text-center'>".$CodPostalVoluntario."</td>
															<td class='text-center'><a href='./admin.php?EliminarAdmin=".$IdVoluntario."' class='btn btn-danger'><i class='fa fa-trash'></i></a><br><br><a href='./admin.php?EditarAdmin=".$IdVoluntario."' class='btn btn-warning'><i class='fa fa-cog'></i></a></td>
														</tr>
														";
						          }
										?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
				</div>
			</div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Help2Everyone 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tem a certeza que deseja sair?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione "Sair" se desejar terminar a sessão atual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-danger" href="login.php">Sair</a>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>

<?php
include('./inicligacao.ini');
?>
