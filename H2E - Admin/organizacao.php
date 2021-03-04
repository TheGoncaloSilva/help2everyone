<?php
include('./inicligacao.ini');
include('./classes/Mail.php');
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
  $Nome_admin=htmlspecialchars($resultq['Nome']);
  $Apelido_admin=htmlspecialchars($resultq['Apelido']);
	$msgvisos=0;

	if($_SESSION['openorg']==1){
		$filtrar=1;
	}else if($_SESSION['openorg']==2){
		$filtrar=2;
	}else if($_SESSION['openorg']==3){
		$filtrar=3;
	}else if($_SESSION['openorg']==4){
		$filtrar=4;
	}else if($_SESSION['openorg']==5){
		$filtrar=5;
	}else{
		header('Location: ./index.php');
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['rec'])){
		$filtrar=1;
		$variavel=$_GET['rec'];
		if(mysqli_query($conn,"update tblevento set Reconhecido=1 where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}

	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['unrec'])){
		$filtrar=1;
		$variavel=$_GET['unrec'];
		if(mysqli_query($conn,"update tblevento set Reconhecido=0 where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['aprovar'])){
		$filtrar=5;
		$variavel=$_GET['aprovar'];

		$query=mysqli_query($conn,"Select * from tblorganizacao where Id=".$variavel);
		$con=mysqli_fetch_array($query);
		$FotoOrg=htmlspecialchars($con['Foto']);
		$EmailOrg=htmlspecialchars($con['Email']);

		if(mysqli_query($conn,"update tblorganizacao set Aprovada=1 where Id=".$variavel)){
			$msgvisos=1;
			Mail::sendMail('Temos boas Notícias',"Agradecemos por ter confiado em nós e ter esperado pela nossa resposta. Temos muito prazer
			 em comunicar que a sua conta no Help2Everyone foi aprovada e poderá, a partir de agora ajudar a promover o Voluntariado.
			 </br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver desejado, simplesmente ignore-o ou apague-o.)</p>",$EmailOrg);
			 header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['desaprovar'])){
		$filtrar=5;
		$variavel=$_GET['desaprovar'];

		$query=mysqli_query($conn,"Select * from tblorganizacao where Id=".$variavel);
		$con=mysqli_fetch_array($query);
		$FotoOrg=htmlspecialchars($con['Foto']);
		$EmailOrg=htmlspecialchars($con['Email']);
		$ComprovaticoOrg=htmlspecialchars($con['Comprovativo']);

		if($EmailOrg!=null){
			Mail::sendMail('Novidades registo de conta',"É com muita pena que informamos que a conta como Organização, pedida no Help2Everyone,
			 foi reprovada. Aconselhamos fortemente em voltar a registar uma conta, mas desta vez, com um comprovativo da vericidade da
			 Organização irrefutável. Pedimos desculpa pelo incómodo.</br></br><p>(Caso não reconheça este endereço de Email, ou se não o tiver
			 desejado, simplesmente ignore-o ou apague-o.)</p>",$EmailOrg);
		}

		$apagar1=mysqli_query($conn,"delete from tblareaatuacao where IdOrganizacao=".$variavel);
		$apagar10=mysqli_query($conn,"delete from tblreportorg where Id_Organizacao=".$variavel);
		$apagar10=mysqli_query($conn,"delete from tblrecuperarorg where IdOrganizacao=".$variavel);

		if($FotoOrg!=null){
			unlink('./../help2everyone/Fotos/FotosOrg/'.$FotoOrg);
		}
		if($ComprovaticoOrg!=null){
			unlink('./../help2everyone/Fotos/ComprovativoOrg/'.$ComprovaticoOrg);
		}

		if(mysqli_query($conn,"delete from tblorganizacao where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar1'])){
		$filtrar=1;
		$delete=$_GET['eliminar1'];

		$oqapa=mysqli_query($conn,"Select Id from tblorgcomentario where IdOrganizacao=".$delete);
		$row1=mysqli_fetch_array($oqapa);
		$IdOrgcomentario1=htmlspecialchars($row1['Id']);

		$selec=mysqli_query($conn,"select Id from tblevento where IdOrganizacao=".$delete."");
		$voltas=0;
		$info=array();
		while ($seg=mysqli_fetch_array($selec)) {

			$info[$voltas]=$seg[0];
			$voltas++;
		}
		$tas=count($info);
		if(!empty($tas)){
			for($i=0;$i<$tas;$i++){
				$apagar=$info[$i];
				$qapa=mysqli_query($conn,"Select Id from tbleventocomentario where IdEvento=".$apagar);
				while($row=mysqli_fetch_array($qapa)){
					$Idcomentario1=htmlspecialchars($row['Id']);
					$oqapa=mysqli_query($conn,"Select Id from tblorgcomentario where IdComentario=".$Idcomentario1);
					while($row1=mysqli_fetch_array($oqapa)){
						$IdOrgcomentario1=htmlspecialchars($row1['Id']);
						$apagar7=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$IdOrgcomentario1);
						$apagar9=mysqli_query($conn,"delete from tblorgcomentario where IdComentario=".$Idcomentario1);
					}

					$apagar6=mysqli_query($conn,"delete from tblgostocomentario where IdComentario=".$Idcomentario1);
					$apagar8=mysqli_query($conn,"delete from tbleventocomentario where IdEvento=".$apagar);
				}
				/*$qapa2=mysqli_query($conn,"Select Id from tbleventocomentario where IdEvento=".$apagar);
				$row2=mysqli_fetch_array($qapa2);
				$Idcomentario2=htmlspecialchars($row2['Id']);
				if($Idcomentario2!=null){
					$oqapa2=mysqli_query($conn,"Select Id from tblorgcomentario where IdComentario=".$Idcomentario2);
					$row3=mysqli_fetch_array($oqapa2);
					$IdOrgcomentario2=htmlspecialchars($row3['Id']);
					$apagar91=mysqli_query($conn,"delete from tblorgcomentario where IdComentario=".$Idcomentario2);
					$apagar61=mysqli_query($conn,"delete from tblgostocomentario where IdComentario=".$Idcomentario2);
					$apagar71=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$IdOrgcomentario2);
				}*/

				$apagar11=mysqli_query($conn,"delete from tblareaatucaoevento where IdEvento=".$apagar);
				$apagar31=mysqli_query($conn,"delete from tbleventorating where IdEvento=".$apagar);
				$apagar41=mysqli_query($conn,"delete from tblorgevento where IdEvento=".$apagar);
				$apagar51=mysqli_query($conn,"delete from tblvolevento where IdEvento=".$apagar);
				$apagar61=mysqli_query($conn,"delete from tblpedidos where IdEvento=".$apagar);
				$apagar81=mysqli_query($conn,"delete from tbleventocomentario where IdEvento=".$apagar);
				$user2=mysqli_query($conn,"select * from tblevento where Id=".$apagar);
				$rows2=mysqli_fetch_array($user2);
				$FotoLocal2=htmlspecialchars($rows2['FotoLocal']);

				if($FotoLocal2!=null && $FotoLocal2!="default.png"){
					unlink('./../help2everyone/Fotos/FotosEvent/'.$FotoLocal2);
				}
				$apagar91=mysqli_query($conn,"delete from tblevento where Id=".$apagar);

			}
		}
		$query=mysqli_query($conn,"Select * from tblorganizacao where Id=".$delete);
		$con=mysqli_fetch_array($query);
		$FotoOrg=htmlspecialchars($con['Foto']);
		$EmailOrg=htmlspecialchars($con['Email']);
		$ComprovaticoOrg=htmlspecialchars($con['Comprovativo']);

		if($FotoOrg!=null){
			//unlink('./../help2everyone/Fotos/FotosOrg/'.$FotoOrg);
		}
		if($ComprovaticoOrg!=null){
			unlink('./../help2everyone/Fotos/ComprovativoOrg/'.$ComprovaticoOrg);
		}
		$apagar20=mysqli_query($conn,"delete from tblrecuperarorg where IdOrganizacao=".$delete);
		$apagar1=mysqli_query($conn,"delete from tblareaatuacao where IdOrganizacao=".$delete);
		$apagar3=mysqli_query($conn,"delete from tblorgrating where IdOrganizacao=".$delete);
		$apagar5=mysqli_query($conn,"delete from tblorgevento where IdOrganizacao=".$delete);
		$apagar7=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$IdOrgcomentario1);
		$apagar9=mysqli_query($conn,"delete from tblorgcomentario where IdOrganizacao=".$delete);
		$apagar10=mysqli_query($conn,"delete from tblreportorg where Id_Organizacao=".$delete);
		$apagar11=mysqli_query($conn,"delete from tblpedidos where IdOrgPediu=".$delete);
		$apagar12=mysqli_query($conn,"delete from tblpedidos where IdOrgPedida=".$delete);
		$apagar13=mysqli_query($conn,"delete from tblvolrating where IdOrganizacao=".$delete);

		if(mysqli_query($conn,"delete from tblorganizacao where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}

	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar2'])){
		$filtrar=2;
		$delete=$_GET['eliminar2'];
		if(mysqli_query($conn,"delete from tblorgrating where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar3'])){
		$filtrar=3;
		$delete=$_GET['eliminar3'];
		if(mysqli_query($conn,"delete from tblorgevento where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar4'])){
		$filtrar=4;
		$delete=$_GET['eliminar4'];
		if(mysqli_query($conn,"delete from tblareaatuacao where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar5'])){
		$filtrar=5;
		$delete=$_GET['eliminar5'];
		$success=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$delete);
		if(mysqli_query($conn,"delete from tblorgcomentario where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar6'])){
		$filtrar=6;
		$delete=$_GET['eliminar6'];
		if(mysqli_query($conn,"delete from tblgostoorgcomentario where Id=".$delete)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}else if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar7'])){
		$filtrar=7;
		$delete=$_GET['eliminar7'];
		if(mysqli_query($conn,"delete from tblareaatucaoevento where Id=".$delete)){
			$msgvisos=1;
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
			<li class="nav-item">
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

      <li class="nav-item active">
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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $Nome_admin." ".$Apelido_admin; ?></span>
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

					<div class="row">

						<?php
						$cmd=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=0");
						$lol=0;
						$info=array();
						while ($seg=mysqli_fetch_array($cmd)) {

							$info[$lol]=$seg[0];
							$lol++;
						}
						$size12=count($info);
						?>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pedidos de Inscrição</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size12; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

					<?php
					$cmd=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=1");
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
										<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Organizações Inscritas</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size1; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-building fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php
					$cmd=mysqli_query($conn,"select Id from tblorgrating");
					$lol=0;
					$info=array();
					while ($seg=mysqli_fetch_array($cmd)) {

						$info[$lol]=$seg[0];
						$lol++;
					}
					$size2=count($info);
					?>

					<div class="col-xl-3 col-md-6 mb-4">
						<div class="card border-left-warning shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Avaliações efetuadas</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size2; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php
					$cmd=mysqli_query($conn,"select Id from tblorgevento");
					$lol=0;
					$info=array();
					while ($seg=mysqli_fetch_array($cmd)) {

						$info[$lol]=$seg[0];
						$lol++;
					}
					$size3=count($info);
					?>

					<div class="col-xl-3 col-md-6 mb-4">
						<div class="card border-left-danger shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Organizações com eventos</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size3; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-comments fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php
					$cmd=mysqli_query($conn,"select Id from tblareaatuacao");
					$lol=0;
					$info=array();
					while ($seg=mysqli_fetch_array($cmd)) {

						$info[$lol]=$seg[0];
						$lol++;
					}
					$size5=count($info);
					?>

					<div class="col-xl-3 col-md-6 mb-4">
						<div class="card border-left-success shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Áreas de Atuação reconhecidas</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size5; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-tree fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					<?php
					if($filtrar==1){
						echo "
						<h1 class='h3 mb-2 text-gray-800'>Listagem Organizações</h1>
	          <p class='mb-4'>Nesta secção estão registadas todos as Organizações do site Help2Everyone.</p>
						";
					}else if($filtrar==2){
						echo "
						<h1 class='h3 mb-2 text-gray-800'>Avaliações Organizações</h1>
						<p class='mb-4'>Nesta secção estão registadas todas as avaliações realizadas a Organizações no Help2Everyone.</p>
						";
					}else if($filtrar==3){
						echo "
						<h1 class='h3 mb-2 text-gray-800'>Organizações Eventos</h1>
						<p class='mb-4'>Nesta secção estão registadas todas as Organizações que apoaim em eventos no site Help2Everyone.</p>
						";
					}else if($filtrar==4){
            echo "
						<h1 class='h3 mb-2 text-gray-800'>Área de Intervenção das Organizações</h1>
						<p class='mb-4'>Nesta secção estão registadas todas as áreas de Atuação das Organizações.</p>
						";
					}else if($filtrar==5){
            echo "
						<h1 class='h3 mb-2 text-gray-800'>Pedidos de Registo de Organizações</h1>
						<p class='mb-4'>Nesta secção estão todos os pedidos de confirmação para a criação das contas de Organizações.</p>
						";
					}
					?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Dados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<?php
									if($filtrar==1){
										echo "
										<thead>
	                    <tr>
												<th>Id</th>
												<th>Foto</th>
												<th>Nome</th>
												<th>Email</th>
												<th>Código-Postal</th>
												<th>Data de Registo</th>
												<th><i class='fas fa-cog'></i></th>
											</tr>
	                  </thead>
	                  <tfoot>
										<tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Código-Postal</th>
                        <th>Data de Registo</th>
												<th><i class='fas fa-cog'></i></th>
												</tr>
	                   </tr>
	                  </tfoot>
										";
									}else if($filtrar==2){
										echo "
										<thead>
	                    <tr>
												<th>Id</th>
	                      <th>Organização (Nome)</th>
	                      <th>Voluntário (Utilizador)</th>
	                      <th>Avaliação (Estrelas)</th>
	                      <th><i class='fas fa-cog'></i></th>
	                    </tr>
	                  </thead>
	                  <tfoot>
	                    <tr>
                        <th>Id</th>
                        <th>Organização (Nome)</th>
                        <th>Voluntário (Utilizador)</th>
                        <th>Avaliação (Estrelas)</th>
  											<th><i class='fas fa-cog'></i></th>
	                    </tr>
	                  </tfoot>
										";
									}else if($filtrar==3){
										echo "
										<thead>
	                    <tr>
												<th>Id</th>
	                      <th>Organização (Nome)</th>
	                      <th>Evento (Nome)</th>
	                      <th><i class='fas fa-cog'></i></th>
	                    </tr>
	                  </thead>
	                  <tfoot>
	                    <tr>
                        <th>Id</th>
                        <th>Organização (Nome)</th>
                        <th>Evento (Nome)</th>
                        <th><i class='fas fa-cog'></i></th>
	                    </tr>
	                  </tfoot>
										";
									}else if($filtrar==4){
                    echo "
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Organização (Nome)</th>
                        <th><i class='fas fa-cog'></i></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Organização (Nome)</th>
                        <th><i class='fas fa-cog'></i></th>
                      </tr>
                    </tfoot>
                    ";
									}else if($filtrar==5){
										echo "
										<thead>
	                    <tr>
												<th>Id</th>
												<th>Foto</th>
												<th>Nome</th>
												<th>Email</th>
												<th>Código-Postal</th>
												<th>Data de Registo</th>
												<th><i class='fas fa-cog'></i></th>
											</tr>
	                  </thead>
	                  <tfoot>
										<tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Código-Postal</th>
                        <th>Data de Registo</th>
												<th><i class='fas fa-cog'></i></th>
												</tr>
	                   </tr>
	                  </tfoot>
										";
									}
									?>
                  <tbody>
										<?php
										if($filtrar==1){
											$cmd=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=1 order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tblorganizacao where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $IdOrganizacao=htmlspecialchars($entrada['Id']);
						              $NomeOrganizacao=htmlspecialchars($entrada['Nome']);
						              $FotoOrganizacao=htmlspecialchars($entrada['Foto']);
						              $EmailOrganizacao=htmlspecialchars($entrada['Email']);
						              $CodPostalOrganizacao=htmlspecialchars($entrada['CodPostal']);
                          $DataRegOrganizacao=htmlspecialchars($entrada['DataReg']);
													$Pic="./../help2everyone/Fotos/FotosOrg/".$FotoOrganizacao;

														echo "
														<tr>
															<td class='text-center'>".$IdOrganizacao."</td>
															<td class='text-center'><img style='width:50px;height:50px' src='".$Pic."'></td>
															<td class='text-center'>".$NomeOrganizacao."</td>
															<td class='text-center'>".$EmailOrganizacao."</td>
															<td class='text-center'>".$CodPostalOrganizacao."</td>
															<td class='text-center'>".$DataRegOrganizacao."</td>
															<td class='text-center'><a href='./organizacao.php?eliminar1=".$IdOrganizacao."' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>
														</tr>
														";
						          }
										}else if($filtrar==2){
											$cmd=mysqli_query($conn,"select Id from tblorgrating order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tblorgrating where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $IdRating=htmlspecialchars($entrada['Id']);
						              $IdVoluntario=htmlspecialchars($entrada['IdVoluntarioreviewer']);
						              $IdOrganizacao=htmlspecialchars($entrada['IdOrganizacao']);
						              $Avaliacao=htmlspecialchars($entrada['Stars']);

						                $queries=mysqli_query($conn,"select * from tblvoluntario where Id=".$IdVoluntario);
						                $row=mysqli_fetch_array($queries);
						                $User_ava=htmlspecialchars($row['Utilizador']);

														$querie2=mysqli_query($conn,"select * from tblorganizacao where Id=".$IdOrganizacao);
														$row2=mysqli_fetch_array($querie2);
														$NomeOrganizacao=htmlspecialchars($row2['Nome']);

														echo "
														<tr>
															<td class='text-center'>".$IdRating."</td>
															<td class='text-center'>".$User_ava."</td>
															<td class='text-center'>".$NomeOrganizacao."</td>
															<td class='text-center'>".$Avaliacao."</td>
															<td class='text-center'><a href='./organizacao.php?eliminar2=".$IdRating."' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>
														</tr>
														";
						          }
										}else if($filtrar==3){
											$cmd=mysqli_query($conn,"select Id from tblorgevento order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tblorgevento where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $Idorgevento=htmlspecialchars($entrada['Id']);
						              $IdOrganizacao=htmlspecialchars($entrada['IdOrganizacao']);
                          $IdEvento=htmlspecialchars($entrada['IdEvento']);

						                $queries=mysqli_query($conn,"select * from tblorganizacao where Id=".$IdOrganizacao);
						                $row=mysqli_fetch_array($queries);
						                $User_ava=htmlspecialchars($row['Nome']);

														$querie2=mysqli_query($conn,"select * from tblevento where Id=".$IdEvento);
														$row2=mysqli_fetch_array($querie2);
														$NomeEvento=htmlspecialchars($row2['Nome']);

														echo "
														<tr>
															<td class='text-center'>".$Idorgevento."</td>
															<td class='text-center'>".$User_ava."</td>
															<td class='text-center'>".$NomeEvento."</td>
															<td class='text-center'><a href='./organizacao.php?eliminar3=".$Idorgevento."' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>
														</tr>
														";
						          }
										}else if($filtrar==4){
											$cmd=mysqli_query($conn,"select Id from tblareaatuacao order by Id Desc");
											$lol=0;
											$info=array();
											while ($seg=mysqli_fetch_array($cmd)) {

												$info[$lol]=$seg[0];
												$lol++;
											}
											$ttam=count($info);

											for($v=0;$v<$ttam;$v++){
												$result=mysqli_query($conn,"select * from tblareaatuacao where Id=".$info[$v]);
													$entrada=mysqli_fetch_array($result);
													$IdAtuacao=htmlspecialchars($entrada['Id']);
													$NomeAtuacao=htmlspecialchars($entrada['Nome']);
													$IdOrganizacao=htmlspecialchars($entrada['IdOrganizacao']);

														$queries=mysqli_query($conn,"select * from tblorganizacao where Id=".$IdOrganizacao);
														$row=mysqli_fetch_array($queries);
														$User_ava=htmlspecialchars($row['Nome']);

														echo "
														<tr>
															<td class='text-center'>".$IdAtuacao."</td>
															<td class='text-center'>".$NomeAtuacao."</td>
															<td class='text-center'>".$User_ava."</td>
															<td class='text-center'><a href='./organizacao.php?eliminar4=".$IdAtuacao."' class='btn btn-danger'><i class='fa fa-trash'></i></a></td>
														</tr>
														";
											}
										}else if($filtrar==5){
											$cmd=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=0 order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tblorganizacao where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $IdOrganizacao=htmlspecialchars($entrada['Id']);
						              $NomeOrganizacao=htmlspecialchars($entrada['Nome']);
						              $FotoOrganizacao=htmlspecialchars($entrada['Foto']);
						              $EmailOrganizacao=htmlspecialchars($entrada['Email']);
						              $CodPostalOrganizacao=htmlspecialchars($entrada['CodPostal']);
                          $DataRegOrganizacao=htmlspecialchars($entrada['DataReg']);
													$Pic="./../help2everyone/Fotos/FotosOrg/".$FotoOrganizacao;

														echo "
														<tr>
															<td class='text-center'>".$IdOrganizacao."</td>
															<td class='text-center'><img style='width:50px;height:50px' src='".$Pic."'></td>
															<td class='text-center'>".$NomeOrganizacao."</td>
															<td class='text-center'>".$EmailOrganizacao."</td>
															<td class='text-center'>".$CodPostalOrganizacao."</td>
															<td class='text-center'>".$DataRegOrganizacao."</td>
															<td class='text-center'><a href='./organizacao.php?desaprovar=".$IdOrganizacao."' title='Descartar Organização' class='btn btn-danger'><i class='fa fa-times'></i></a>
															<a href='./organizacao.php?aprovar=".$IdOrganizacao."' title='Aprovar Organização' class='btn btn-success'><i class='fa fa-check'></i></a></td>
														</tr>
														";
						          }
										}
										?>
                  </tbody>
                </table>
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
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
