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
  $Identificacao=htmlspecialchars($resultq['Id']);
  $Nome1_admin=htmlspecialchars($resultq['Nome']);
  $Apelido1_admin=htmlspecialchars($resultq['Apelido']);
	$msgvisos=0;
	$inserir=0;

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['comentar'])){
		$variavel=$_GET['comentar'];
		$Id_Noticia=$variavel;
		$inserir=1;
	}

  if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['check'])){
		$marcarvista=$_GET['check'];
		if(mysqli_query($conn,"update tblvolnoticiacomentario set Visto=1 where Id=".$marcarvista)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['uncheck'])){
		$marcarvista=$_GET['uncheck'];
		if(mysqli_query($conn,"update tblvolnoticiacomentario set Visto=0 where Id=".$marcarvista)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['delete'])){
		$variavel=$_GET['delete'];
		if(mysqli_query($conn,"delete from tbladminnoticiacomentario where IdComentario=".$variavel) &&
    mysqli_query($conn,"delete from tblvolnoticiacomentario where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['InserirNoticia'])){
		if (!empty($_POST['Descricao'])) {
			$Descricao_Noticia=htmlspecialchars($_POST['Descricao']);
		}
		if (!empty($_POST['Id_Comentario'])) {
			$Id_Noticia=htmlspecialchars($_POST['Id_Comentario']);
		}

    date_default_timezone_set('Europe/Lisbon');
    $datinha = date('Y-m-d H:i');

		if(mysqli_query($conn,"insert into tbladminnoticiacomentario(IdAdmin,IdComentario,Descricao,DataHora) values(".$Identificacao.",".$Id_Noticia.",
		'".$Descricao_Noticia."','".$datinha."')")){
			$msgvisos=1;
			$Id_Noticia=null;
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
      <li class="nav-item active">
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
						<h1 class="h3 mb-0 text-gray-800">Notícias</h1>
					</div>
					<div class="row">

					<?php
					$cmd=mysqli_query($conn,"select Id from tblnoticias");
					$lol=0;
					$info=array();
					while ($seg=mysqli_fetch_array($cmd)) {

						$info[$lol]=$seg[0];
						$lol++;
					}
					$size1=count($info);
					?>

					<div class="col-xl-3 col-md-6 mb-4">
						<div class="card border-left-success shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Notícias registadas</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $size1; ?></div>
									</div>
									<div class="col-auto">
										<i class="fas fa-tree fa-2x text-gray-300"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

        <?php
        $cmd=mysqli_query($conn,"select Id from tblvolnoticiacomentario");
        $lol=0;
        $info=array();
        while ($seg=mysqli_fetch_array($cmd)) {

          $info[$lol]=$seg[0];
          $lol++;
        }
        $sizes=count($info);
        ?>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Opiniões realizadas</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sizes; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
        $cmd=mysqli_query($conn,"select Id from tbladminnoticiacomentario order by Id Desc");
        $lol=0;
        $com=array();
        while ($seg=mysqli_fetch_array($cmd)) {

          $com[$lol]=$seg[0];
          $lol++;
        }
        $sizes2=count($com);
        ?>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Comentários Admin</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sizes2; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

				<div class="d-sm-flex align-items-center justify-content-between mb-4">
					<h1 class="h3 mb-0 text-gray-800">Gerir Comentários</h1>
				</div>

					<div class="row">
						<div class="col-md-4">
							<div class="card shadow mb-12">
		            <div class="card-header py-3">
		              <h6 class="m-0 font-weight-bold text-primary">Comentar Opinião</h6>
		            </div>
		            <div class="card-body">
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row">
                      <input type="number" id="Id_Comentario" name="Id_Comentario" value="<?php if(isset($Id_Noticia)){echo $Id_Noticia;} ?>" hidden>
                    <div class="col-md-12">
                      <textarea  maxlength="500" type="text" placeholder="Insira uma Descrição!" class="form-control" rows="5" name="Descricao"></textarea>
                    </div>
                    <div class="col-md-12 text-center" style="padding-top:5px;">
                      <?php
                      if($inserir==0){
                        echo "<button class='btn btn-success' title='Precisa de escolher um comentário' disabled type='submit' name='InserirNoticia'><i class='fas fa-plus'></i> Inserir</button></div>";
                      }else{
                        echo "<button class='btn btn-success' title='Comentar!' type='submit' name='InserirNoticia'><i class='fas fa-plus'></i> Inserir</button></div>";
                      }
                      ?>
                    </div>
                  </form>
		            </div>
		          </div>

					</div>
					<div class="col-md-8">

          <?php
          $cmd=mysqli_query($conn,"select Id from tblvolnoticiacomentario order by Id Desc");
          $lol=0;
          $info=array();
          while ($seg=mysqli_fetch_array($cmd)) {

            $info[$lol]=$seg[0];
            $lol++;
          }
          $taman=count($info);

          for($i=0;$i<$taman;$i++){
            $result=mysqli_query($conn,"select * from tblvolnoticiacomentario where Id=".$info[$i]);
              $entrada=mysqli_fetch_array($result);
              $identity_Comentario=htmlspecialchars($entrada['Id']);
              $Nome_Comentario=htmlspecialchars($entrada['Nome']);
              $Email_Comentario=htmlspecialchars($entrada['Email']);
              $Descricao_Comentario=htmlspecialchars($entrada['Descricao']);
              $IdNoticia_Comentario=htmlspecialchars($entrada['IdNoticia']);
              $DH_Comentario=htmlspecialchars($entrada['DataHora']);
              $Vista_Comentario=htmlspecialchars($entrada['Visto']);
              date_default_timezone_set('Europe/Lisbon');
              $data4 = date('Y-m-d H:i');

              $date1  = new DateTime($DH_Comentario);
              $date3 = new DateTime($data4);

              $diferences=($date3->diff($date1));
              $diferences1=($date3->diff($date1));
              $diffs=$diferences->format('%H Horas');
              $diffs1=$diferences1->format('%a Dias');
              if($diffs1<1){
                $difinals=$diffs;
              }else{
                $difinals=$diffs1;
              }
              if($Vista_Comentario==0){
                $Vistas="<span class='badge badge-pill badge-warning'>1</span>";
                $simbol="fas fa-check";
								$text="Marcar Lido";
                $ser="./newscoment.php?check=".$identity_Comentario."";
              }else{
                $Vistas=null;
                $simbol="fas fa-times";
								$text="Não Lido";
                $ser="./newscoment.php?uncheck=".$identity_Comentario."";
              }

              echo "
              <div class='col-lg-12'>
                <div class='card shadow mb-4'>
                  <a href='#collapseCardExample".$i."' class='d-block card-header py-3' data-toggle='collapse' role='button' aria-expanded='true' aria-controls='collapseCardExample'>
                    <h6 class='m-0 font-weight-bold text-primary'>".$Vistas." ".$Email_Comentario."<span style='color:grey;font-weight: normal;'> - ".$difinals."</span></h6>
                  </a>
                  <div class='collapse' id='collapseCardExample".$i."'>
                    <div class='card-body'>
                      <div class='row'>
                        <div class='col-md-12' style='border-bottom: 2px solid lightgrey;'>
                          <strong>Nome Opinador: </strong>".$Nome_Comentario."<br>
                          <strong>Opinião: </strong>".$Descricao_Comentario."<br>
                          </div>";

                          $cmd=mysqli_query($conn,"select Id from tbladminnoticiacomentario where IdComentario=".$identity_Comentario." order by Id Desc");
                          $lol=0;
                          $com=array();
                          while ($seg=mysqli_fetch_array($cmd)) {

                            $com[$lol]=$seg[0];
                            $lol++;
                          }
                          $ttt=count($com);

                          for($f=0;$f<$ttt;$f++){
                            $results=mysqli_query($conn,"select * from tbladminnoticiacomentario where Id=".$com[$f]);
                              $entradas=mysqli_fetch_array($results);
                              $Id_ComAdmin=htmlspecialchars($entradas['Id']);
                              $Iddo_Admin=htmlspecialchars($entradas['IdAdmin']);
                              $Descricao_Admin=htmlspecialchars($entradas['Descricao']);
                              $DH_Admin=htmlspecialchars($entradas['DataHora']);

                              $query=mysqli_query($conn,"select * from tbladmin where Id=".$Iddo_Admin);
                                $row=mysqli_fetch_array($query);
                                $Email_Admin=htmlspecialchars($entrada['Email']);

                                date_default_timezone_set('Europe/Lisbon');
                                $data5 = date('Y-m-d H:i');

                                $data1  = new DateTime($DH_Admin);
                                $data2 = new DateTime($data5);

                                $diferenca=($data2->diff($data1));
                                $diferencas=($data2->diff($data1));
                                $diffs2=$diferenca->format('%H Horas');
                                $diffs3=$diferencas->format('%a Dias');
                                if($diffs3<1){
                                  $difinalse=$diffs2;
                                }else{
                                  $difinalse=$diffs3;
                                }
                              echo "
                              <div class='col-md-12' style='padding-top:5px;padding-left:5%;'>
                                <strong>Email Admin: </strong>".$Email_Admin."<br>
                                <strong>Comentário: </strong>".$Descricao_Admin."<br>
                                Há ".$difinalse."<br>
                                </div>";
                          }

                          echo "
                          <div class='col-md-4' style='padding-top:7px;text-align:center;'>
                          <a href='./newscoment.php?comentar=".$identity_Comentario."' class='btn btn-success btn-icon-split'>
                            <span class='icon text-white-50'>
                              <i class='fas fa-comments'></i>
                            </span>
                            <span class='text'>Comentar</span>
                          </a>
                          </div>
                          <div class='col-md-4' style='padding-top:7px;text-align:center;'>
                          <a href='".$ser."' class='btn btn-warning btn-icon-split'>
                            <span class='icon text-white-50'>
                              <i class='".$simbol."'></i>
                            </span>
                            <span class='text'>".$text."</span>
                          </a>
                          </div>
                          <div class='col-md-4' style='padding-top:7px;text-align:center;'>
                          <a href='./newscoment.php?delete=".$identity_Comentario."' class='btn btn-danger btn-icon-split'>
                            <span class='icon text-white-50'>
                              <i class='fas fa-trash'></i>
                            </span>
                            <span class='text'>Eliminar</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>";
          }
          ?>
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
