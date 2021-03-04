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

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['EditarNoticia'])){
		$variavel=$_GET['EditarNoticia'];
		$comando=mysqli_query($conn,"select * from tblnoticias where Id='".$variavel."'");
		$row=mysqli_fetch_array($comando);
		$Id_Noticia=htmlspecialchars($row['Id']);
    $Foto_Noticia=htmlspecialchars($row['Foto']);
    $Foto_Extra_Noticia=htmlspecialchars($row['Foto_extra']);
    $Foto_Extra_Extra_Noticia=htmlspecialchars($row['Foto_extra_extra']);
    $Titulo_Noticia=htmlspecialchars($row['Titulo']);
    $Data_Noticia=htmlspecialchars($row['Data']);
    $BreveDescricao_Noticia=htmlspecialchars($row['BreveDesc']);
    $Descricao_Noticia=htmlspecialchars($row['Descricao']);
    $Subtitulo_Noticia=htmlspecialchars($row['Subtitulo']);
    $DescSub_Noticia=htmlspecialchars($row['DescricaoSubtitulo']);
    $Facebook_Noticia=htmlspecialchars($row['Facebook']);
    $Instagram_Noticia=htmlspecialchars($row['Instagram']);
    $Twitter_Noticia=htmlspecialchars($row['Twitter']);
    $Linked_Noticia=htmlspecialchars($row['Linkedin']);
    $Tags_Noticias=htmlspecialchars($row['Tags']);
    $Categoria_Noticia=htmlspecialchars($row['Categoria']);

		$inserir=1;
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['EliminarNoticia'])){
		$variavel=$_GET['EliminarNoticia'];
		$oqapa2=mysqli_query($conn,"Select Id from tblvolnoticiacomentario where IdNoticia=".$variavel);
		$row3=mysqli_fetch_array($oqapa2);
		$IdOrgcomentario2=htmlspecialchars($row3['Id']);
		$apag1=mysqli_query($conn,"delete from tbladminnoticiacomentario where IdComentario=".$IdOrgcomentario2);
		if(mysqli_query($conn,"delete from tblvolnoticiacomentario where IdNoticia=".$variavel) &&
		mysqli_query($conn,"delete from tblnoticias where Id=".$variavel)){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['clean'])){
		$Id_Noticia=null;
		$Foto_Noticia=null;
		$Foto_Extra_Noticia=null;
		$Foto_Extra_Extra_Noticia=null;
		$Titulo_Noticia=null;
		$Data_Noticia=null;
		$BreveDescricao_Noticia=null;
		$Descricao_Noticia=null;
		$Subtitulo_Noticia=null;
		$DescSub_Noticia=null;
		$Facebook_Noticia=null;
		$Instagram_Noticia=null;
		$Twitter_Noticia=null;
		$Linked_Noticia=null;
		$Tags_Noticias=null;
		$Categoria_Noticia=null;
		header("Location: ".$_SERVER['PHP_SELF']);
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['InserirNoticia'])){
		$distint=1;
		if (!empty($_POST['Titulo_Noticia'])) {
			$Titulo_Noticia=htmlspecialchars($_POST['Titulo_Noticia']);
		}
		if (!empty($_POST['Data_Noticia'])) {
			$Data_Noticia=htmlspecialchars($_POST['Data_Noticia']);
		}

		$result=mysqli_query($conn,"select * from tblnoticias where Id='".$saber."'");
		$entrada=mysqli_fetch_array($result);
		$foto_volz=htmlspecialchars($entrada['Foto']);
		$foto_extra_volz=htmlspecialchars($entrada['Foto_extra']);
		$foto_extra_extra_volz=htmlspecialchars($entrada['Foto_extra_extra']);

				$caminho=$_FILES['upload']['name'];
				$caminhoTmp=$_FILES['upload']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$saber.$distint.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho);
					$distint++;
					if($foto_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_volz);
					}
				}else{
					$caminho=$foto_volz;
				}

				$caminho2=$_FILES['upload2']['name'];
				$caminho2Tmp=$_FILES['upload2']['tmp_name'];
				if(!empty($caminho2)){
					$explode2=(explode('.',$caminho2));
					$caminho2=$saber.$distint.time().'.'.$explode2[1];
					$criar2=move_uploaded_file($caminho2Tmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho2);
					$distint++;
					if($foto_extra_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_extra_volz);
					}
				}else{
					$caminho2=$foto_extra_volz;
				}

				$caminho3=$_FILES['upload3']['name'];
				$caminho3Tmp=$_FILES['upload3']['tmp_name'];
				if(!empty($caminho3)){
					$explode3=(explode('.',$caminho3));
					$caminho3=$saber.$distint.time().'.'.$explode3[1];
					$criar3=move_uploaded_file($caminho3Tmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho3);
					$distint++;
					if($foto_extra_extra_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_extra_extra_volz);
					}
				}else{
					$caminho3=$foto_extra_extra_volz;
				}


		if (!empty($_POST['BreveDesc_Noticia'])) {
			$BreveDescricao_Noticia=htmlspecialchars($_POST['BreveDesc_Noticia']);
		}
		if (!empty($_POST['Descricao_Noticia'])) {
			$Descricao_Noticia=htmlspecialchars($_POST['Descricao_Noticia']);
		}
		if (!empty($_POST['Subtitulo_Noticia'])) {
			$Subtitulo_Noticia=htmlspecialchars($_POST['Subtitulo_Noticia']);
		}
		if (!empty($_POST['DescSub_Noticia'])) {
			$DescSub_Noticia=htmlspecialchars($_POST['DescSub_Noticia']);
		}
		if (!empty($_POST['Face_Noticia'])) {
			$Facebook_Noticia=htmlspecialchars($_POST['Face_Noticia']);
		}
		if (!empty($_POST['Insta_Noticia'])) {
			$Instagram_Noticia=htmlspecialchars($_POST['Insta_Noticia']);
		}
		if (!empty($_POST['Twitter_Noticia'])) {
			$Twitter_Noticia=htmlspecialchars($_POST['Twitter_Noticia']);
		}
		if (!empty($_POST['Linked_Noticia'])) {
			$Linked_Noticia=htmlspecialchars($_POST['Linked_Noticia']);
		}
		if (!empty($_POST['Tags_Noticia'])) {
			$Tags_Noticias=htmlspecialchars($_POST['Tags_Noticia']);
		}
		if (!empty($_POST['Categoria_Noticia'])) {
			$Categoria_Noticia=htmlspecialchars($_POST['Categoria_Noticia']);
		}
			/*$query1=mysqli_query($conn,"update tblnoticias set Foto='".$caminho."' , Foto_extra='".$caminho2."' , Foto_extra_extra='".$caminho3."' ,
			Titulo='".$Titulo_Noticia."' , Data='".$Data_Noticia."' , BreveDesc='".$BreveDescricao_Noticia."' , Descricao='".$Descricao_Noticia."' ,
			Subtitulo='".$Subtitulo_Noticia."' , DescricaoSubtitulo='".$DescSub_Noticia."' , Facebook='".$Facebook_Noticia."' ,
			Instagram='".$Instagram_Noticia."' , Twitter='".$Twitter_Noticia."' , Linkedin='".$Linked_Noticia."' , Tags='".$Tags_Noticias."' ,
			Categoria=".$Categoria_Noticia." where Id=".$saber);*/

		if(mysqli_query($conn,"insert into tblnoticias(Foto,Foto_extra,Foto_extra_extra,Titulo,Data,BreveDesc,Descricao,Subtitulo,
		DescricaoSubtitulo,Facebook,Instagram,Twitter,Linkedin,Tags,Categoria) values('".$caminho."','".$caminho2."','".$caminho3."','".$Titulo_Noticia."',
		'".$Data_Noticia."','".$BreveDescricao_Noticia."','".$Descricao_Noticia."','".$Subtitulo_Noticia."','".$DescSub_Noticia."','".$Facebook_Noticia."',
		'".$Instagram_Noticia."','".$Twitter_Noticia."','".$Linked_Noticia."','".$Tags_Noticias."',".$Categoria_Noticia.")")){
			$msgvisos=1;
			$Id_Noticia=null;
	    $Foto_Noticia=null;
	    $Foto_Extra_Noticia=null;
	    $Foto_Extra_Extra_Noticia=null;
	    $Titulo_Noticia=null;
	    $Data_Noticia=null;
	    $BreveDescricao_Noticia=null;
	    $Descricao_Noticia=null;
	    $Subtitulo_Noticia=null;
	    $DescSub_Noticia=null;
	    $Facebook_Noticia=null;
	    $Instagram_Noticia=null;
	    $Twitter_Noticia=null;
	    $Linked_Noticia=null;
	    $Tags_Noticias=null;
	    $Categoria_Noticia=null;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['GuardarNoticia'])){
		$saber=htmlspecialchars($_POST['Id_Admin']);
		$distint=1;
		if (!empty($_POST['Titulo_Noticia'])) {
	    $Titulo_Noticia=htmlspecialchars($_POST['Titulo_Noticia']);
	  }
		if (!empty($_POST['Data_Noticia'])) {
			$Data_Noticia=htmlspecialchars($_POST['Data_Noticia']);
		}

		$result=mysqli_query($conn,"select * from tblnoticias where Id='".$saber."'");
		$entrada=mysqli_fetch_array($result);
		$foto_volz=htmlspecialchars($entrada['Foto']);
		$foto_extra_volz=htmlspecialchars($entrada['Foto_extra']);
		$foto_extra_extra_volz=htmlspecialchars($entrada['Foto_extra_extra']);

				$caminho=$_FILES['upload']['name'];
				$caminhoTmp=$_FILES['upload']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$saber.$distint.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho);
					$distint++;
					if($foto_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_volz);
					}
				}else{
					$caminho=$foto_volz;
				}

				$caminho2=$_FILES['upload2']['name'];
				$caminho2Tmp=$_FILES['upload2']['tmp_name'];
				if(!empty($caminho2)){
					$explode2=(explode('.',$caminho2));
					$caminho2=$saber.$distint.time().'.'.$explode2[1];
					$criar2=move_uploaded_file($caminho2Tmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho2);
					$distint++;
					if($foto_extra_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_extra_volz);
					}
				}else{
					$caminho2=$foto_extra_volz;
				}

				$caminho3=$_FILES['upload3']['name'];
				$caminho3Tmp=$_FILES['upload3']['tmp_name'];
				if(!empty($caminho3)){
					$explode3=(explode('.',$caminho3));
					$caminho3=$saber.$distint.time().'.'.$explode3[1];
					$criar3=move_uploaded_file($caminho3Tmp, "./../help2everyone/Fotos/FotosNoticias/".$caminho3);
					$distint++;
					if($foto_extra_extra_volz!=null){
						unlink("./../help2everyone/Fotos/FotosNoticias/".$foto_extra_extra_volz);
					}
				}else{
					$caminho3=$foto_extra_extra_volz;
				}


		if (!empty($_POST['BreveDesc_Noticia'])) {
			$BreveDescricao_Noticia=htmlspecialchars($_POST['BreveDesc_Noticia']);
		}
		if (!empty($_POST['Descricao_Noticia'])) {
			$Descricao_Noticia=htmlspecialchars($_POST['Descricao_Noticia']);
		}
		if (!empty($_POST['Subtitulo_Noticia'])) {
			$Subtitulo_Noticia=htmlspecialchars($_POST['Subtitulo_Noticia']);
		}
		if (!empty($_POST['DescSub_Noticia'])) {
			$DescSub_Noticia=htmlspecialchars($_POST['DescSub_Noticia']);
		}
		if (!empty($_POST['Face_Noticia'])) {
			$Facebook_Noticia=htmlspecialchars($_POST['Face_Noticia']);
		}
		if (!empty($_POST['Insta_Noticia'])) {
			$Instagram_Noticia=htmlspecialchars($_POST['Insta_Noticia']);
		}
		if (!empty($_POST['Twitter_Noticia'])) {
			$Twitter_Noticia=htmlspecialchars($_POST['Twitter_Noticia']);
		}
		if (!empty($_POST['Linked_Noticia'])) {
			$Linked_Noticia=htmlspecialchars($_POST['Linked_Noticia']);
		}
		if (!empty($_POST['Tags_Noticia'])) {
			$Tags_Noticias=htmlspecialchars($_POST['Tags_Noticia']);
		}
		if (!empty($_POST['Categoria_Noticia'])) {
			$Categoria_Noticia=htmlspecialchars($_POST['Categoria_Noticia']);
		}
			$query1=mysqli_query($conn,"update tblnoticias set Foto='".$caminho."' , Foto_extra='".$caminho2."' , Foto_extra_extra='".$caminho3."' ,
			Titulo='".$Titulo_Noticia."' , Data='".$Data_Noticia."' , BreveDesc='".$BreveDescricao_Noticia."' , Descricao='".$Descricao_Noticia."' ,
			Subtitulo='".$Subtitulo_Noticia."' , DescricaoSubtitulo='".$DescSub_Noticia."' , Facebook='".$Facebook_Noticia."' ,
			Instagram='".$Instagram_Noticia."' , Twitter='".$Twitter_Noticia."' , Linkedin='".$Linked_Noticia."' , Tags='".$Tags_Noticias."' ,
			Categoria=".$Categoria_Noticia." where Id=".$saber);

		if($query1){
			$msgvisos=1;
			header("Location: ".$_SERVER['PHP_SELF']);
		}else{
			$msgvisos=2;
		}
		$Id_Noticia=null;
		$Foto_Noticia=null;
		$Foto_Extra_Noticia=null;
		$Foto_Extra_Extra_Noticia=null;
		$Titulo_Noticia=null;
		$Data_Noticia=null;
		$BreveDescricao_Noticia=null;
		$Descricao_Noticia=null;
		$Subtitulo_Noticia=null;
		$DescSub_Noticia=null;
		$Facebook_Noticia=null;
		$Instagram_Noticia=null;
		$Twitter_Noticia=null;
		$Linked_Noticia=null;
		$Tags_Noticias=null;
		$Categoria_Noticia=null;
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
        $cmd=mysqli_query($conn,"select Id from tbladminnoticiacomentario");
        $lol=0;
        $info=array();
        while ($seg=mysqli_fetch_array($cmd)) {

          $info[$lol]=$seg[0];
          $lol++;
        }
        $sizes2=count($info);
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
					<h1 class="h3 mb-0 text-gray-800">Gerir Notícias</h1>
				</div>

					<div class="row">
						<div class="col-md-4">
							<div class="card shadow mb-12">
		            <div class="card-header py-3">
		              <h6 class="m-0 font-weight-bold text-primary">Inserir/Editar Notícias</h6>
		            </div>
		            <div class="card-body">
									<div class="row">
										<form action="./news.php" method="POST" enctype="multipart/form-data">
											<input type="text" name="Id_Admin" id="Id_Admin" value="<?php if(isset($Id_Noticia)){echo $Id_Noticia;} ?>" hidden>
									<div class="col-md-12" style="padding-bottom:5px;">
										<label style="color:black;font-weight:bold;">Foto: </label>
											 <input type="file" name="upload" class="form-control btn btn-primary" accept="image/png, image/jpeg" <?php if(!isset($Foto_Noticia)){echo "required";} ?>>
									 </div>
                   <div class="col-md-12" style="padding-bottom:5px;">
 										<label style="color:black;font-weight:bold;">Foto Extra: </label>
 											 <input type="file" name="upload2" class="form-control btn btn-primary" accept="image/png, image/jpeg" <?php if(!isset($Foto_Extra_Noticia)){echo "required";} ?>>
 									 </div>
                   <div class="col-md-12" style="padding-bottom:5px;">
 										<label style="color:black;font-weight:bold;">Foto Extra Extra: </label>
 											 <input type="file" name="upload3" class="form-control btn btn-primary" accept="image/png, image/jpeg" <?php if(!isset($Foto_Extra_Extra_Noticia)){echo "required";} ?>>
 									 </div>
									<div class="col-md-12" style="padding-bottom:5px;">
										<label style="color:black;font-weight:bold;">Titulo: </label>
											 <input class="form-control" maxlength="60" type="text" name="Titulo_Noticia" placeholder="Insira o Titulo da Noticia" required value="<?php if(isset($Titulo_Noticia)){echo $Titulo_Noticia;} ?>">
									 </div>
									 <div class="col-md-12" style="padding-bottom:5px;">
										 <label style="color:black;font-weight:bold;">Data: </label>
												<input class="form-control" type="date" name="Data_Noticia" placeholder="Insira a data" required value="<?php if(isset($Data_Noticia)){echo $Data_Noticia;} ?>">
										</div>
										<div class="col-md-12" style="padding-bottom:5px;">
											<label style="color:black;font-weight:bold;">Breve Descrição: </label>
												 <textarea rows="2" style="resize:none;" class="form-control" maxlength="110" type="text" name="BreveDesc_Noticia" placeholder="Insira uma Breve Descição da Noticia" required><?php if(isset($BreveDescricao_Noticia)){echo $BreveDescricao_Noticia;} ?></textarea>
										 </div>
										 <div class="col-md-12" style="padding-bottom:5px;">
											 <label style="color:black;font-weight:bold;">Descrição: </label>
													<textarea rows="5" class="form-control" maxlength="3000" type="text" name="Descricao_Noticia" placeholder="Insira uma Descrição da Notícia" required ><?php if(isset($Descricao_Noticia)){echo $Descricao_Noticia;} ?></textarea>
											</div>
											<div class="col-md-12" style="padding-bottom:5px;">
												<label style="color:black;font-weight:bold;">Subtítulo: </label>
													 <input class="form-control" maxlength="100" type="text" name="Subtitulo_Noticia" placeholder="Insira o Subtitulo da Noticia" required value="<?php if(isset($Subtitulo_Noticia)){echo $Subtitulo_Noticia;} ?>">
											 </div>
											 <div class="col-md-12" style="padding-bottom:5px;">
												 <label style="color:black;font-weight:bold;">Descrição Subtitulo: </label>
														<textarea rows="5" class="form-control" maxlength="1500" type="text" name="DescSub_Noticia" placeholder="Insira uma Descrição pós Subtitulo" required><?php if(isset($DescSub_Noticia)){echo $DescSub_Noticia;} ?></textarea>
												</div>
												<div class="col-md-12" style="padding-bottom:5px;">
													<label style="color:black;font-weight:bold;">Página Facebook: </label>
														 <input class="form-control" maxlength="300" type="text" name="Face_Noticia" placeholder="Insira o url da noticia" required value="<?php if(isset($Facebook_Noticia)){echo $Facebook_Noticia;} ?>">
												 </div>
												 <div class="col-md-12" style="padding-bottom:5px;">
													 <label style="color:black;font-weight:bold;">Página Instagram: </label>
															<input class="form-control" maxlength="300" type="text" name="Insta_Noticia" placeholder="Insira o url da noticia" required value="<?php if(isset($Instagram_Noticia)){echo $Instagram_Noticia;} ?>">
													</div>
												 <div class="col-md-12" style="padding-bottom:5px;">
													 <label style="color:black;font-weight:bold;">Página Twitter: </label>
															<input class="form-control" maxlength="300" type="text" name="Twitter_Noticia" placeholder="Insira o url da noticia" required value="<?php if(isset($Twitter_Noticia)){echo $Twitter_Noticia;} ?>">
													</div>
                          <div class="col-md-12" style="padding-bottom:5px;">
                            <label style="color:black;font-weight:bold;">Página LinkedIn: </label>
                               <input class="form-control" maxlength="300" type="text" name="Linked_Noticia" placeholder="Insira o url da noticia" required value="<?php if(isset($Linked_Noticia)){echo $Linked_Noticia;} ?>">
                           </div>
                           <div class="col-md-12" style="padding-bottom:5px;">
                             <label style="color:black;font-weight:bold;">Tags: </label>
                                <input class="form-control" maxlength="100" type="text" name="Tags_Noticia" placeholder="Insira as tags da notícia" required value="<?php if(isset($Tags_Noticias)){echo $Tags_Noticias;} ?>">
                            </div>
                            <div class="col-md-12" style="padding-bottom:5px;">
                              <label style="color:black;font-weight:bold;">Página Categoria: </label>
                                 <select class="custom-select" name="Categoria_Noticia" required>
																	 <?php
																	 $mostrar_categoria="Escolha uma Categoria";
																	 if($Categoria_Noticia==1){
																		 $mostrar_categoria="Ambiente";
																	 }else if($Categoria_Noticia==2){
																		 $mostrar_categoria="Voluntários";
																	 }else if($Categoria_Noticia==3){
																		 $mostrar_categoria="Organizações";
																	 }else if($Categoria_Noticia==4){
																		 $mostrar_categoria="Eventos";
																	 }else if($Categoria_Noticia==5){
																		 $mostrar_categoria="Ajuda Humanitária";
																	 }else if($Categoria_Noticia==6){
																		 $mostrar_categoria="Outros";
																	 }

																	 ?>
                                    <option <?php if(isset($Categoria_Noticia)){echo "value='".$Categoria_Noticia."'";} ?> selected><?php echo $mostrar_categoria; ?></option>
                                    <option value="1">Ambiente</option>
                                    <option value="2">Voluntários</option>
                                    <option value="3">Organizações</option>
                                    <option value="4">Eventos</option>
                                    <option value="5">Ajuda Humanitária</option>
                                    <option value="6">Outros</option>

                                  </select>
                             </div>
														 <div class="col-md-12 text-center" style="padding-top:5px;">
															 <a class="btn btn-secondary" href="news.php?clean"><i class="fas fa-times"></i> Cancelar</a>
															 <?php
															 if($inserir==0){
																 echo "<button class='btn btn-success' type='submit' name='InserirNoticia'><i class='fas fa-plus'></i> Inserir</button></div>";
															 }else{
																 echo "<button class='btn btn-success' type='submit' name='GuardarNoticia'><i class='fas fa-save'></i> Guardar</button></div>";
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
              <h6 class="m-0 font-weight-bold text-primary">Visualizar Notícias</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
	                    <tr>
												<th>Id</th>
                        <th>Foto</th>
												<th>Titulo</th>
												<th>Breve Descrição</th>
												<th>Categoria</th>
												<th>Data</th>
												<th><i class='fas fa-cog'></i></th>
											</tr>
	                  </thead>
	                  <tfoot>
										<tr>
                        <th>Id</th>
                        <th>Foto</th>
                        <th>Titulo</th>
                        <th>Breve Descrição</th>
                        <th>Categoria</th>
                        <th>Data</th>
												<th><i class='fas fa-cog'></i></th>
												</tr>
	                   </tr>
	                  </tfoot>
                  <tbody>
										<?php
											$cmd=mysqli_query($conn,"select Id from tblnoticias order by Id Desc");
						          $lol=0;
						          $info=array();
						          while ($seg=mysqli_fetch_array($cmd)) {

						            $info[$lol]=$seg[0];
						            $lol++;
						          }
						          $ttam=count($info);

						          for($v=0;$v<$ttam;$v++){
						            $result=mysqli_query($conn,"select * from tblnoticias where Id=".$info[$v]);
						              $entrada=mysqli_fetch_array($result);
						              $Id_Noticia=htmlspecialchars($entrada['Id']);
						              $TituloNoticia=htmlspecialchars($entrada['Titulo']);
                          $BreveDescricao_Noticia=htmlspecialchars($entrada['BreveDesc']);
						              $Foto_Noticia=htmlspecialchars($entrada['Foto']);
													$Foto_Extra_Noticia=htmlspecialchars($entrada['Foto_extra']);
													$Foto_Extra_Extra_Noticia=htmlspecialchars($entrada['Foto_extra_extra']);
						              $Categoria_Noticia=htmlspecialchars($entrada['Categoria']);
						              $Data_Noticia=htmlspecialchars($entrada['Data']);
													$Pic="./../help2everyone/Fotos/FotosNoticias/".$Foto_Noticia;
													$Pic2="./../help2everyone/Fotos/FotosNoticias/".$Foto_Extra_Noticia;
													$Pic3="./../help2everyone/Fotos/FotosNoticias/".$Foto_Extra_Extra_Noticia;
                          if($Categoria_Noticia==1){
                            $cat_final="Ambiente";
                          }else if($Categoria_Noticia==2){
                            $cat_final="Voluntários";
                          }else if($Categoria_Noticia==3){
                            $cat_final="Organizações";
                          }else if($Categoria_Noticia==4){
                            $cat_final="Eventos";
                          }else if($Categoria_Noticia==5){
                            $cat_final="Ajuda Humanitária";
                          }else if($Categoria_Noticia==6){
                            $cat_final="Outros";
                          }


														echo "
														<tr>
															<td class='text-center'>".$Id_Noticia."</td>
															<td class='text-center'><img style='width:50px;height:50px;padding-bottom:2px;' src='".$Pic."'> <img style='width:50px;height:50px;padding-bottom:2px;' src='".$Pic2."'> <img style='width:50px;height:50px;padding-bottom:2px;' src='".$Pic3."'></td>
															<td class='text-center'>".$TituloNoticia."</td>
                              <td class='text-center'>".$BreveDescricao_Noticia."</td>
															<td class='text-center'>".$cat_final."</td>
															<td class='text-center'>".$Data_Noticia."</td>
															<td class='text-center'><a href='./news.php?EliminarNoticia=".$Id_Noticia."' class='btn btn-danger'><i class='fa fa-trash'></i></a><br><br><a href='./news.php?EditarNoticia=".$Id_Noticia."' class='btn btn-warning'><i class='fa fa-cog'></i></a></td>
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
