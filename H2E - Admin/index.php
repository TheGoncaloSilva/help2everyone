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
  $Nome_admin=htmlspecialchars($resultq['Nome']);
  $Apelido_admin=htmlspecialchars($resultq['Apelido']);

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrirvol'])){
		$inserir=$_GET['abrirvol'];
		$_SESSION['openvol']=$inserir;
		header('Location: ./voluntarios.php');
	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrirorg'])){
		$inserir=$_GET['abrirorg'];
		$_SESSION['openorg']=$inserir;
		header('Location: ./organizacao.php');
	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrirevent'])){
		$inserir=$_GET['abrirevent'];
		$_SESSION['openevent']=$inserir;
		header('Location: ./eventos.php');
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

  <title>H2E: Dashboard-Admin</title>
  <link rel="icon" href="./img/logo.ico">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
      <li class="nav-item active">
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>


          <div class="row">

            <?php
            $date1 = '2018-11-05';
            $date2 = date('y-m-d');

            $ts1 = strtotime($date1);
            $ts2 = strtotime($date2);

            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);

            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            ?>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Online há</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $diff; ?> Meses</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $resultado=mysqli_query($conn,"select Id from tblvoluntario");
            $l=0;
            $dados=array();
            while ($linha=mysqli_fetch_array($resultado)) {

              $dados[$l]=$linha[0];
              $l++;
            }
            $tt=count($dados);
            ?>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Voluntários na plataforma</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tt; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $res=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=1");
            $l1=0;
            $dado=array();
            while ($linhas=mysqli_fetch_array($res)) {

              $dado[$l1]=$linhas[0];
              $l1++;
            }
            $tam=count($dado);
            ?>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Organizações na plataforma</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tam; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $cmd=mysqli_query($conn,"select Id from tblevento");
            $lol=0;
            $info=array();
            while ($seg=mysqli_fetch_array($cmd)) {

              $info[$lol]=$seg[0];
              $lol++;
            }
            $tas=count($info);
            ?>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Eventos realizados</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tas; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Denúncias realizadas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $taman; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-bug fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $cmd=mysqli_query($conn,"select Id from tblcontato");
            $lol=0;
            $info=array();
            while ($seg=mysqli_fetch_array($cmd)) {

              $info[$lol]=$seg[0];
              $lol++;
            }
            $tama=count($info);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Contactos feitos</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tama; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


					<?php

					$Janeiro=0;
					$Fevereiro=0;
					$Marco=0;
					$Abril=0;
					$Maio=0;
					$Junho=0;
					$Julho=0;
					$Agosto=0;
					$Setembro=0;
					$Outubro=0;
					$Novembro=0;
					$Dezembro=0;

					$res=mysqli_query($conn,"select Registo from tblvoluntario");
					$contador=0;
					$inf=array();
					while ($row=mysqli_fetch_array($res)) {
						$inf[$contador]=$row[0];

						$ts1 = strtotime($row[0]);
						$dia = date('d', $ts1);
						$mes = date('m', $ts1);
						$ano = date('Y', $ts1);
						switch ($mes) {
							case '01':$Janeiro++;break;
							case '02':$Fevereiro++;break;
							case '03':$Marco++;break;
							case '04':$Abril++;break;
							case '05':$Maio++;break;
							case '06':$Junho++;break;
							case '07':$Julho++;break;
							case '08':$Agosto++;break;
							case '09':$Setembro++;break;
							case '10':$Outubro++;break;
							case '11':$Novembro++;break;
							case '12':$Dezembro++;break;
							default:break;
						}

						$l1++;
					}
					$tam=count($dado);
					?>

					<input hidden type="text" id="Organizacoes"  name="Organizacoes" value="<?php echo $tam; ?>">
					<input hidden type="text" id="Voluntarios" name="Voluntarios" value="<?php echo $tt; ?>">
					<input hidden type="text" id="Eventos" name="Eventos" value="<?php echo $tas; ?>">

					<input hidden type="text" id="Janeiro" name="Janeiro" value="<?php echo $Janeiro; ?>">
					<input hidden type="text" id="Fevereiro" name="Fevereiro" value="<?php echo $Fevereiro; ?>">
					<input hidden type="text" id="Marco" name="Marco" value="<?php echo $Marco; ?>">
					<input hidden type="text" id="Abril" name="Abril" value="<?php echo $Abril; ?>">
					<input hidden type="text" id="Maio" name="Maio" value="<?php echo $Maio; ?>">
					<input hidden type="text" id="Junho" name="Junho" value="<?php echo $Junho; ?>">
					<input hidden type="text" id="Julho" name="Julho" value="<?php echo $Julho; ?>">
					<input hidden type="text" id="Agosto" name="Agosto" value="<?php echo $Agosto; ?>">
					<input hidden type="text" id="Setembro" name="Setembro" value="<?php echo $Setembro; ?>">
					<input hidden type="text" id="Outubro" name="Outubro" value="<?php echo $Outubro; ?>">
					<input hidden type="text" id="Novembro" name="Novembro" value="<?php echo $Novembro; ?>">
					<input hidden type="text" id="Dezembro" name="Dezembro" value="<?php echo $Dezembro; ?>">


          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Data de Registo dos Voluntários</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Registados</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Voluntários
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Organizações
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Eventos
                    </span>
                  </div>
                </div>
              </div>
            </div>

          </div>
					<!-- Bar Chart
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Data de Registo dos Voluntários</h6>
						</div>
						<div class="card-body">
							<div class="chart-bar">
								<canvas id="myBarChart"></canvas>
							</div>
						</div>
					</div>
        </div>-->
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
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
	<script src="js/demo/chart-bar-demo.js"></script>

</body>

</html>
<?php
include('./inicligacao.ini');
?>
