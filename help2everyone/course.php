<?php
include('./inicligacao.ini');
session_start();
if((isset ($_SESSION['user']) == true)){
	$logado=$_SESSION['user'];
	$logtype='Voluntario';
	$result=mysqli_query($conn,"select * from tblvoluntario where Utilizador='".$logado."'");
	$logf=mysqli_fetch_array($result);
	$logfoto=htmlspecialchars($logf['Foto']);
	$logfotof="./Fotos/FotosVol/".$logfoto;
	$login=true;
	if($_SESSION['targetevent']==true){
		$targetevent=$_SESSION['targetevent'];
	}else{
		header('Location: ./courses.php');
	}
}else if((isset ($_SESSION['nome']) == true)){
	$logado=$_SESSION['nome'];
	$logtype='Organizacao';
	$result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$logado."'");
	$logf=mysqli_fetch_array($result);
	$logfoto=htmlspecialchars($logf['Foto']);
	$logaprovado=htmlspecialchars($logf['Aprovada']);
	$logfotof="./Fotos/FotosOrg/".$logfoto;
	$logId=htmlspecialchars($logf['Id']);
	$login=true;
	if($_SESSION['targetevent']==true){
		$targetevent=$_SESSION['targetevent'];
	}else{
		header('Location: ./courses.php');
	}
}else{
	$login=false;
	$logtype='NaoExiste';
	$logfotof="./Fotos/FotosVol/userimg.png";
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['nome']);
	header('Location: ./ChooseLog/index.html');
	}
	$logfolder=null;
	if($logtype=='Organizacao'){
		$logfolder="listagemorg.php";
	}else{
		$logfolder="listagem.php";
	}
	$result=mysqli_query($conn,"select * from tblvoluntario where Utilizador='".$logado."'");
	$entrada=mysqli_fetch_array($result);
	$identidade=htmlspecialchars($entrada['Id']);
	$msgvisos=0;
		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir_org'])){
	$_SESSION['targetorg']=$_GET['abrir_org'];
	header('Location: ./Resumeorg/index.php');
	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir']))
{
	$_SESSION['targetevent']=$_GET['abrir'];
	header('Location: ./course.php');
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir_vol']))
{
$_SESSION['targetvol']=$_GET['abrir_vol'];
header('Location: ./Resume/index.php');
}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['concorrer'])){
		if(mysqli_query($conn,"insert into tblvolevento(IdEvento,IdVoluntario) values('".$targetevent."','".$identidade."')")){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
		unset($_GET);
		header("Location: ".$_SERVER['PHP_SELF']);

}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['GetOut'])){
	if(mysqli_query($conn,"delete from tblvolevento where IdEvento=".$targetevent." && IdVoluntario=".$identidade)){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']);

}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['rating']))
{
 $estrelas=$_GET['rating'];
	if(mysqli_query($conn,"insert into tbleventorating(IdEvento,IdVoluntario,Rating) values('".$targetevent."','".$identidade."','".$estrelas."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']);

}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['gostarla']))
{
 $Idpreciso=$_GET['gostarla'];
	if(mysqli_query($conn,"insert into tblgostocomentario(IdComentario,IdVoluntario) values('".$Idpreciso."','".$identidade."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']);
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['gostaracola']))
{
 $Idpreciso1=$_GET['gostaracola'];
	if(mysqli_query($conn,"insert into tblgostoorgcomentario(IdOrgComentario,IdVoluntario) values('".$Idpreciso1."','".$identidade."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']);

}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['coment']))
{
	if (!empty($_POST['descricao'])) {
		$comentario=htmlspecialchars($_POST['descricao']);
	}
	if($logtype=="Organizacao"){
		if (!empty($_POST['resposta'])) {
			$resposta=htmlspecialchars($_POST['resposta']);
		}
		date_default_timezone_set('Europe/Lisbon');
		$data_hora = date('Y-m-d H:i');
		if(mysqli_query($conn,"insert into tblorgcomentario(IdOrganizacao,IdComentario,Descricao,DataHora) values('".$logId."','".$resposta."','".$comentario."','".$data_hora."')")){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
	}else{
		date_default_timezone_set('Europe/Lisbon');
		$data_hora = date('Y-m-d H:i');
		if(mysqli_query($conn,"insert into tbleventocomentario(IdVoluntario,IdEvento,Descricao,DataHora) values('".$identidade."','".$targetevent."','".$comentario."','".$data_hora."')")){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);

}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn1']))
{
	if (!empty($_POST['Descricao_ocorrencia'])) {
		$Descricao_ocorrencia=htmlspecialchars($_POST['Descricao_ocorrencia']);
	}
	if (!empty($_POST['Email_ocorrencia'])) {
		$Email_ocorrencia=htmlspecialchars($_POST['Email_ocorrencia']);
	}
	if (!empty($_POST['Nome_ocorrencia'])) {
		$Nome_ocorrencia=htmlspecialchars($_POST['Nome_ocorrencia']);
	}
	$tipo=1;
	date_default_timezone_set('Europe/Lisbon');
	$dh = date('Y-m-d H:i');
	if(mysqli_query($conn,"insert into tblreports(Nome,Email,Tipo,Descricao,DataHora) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);

}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn4']))
{
	if (!empty($_POST['Descricao_ocorrencia'])) {
		$ocorrencia=htmlspecialchars($_POST['Descricao_ocorrencia']);
	}
	if (!empty($_POST['Email_ocorrencia'])) {
		$Email_ocorrencia=htmlspecialchars($_POST['Email_ocorrencia']);
	}
	if (!empty($_POST['Nome_ocorrencia'])) {
		$Nome_ocorrencia=htmlspecialchars($_POST['Nome_ocorrencia']);
	}
	$tipo=4;
	date_default_timezone_set('Europe/Lisbon');
	$dh = date('Y-m-d H:i');
	if(mysqli_query($conn,"insert into tblreports(Nome,Email,Tipo,Descricao,DataHora) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$ocorrencia."','".$dh."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);

}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<title>H2E: Eventos</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="Help2Everyone">
<!--
<meta name="description" content="Unicat project">-->
<link rel="icon" href="./images/logo.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/course.css">
<link rel="stylesheet" type="text/css" href="styles/course_responsive.css">
</head>
<body>

<div class="super_container">

	<!-- Header -->

	<header class="header">

		<!-- Top Bar -->
		<div class="top_bar">
			<div class="top_bar_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
								<ul class="top_bar_contact_list">
									<li><div class="question">Tens alguma questão?</div></li>
									<li>
										<i class="fa fa-phone" aria-hidden="true"></i>
										<div>351-232465159</div>
									</li>
									<li>
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
										<div>help2everyone.pap@gmail.com</div>
									</li>
								</ul>
								<div class="top_bar_login ml-auto">
									<div class="login_button">
										<a href='./ChooseLog/index.html'>Registar ou Entrar</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Content -->
		<div class="header_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="header_content d-flex flex-row align-items-center justify-content-start">
							<div class="logo_container">
								<a class="navbar-brand" href="./index.php">
									<img src="./images/shortlogo.ico" class="d-inline-block align-top imgnav Logo_text" alt="Help2Everyone">
							</a>
							</div>
							<nav class="main_nav_contaner ml-auto">
								<ul class="main_nav">
									<li><a href="index.php">Home</a></li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Sobre
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
											<a class="dropdown-item" href="about.php">Sobre</a>
											<a class="dropdown-item" href="blog.php">Notícias</a>
									</li>
									<li class="active"><a href="courses.php">Eventos</a></li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Registados
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown">
											<a class="dropdown-item" href="listagem.php">Voluntários</a>
											<a class="dropdown-item" href="listagemorg.php">Organizações</a>
									</li>
									<li><a href="contact.php">Contato</a></li>
									<li class="nav-item dropdown">
									<button <?php if($login==false){echo "disabled";} ?> class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img <?php  if($login==false){echo "title='Precisa de iniciar sessão primeiro'";} ?> src=<?php echo "$logfotof"; ?> style="width:35px;height:35px;" class="userimage">
                  </button>
									<?php if($logtype=='Voluntario'){ $pasta="./Resume/index.php";}else if($logtype=='Organizacao'){ $pasta="./Resumeorg/index.php";} ?>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="./index.php?abrir_org" ><?php echo $logado; ?></a>
                      <a class="dropdown-item" href="<?php echo $logfolder; ?>"><?php echo $logtype; ?></a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout  <i class="fa fa-sign-out"></i></a>
                    </div>
									</li>
									<li><a href="#" data-toggle="modal" data-target="#ReportModal"><i class="fa fa-exclamation-triangle"></i></a></li>
								</ul>

								<!-- Hamburger -->
								<div class="hamburger menu_mm">
									<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
								</div>

							</nav>

						</div>
					</div>
				</div>
			</div>
		</div>

	</header>

	<!-- Reportar -->
	<div class="modal fade" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Reportar uma situação</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="./course.php" method="POST">
			<div class="modal-body">
				<div class="row" style="padding-top:15px;padding-bottom:5px;">
					<div class="col-6">
						<input class="container form-control" name="Nome_ocorrencia" placeholder="Nome">
					</div>
					<div class="col-6">
						<input class="container form-control" name="Email_ocorrencia" placeholder="Email">
					</div>
					<div class="col-12" style="padding-top:15px;">
						<textarea style="resize:none" rows="6" maxlength="1000" name="Descricao_ocorrencia" class="container form-control" placeholder="Descreva a situação"></textarea>
					</div>
			</div>
				<p style="padding-bottom:10px; font-size: large;">Por favor escolha a razão/problema da situação</p>
				<button type="submit" name="btn1" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Publicação de conteúdo inapropriado ou ofensivo</button>
				<!--<button type="submit" name="btn2" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Spam, perturbação ou assédio</button>
				<button type="submit" name="btn3" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Roubo, burla, fraude, ou outra atividade</button>-->
				<button type="submit" name="btn4" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Erros no website</button>
			</div>
		</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Sair</button>
			</div>
		</div>
	</div>
</div>
<!-- End Reportar -->

	<!-- Menu -->

	<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
		<div class="menu_close_container"><div class="menu_close"><div></div><div></div></div></div>
		<nav class="menu_nav">
			<ul class="menu_mm">
				<li class="menu_mm"><a href="./index.php">Home</a></li>
				<li class="menu_mm"><a href="./about.php">Sobre</a></li>
				<li class="menu_mm"><a href="./courses.php">Eventos</a></li>
				<li class="menu_mm"><a href="./blog.php">Notícias</a></li>
				<li class='menu_mm'><a class='dropdown-toggle' style='color:black' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						Registados
				</a>
					<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
						<a class='dropdown-item' href='listagem.php'>Voluntários</a>
						<a class='dropdown-item' href='listagemorg.php'>Organizações</a>
					</div>
				</li>
				<li class="menu_mm"><a href="contact.php">Contato</a></li>
				<?php
				if($login==false){
					echo "<li class='menu_mm'><a href='./ChooseLog/index.html'>Iniciar Sessão</a></li>";
				}else{
					echo
					"<li class='menu_mm'><a class='dropdown-toggle' style='color:black' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							".$logado."
					</a>
						<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
							<a class='dropdown-item' href='./index.php?abrir_org'>".$logado."</a>
							<a class='dropdown-item' href='".$logfolder."'>".$logtype."</a>
							<a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'>Logout  <i class='fa fa-sign-out'></i></a>
						</div>
					</li>";
				}
				?>
			</ul>
		</nav>
	</div>

	<!-- Home -->

	<div class="home">
		<div class="breadcrumbs_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="courses.php">Eventos</a></li>
								<li>Detalhe Evento</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Course -->

	<div class="course">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-8">
					<?php
					$select=mysqli_query($conn,"select * from tblevento where Id=".$targetevent);
					$linha=mysqli_fetch_array($select);
					$Id_Ev=htmlspecialchars($linha['Id']);
					$Foto_ev=htmlspecialchars($linha['FotoLocal']);
					$Nome_ev=htmlspecialchars($linha['Nome']);
					$Pais_ev=htmlspecialchars($linha['Pais']);
					$Morada_Ev=htmlspecialchars($linha['Morada']);
					$CodPostal_Ev=htmlspecialchars($linha['CodPostal']);
					$Distrito_Ev=htmlspecialchars($linha['Distrito']);
					$Concelho_Ev=htmlspecialchars($linha['Concelho']);
					$Freguesia_Ev=htmlspecialchars($linha['Freguesia']);
					$FuncVol_Ev=htmlspecialchars($linha['FuncaoVoluntario']);
					$BreveDesc_Ev=htmlspecialchars($linha['BreveDesc']);
					$Descricao_Ev=htmlspecialchars($linha['Descricao']);
					$NumVagas_Ev=htmlspecialchars($linha['NumVagas']);
					$DataInicio_Ev=htmlspecialchars($linha['DataInicio']);
					$DataFim_Ev=htmlspecialchars($linha['DataTermino']);
					$Duracao_Ev=htmlspecialchars($linha['Duracao']);
					$Idioma_Ev=htmlspecialchars($linha['Idioma']);
					$Compromisso_Ev=htmlspecialchars($linha['Compromisso']);
					$GrupoAlvo_Ev=htmlspecialchars($linha['GrupoAlvo']);
					$Helps_Ev=htmlspecialchars($linha['Quant_Helps']);
					$IdOrganizacao=htmlspecialchars($linha['IdOrganizacao']);
					$Reconhecido=htmlspecialchars($linha['Reconhecido']);
					$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
					$entrada=mysqli_fetch_array($company);
					$NomeOrganização_Ev=$entrada[0];

					$ts2 = strtotime($DataInicio_Ev);
					$dias = date('d', $ts2);
					$meses = date('m', $ts2);
					$anos = date('Y', $ts2);

					switch ($meses) {
						case '01':$meses='Janeiro';break;
						case '02':$meses='Fevereiro';break;
						case '03':$meses='Março';break;
						case '04':$meses='Abril';break;
						case '05':$meses='Maio';break;
						case '06':$meses='Junho';break;
						case '07':$meses='Julho';break;
						case '08':$meses='Agosto';break;
						case '09':$meses='Setembro';break;
						case '10':$meses='Outubro';break;
						case '11':$meses='Novembro';break;
						case '12':$meses='Dezembro';break;
						default:break;
					}
					$DataInicioEvento=$dias." de ".$meses." de ".$anos;

								$tempo = strtotime($DataFim_Ev);
								$day = date('d', $tempo);
								$month = date('m', $tempo);
								$year = date('Y', $tempo);

								switch ($month) {
									case '01':$month='Janeiro';break;
									case '02':$month='Fevereiro';break;
									case '03':$month='Março';break;
									case '04':$month='Abril';break;
									case '05':$month='Maio';break;
									case '06':$month='Junho';break;
									case '07':$month='Julho';break;
									case '08':$month='Agosto';break;
									case '09':$month='Setembro';break;
									case '10':$month='Outubro';break;
									case '11':$month='Novembro';break;
									case '12':$month='Dezembro';break;
									default:break;
								}
								$DataFimEvento=$day." de ".$month." de ".$year;

								$volunvaga=mysqli_query($conn,"select * from tblvolevento where IdEvento=".$targetevent);
								$numvol=0;
								$inf=array();
								while ($entrance=mysqli_fetch_array($volunvaga)) {

									$inf[$numvol]=$entrance[0];
									$numvol++;
								}
								$tasm=count($inf);
								$tasm=$NumVagas_Ev-$tasm;

								if($Reconhecido==0){
									$verified=null;
								}else{
									$verified="<span title='Evento Verificado' style='color:#1E90FF;'><i class='fa fa-check-circle'></i></span>";
								}
					?>
					<div class="course_container">
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
						<div class="course_title"><?php echo $Id_Ev."-".$Nome_ev." ".$verified; ?></div>
						<div class="course_info d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">

							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Organização criadora:</div>
								<div class="course_info_text"><a href='./course.php?abrir_org=<?php echo $NomeOrganização_Ev; ?>'><?php echo $NomeOrganização_Ev; //echo implode(", ",$for); ?></a></div>
							</div>
							<?php
							$rat=0;
							$media=0;
							$stars5=0;
							$stars4=0;
							$stars3=0;
							$stars2=0;
							$stars1=0;

							$starsbd=mysqli_query($conn,"select Id from tbleventorating where IdEvento='".$Id_Ev."'");

								$turn=0;
								$form=array();
								while ($ent=mysqli_fetch_array($starsbd)) {

									$form[$turn]=$ent[0];
									$turn++;
								}
								$tambd=count($form);
								if(!empty($tambd)){
								for($i=0;$i<$tambd;$i++){
									$searchbd=mysqli_query($conn,"select Rating from tbleventorating where Id='".$form[$i]."'");
									$convertbd=mysqli_fetch_array($searchbd);
									if($convertbd[0]==5){
										$stars5=$stars5+5;
									}else if($convertbd[0]==4){
										$stars4=$stars4+4;
									}else if($convertbd[0]==3){
										$stars3=$stars3+3;
									}else if($convertbd[0]==2){
										$stars2=$stars2+2;
									}else if($convertbd[0]==1){
										$stars1=$stars1+1;
									}
								}
								$rat=$turn;
								$media=($stars1+$stars2+$stars3+$stars4+$stars5)/$rat;
							}else{
								$rat=0;
								$media=0;
								$stars5=0;
								$stars4=0;
								$stars3=0;
								$stars2=0;
								$stars1=0;
							}
							?>
							<?php
							if($media<1){
								$prestar="0";
							}else if($media>=1 && $media<2){
								$prestar="1";
							}else if($media>=2 && $media<3){
								$prestar="2";
							}else if($media>=3 && $media<4){
								$prestar="3";
							}else if($media>=4 && $media<5){
								$prestar="4";
							}else if($media==5){
								$prestar="5";
							}
							?>
							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Avaliação:</div>
								<div class="rating_r rating_r_<?php echo $prestar; ?>"><i></i><i></i><i></i><i></i><i></i></div>
							</div>

							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Idioma:</div>
								<div class="course_info_text"><a><?php echo $Idioma_Ev; ?></a></div>
							</div>

						</div>

						<!-- Course Image -->
						<div class="course_image"><img src=<?php echo "Fotos/FotosEvent/".$Foto_ev; ?> style="width:100%;" alt=""></div>

						<!-- Course Tabs -->
						<div class="course_tabs_container">
							<div class="tabs d-flex flex-row align-items-center justify-content-start">
								<div class="tab active">Descrição</div>

								<div class="tab">Observações Evento</div>
							</div>
							<div class="tab_panels">

								<!-- Description -->
								<div class="tab_panel active">
										<div class="tab_panel_title"><?php echo $Nome_ev; ?></div>
									<div class="tab_panel_content">
										<div class="tab_panel_text">
											<p><?php echo $Descricao_Ev; ?></p>
										</div>
										<div class="tab_panel_section">
											<div class="tab_panel_subtitle">Requesitos</div>
											<ul class="tab_panel_bullets">
												<li>Estar registado no H2E.</li>
												<li>Estar disposto a cumprir com a informação dispponibilizada.</li>
												<li>Voluntarios que não compareçam nos eventos a que concorrem serão gravemente prejudicados.</li>

											</ul>
										</div>
										<div class="tab_panel_section">
											<div class="tab_panel_subtitle">Função do Voluntário</div>
											<div class="tab_panel_text">
												<p><?php echo $FuncVol_Ev; ?></p>
											</div>
										</div>
										<div class="tab_panel_faq">
											<div class="tab_panel_title">Sobre</div>

											<!-- Accordions -->
											<div class="accordions">

												<div class="elements_accordions">

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center"><div>Qual é o tipo de Compromisso?</div></div>
														<div class="accordion_panel">
															<p>Neste evento o compromisso é <?php echo $Compromisso_Ev; ?></p>
														</div>
													</div>

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center active"><div>Qual o Grupo Alvo?</div></div>
														<div class="accordion_panel">
															<p>Este evento foca a sua atenção para o público <?php echo $GrupoAlvo_Ev; ?></p>
														</div>
													</div>

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center"><div>O evento é confiável</div></div>
														<div class="accordion_panel">
															<p>Na Help2Everyone levamos o voluntariado muito a sério, por isso todas os eventos são criados por organizações legítimas e caso recebamos denúncias sobre o evento, o mesmo pode ser eliminado</p>
														</div>
													</div>

													<div class="accordion_container">
														<div class="accordion d-flex flex-row align-items-center"><div>A Organização criadora é confiável?</div></div>
														<div class="accordion_panel">
															<p>Todas as organizações presentes na Help2Everyone são confiáveis e verificadas pessoalmente pelos nossos técnicos, para garantir que não haja enganos, qualquer organização que crie um evento letigioso será severamente punida.</p>
														</div>
													</div>

												</div>

											</div>
										</div>
									</div>
								</div>



								<!-- Reviews -->
								<div class="tab_panel tab_panel_3" id="avaliar">
									<div class="tab_panel_title">Avaliações</div>
									<?php
									$rat=0;
									$media=0;
									$stars5=0;
									$stars4=0;
									$stars3=0;
									$stars2=0;
									$stars1=0;

									$starsbd=mysqli_query($conn,"select Id from tbleventorating where IdEvento='".$Id_Ev."'");

										$turn=0;
										$form=array();
										while ($ent=mysqli_fetch_array($starsbd)) {

											$form[$turn]=$ent[0];
											$turn++;
										}
										$tambd=count($form);
										if(!empty($tambd)){
										for($i=0;$i<$tambd;$i++){
											$searchbd=mysqli_query($conn,"select Rating from tbleventorating where Id='".$form[$i]."'");
											$convertbd=mysqli_fetch_array($searchbd);
											if($convertbd[0]==5){
												$stars5=$stars5+5;
											}else if($convertbd[0]==4){
												$stars4=$stars4+4;
											}else if($convertbd[0]==3){
												$stars3=$stars3+3;
											}else if($convertbd[0]==2){
												$stars2=$stars2+2;
											}else if($convertbd[0]==1){
												$stars1=$stars1+1;
											}
										}
										$rat=$turn;
										$media=($stars1+$stars2+$stars3+$stars4+$stars5)/$rat;
									}else{
										$rat=0;
										$media=0;
										$stars5=0;
										$stars4=0;
										$stars3=0;
										$stars2=0;
										$stars1=0;
									}
									?>
									<!-- Rating -->
									<div class="review_rating_container">
										<div class="review_rating">
											<div class="review_rating_num"><?php echo round($media, 1); ?></div>
											<div class="review_rating_stars">
												<?php
												if($media<1){
													$prestar="0";
												}else if($media>=1 && $media<2){
													$prestar="1";
												}else if($media>=2 && $media<3){
													$prestar="2";
												}else if($media>=3 && $media<4){
													$prestar="3";
												}else if($media>=4 && $media<5){
													$prestar="4";
												}else if($media==5){
													$prestar="5";
												}
												?>
												<div class='rating_r rating_r_<?php echo $prestar;?>'><i></i><i></i><i></i><i></i><i></i></div>
											</div>
											<div class="review_rating_text">(<?php echo $rat; ?> avaliações)</div>
										</div>
										<div class="review_rating_bars">
											<ul>
												<?php
												if($rat!=0){
												$show5=($stars5/5)/$rat*100;
												$show4=($stars4/4)/$rat*100;
												$show3=($stars3/3)/$rat*100;
												$show2=($stars2/2)/$rat*100;
												$show1=($stars1/1)/$rat*100;
											}else{
												$show5=0;
												$show4=0;
												$show3=0;
												$show2=0;
												$show1=0;
											}
												?>
												<li><span>5 Estrelas</span><div class="review_rating_bar" style="max-width:80%;"><div style="width:<?php echo $show5; ?>%;"></div></div></li>
												<li><span>4 Estrelas</span><div class="review_rating_bar" style="max-width:80%;"><div style="width:<?php echo $show4; ?>%;"></div></div></li>
												<li><span>3 Estrelas</span><div class="review_rating_bar" style="max-width:80%;"><div style="width:<?php echo $show3; ?>%;"></div></div></li>
												<li><span>2 Estrelas</span><div class="review_rating_bar" style="max-width:80%;"><div style="width:<?php echo $show2; ?>%;"></div></div></li>
												<li><span>1 Estrelas</span><div class="review_rating_bar" style="max-width:80%;"><div style="width:<?php echo $show1; ?>%;"></div></div></li>
											</ul>
										</div>
									</div>

									<?php
									$iniciar=0;
									if($logtype=='Organizacao'){
										$iniciar=0;
									}else if($logtype=='Voluntario'){
										$verifiq=mysqli_query($conn,"select * from tbleventorating where IdVoluntario='".$identidade."'&& IdEvento='".$Id_Ev."'");
										$verifiq2=mysqli_fetch_array($verifiq);
										if($verifiq2[0]==null){
											$iniciar=1;
										}else{
											$iniciar=0;
										}
									}else{
											$iniciar=0;
									}?>

									<?php
									if($iniciar==1){
									echo "
									<div class='tab_panel_title'>Avaliar:</div>
									<div class='row' style='padding-top:15px;'>
											<a href='./course.php?rating=5' class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
										</div>
										<div class='row'style='padding-top:5px;'>
											<a href='./course.php?rating=4' class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
										</div>
										<div class='row' style='padding-top:5px;''>
											<a href='./course.php?rating=3' class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
										</div>
										<div class='row' style='padding-top:5px;''>
											<a href='./course.php?rating=2' class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
										</div>
										<div class='row' style='padding-top:5px;''>
											<a href='./course.php?rating=1' class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;''><i class='fa fa-check-square-o'></i></a>
											<i class='fa fa-star fa-2x' style='color:gold;padding-left:5px;'></i>
										</div>
										";
									}
										?>

									<!-- Comments -->
									<div class="comments_container">
										<ul class="comments_list">
											<li>
												<?php
													$selectcom=mysqli_query($conn,"select Id from tbleventocomentario where IdEvento='".$targetevent."'");

														$turn=0;
														$form=array();
														while ($ent=mysqli_fetch_array($selectcom)) {

															$form[$turn]=$ent[0];
															$turn++;
														}
														$tambd=count($form);
														if(!empty($tambd)){
														for($i=0;$i<$tambd;$i++){
															$searchcom=mysqli_query($conn,"select * from tbleventocomentario where Id='".$form[$i]."'");
															$convertcom=mysqli_fetch_array($searchcom);
															$IdVol_com=htmlspecialchars($convertcom['IdVoluntario']);
															$Desc_com=htmlspecialchars($convertcom['Descricao']);
															$DataHora_com=htmlspecialchars($convertcom['DataHora']);

															$searchvol=mysqli_query($conn,"select * from tblvoluntario where Id='".$IdVol_com."'");
															$convertvolcom=mysqli_fetch_array($searchvol);
															$User_com=htmlspecialchars($convertvolcom['Utilizador']);
															$Nome_com=htmlspecialchars($convertvolcom['Nome']);
															$Apelido_com=htmlspecialchars($convertvolcom['Apelido']);
															$Foto_com=htmlspecialchars($convertvolcom['Foto']);
															$Pic_com="./Fotos/FotosVol/".$Foto_com;

															date_default_timezone_set('Europe/Lisbon');
															$data3 = date('Y-m-d H:i');

															$date  = new DateTime($DataHora_com);
															$date2 = new DateTime($data3);

															$diference=($date2->diff($date));
															$diferenca=($date2->diff($date));
															$diff=$diference->format('%H Horas');
															$diff2=$diferenca->format('%a dias');

															if($diff2<1){
																$difinal=$diff;
															}else{
																$difinal=$diff2;
															}
															$naogostar=null;
															$pesq=mysqli_query($conn,"select * from tblgostocomentario where IdComentario=".$form[$i]);
															$recpesq=mysqli_fetch_array($pesq);
															$numrows=mysqli_num_rows($pesq);

															$pesqs=mysqli_query($conn,"select * from tblgostocomentario where IdComentario='".$form[$i]."' && IdVoluntario='".$identidade."'");
															$recpesqs=mysqli_fetch_array($pesqs);
															$IdVol_gosto=htmlspecialchars($recpesqs['IdVoluntario']);

															if($IdVol_gosto==$identidade && $logtype=="Voluntario"){
																$naogostar="style='color:red;'";
															}else if($IdVol_gosto!=$identidade && $logtype=="Voluntario"){
																$naogostar="title='gosta do comentário' href='./course.php?gostarla=".$form[$i]."'";
															}else{
																$naogostar=null;
															}
													echo "
													<div class='comment_item d-flex flex-row align-items-start jutify-content-start'>
														<div class='comment_image'><div><img src='".$Pic_com."' alt=''></div></div>
														<div class='comment_content'>
															<div class='comment_title_container d-flex flex-row align-items-center justify-content-start'>
																<div class='comment_author'><a href='./course.php?abrir_vol=".$User_com."'>".$User_com."</a></div>
																<div class='comment_rating'>".$Nome_com." ".$Apelido_com."</div>
																<div class='comment_time ml-auto'>Há ".$difinal."</div>
															</div>
															<div class='comment_text'>
																<p>".$Desc_com."</p>
															</div>
															<div class='comment_extras d-flex flex-row align-items-center justify-content-start'>
																<div class='comment_extra comment_likes'><a ".$naogostar."><i class='fa fa-heart' aria-hidden='true'></i><span>".$numrows."</span></a></div>
															</div>
														</div>
													</div>";

													$selectorg=mysqli_query($conn,"select Id from tblorgcomentario where IdComentario='".$form[$i]."'");

														$vol=0;
														$dado=array();
														while ($er=mysqli_fetch_array($selectorg)) {

															$dado[$vol]=$er[0];
															$vol++;
														}
														$tamsel=count($dado);

														if(!empty($tamsel)){
														for($v=0;$v<$tamsel;$v++){
															$scom=mysqli_query($conn,"select * from tblorgcomentario where Id='".$dado[$v]."'");
															$ccom=mysqli_fetch_array($scom);
															$IdOrg_com=htmlspecialchars($ccom['IdOrganizacao']);
															$DescOrg_com=htmlspecialchars($ccom['Descricao']);
															$DataHoraOrg_com=htmlspecialchars($ccom['DataHora']);

															$sorg=mysqli_query($conn,"select * from tblorganizacao where Id='".$IdOrg_com."'");
															$corgcom=mysqli_fetch_array($sorg);
															$NomeOrg_com=htmlspecialchars($corgcom['Nome']);
															$EmailOrg_com=htmlspecialchars($corgcom['Email']);
															$FotoOrg_com=htmlspecialchars($corgcom['Foto']);
															$PicOrg_com="./Fotos/FotosOrg/".$FotoOrg_com;

															date_default_timezone_set('Europe/Lisbon');
															$data4 = date('Y-m-d H:i');

															$date1  = new DateTime($DataHoraOrg_com);
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

															$naogostar1=null;
															$pesq1=mysqli_query($conn,"select * from tblgostoorgcomentario where IdOrgComentario='".$dado[$v]."'");
															$recpesq1=mysqli_fetch_array($pesq1);
															$numrows1=mysqli_num_rows($pesq1);
															$IdVol_gosto1=htmlspecialchars($recpesq1['IdVoluntario']);

															if($IdVol_gosto1==$identidade && $logtype=="Voluntario"){
																$naogostar1="title='Já gostaste do comentário!' style='color:red;'";
															}else if($IdVol_gosto1!=$identidade && $logtype=="Voluntario"){
																$naogostar1="title='gostar do comentário' href='./course.php?gostaracola=".$dado[$v]."'";
															}else{
																$naogostar1=null;
															}
													echo "
													<ul>
														<li>
															<div class='comment_item d-flex flex-row align-items-start jutify-content-start'>
																<div class='comment_image'><div><img src='".$PicOrg_com."' alt=''></div></div>
																<div class='comment_content'>
																	<div class='comment_title_container d-flex flex-row align-items-center justify-content-start'>
																		<div class='comment_author'><a href='./course.php?abrir_org=".$NomeOrg_com."'>".$NomeOrg_com."</a></div>
																		<div class='comment_rating'>".$EmailOrg_com."</div>
																		<div class='comment_time ml-auto'>Há ".$difinals."</div>
																	</div>
																	<div class='comment_text'>
																		<p>".$DescOrg_com."</p>
																	</div>
																	<div class='comment_extras d-flex flex-row align-items-center justify-content-start'>
																		<div class='comment_extra comment_likes'><a ".$naogostar1."><i class='fa fa-heart' aria-hidden='true'></i><span>".$numrows1."</span></a></div>
																	</div>
																</div>
															</div>
														</li>
													</ul>";

												}
											}
										}
											}else{
												echo "
												<div class='comment_item d-flex flex-row align-items-start jutify-content-start'>
													<div class='comment_image'><div><img src='' alt=''></div></div>
													<div class='comment_content'>
														<div class='comment_title_container d-flex flex-row align-items-center justify-content-start'>
														</div>
														<div class='comment_text'>
															<p>Sem Comentários registados.</p>
														</div>
														<div class='comment_extras d-flex flex-row align-items-center justify-content-start'>
														</div>
													</div>
												</div>
											";
											}
												?>
										</ul>
										<div class="add_comment_container">
											<div class="add_comment_title" style="padding-bottom:15px;">Comenta tu também</div>
											<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
												<div class="form-group">
													<div class="row">
																<?php
																$btn=null;
																if($logtype=='Organizacao'){
																if($logaprovado!=0){
																$selectcom=mysqli_query($conn,"select Id from tbleventocomentario where IdEvento='".$targetevent."'");

																	$turn=0;
																	$form=array();
																	while ($ent=mysqli_fetch_array($selectcom)) {

																		$form[$turn]=$ent[0];
																		$turn++;
																	}
																	$tamsel=count($form);
																	if(!empty($tamsel)){
																		echo "<div class='col-md-3'><select class='custom-select' name='resposta' id='inputGroupSelect03' required>";
																	for($v=0;$v<$tamsel;$v++){
																		$searchcom=mysqli_query($conn,"select * from tbleventocomentario where Id='".$form[$v]."'");
																		$convertcom=mysqli_fetch_array($searchcom);
																		$IDValor_com=htmlspecialchars($convertcom['Id']);
																		$IdVol_com=htmlspecialchars($convertcom['IdVoluntario']);
																		$Desc_com=htmlspecialchars($convertcom['Descricao']);
																		$DataHora_com=htmlspecialchars($convertcom['DataHora']);

																		$searchvol=mysqli_query($conn,"select * from tblvoluntario where Id='".$IdVol_com."'");
																		$convertvolcom=mysqli_fetch_array($searchvol);
																		$User_com=htmlspecialchars($convertvolcom['Utilizador']);
																		$Nome_com=htmlspecialchars($convertvolcom['Nome']);
																		$Foto_com=htmlspecialchars($convertvolcom['Foto']);
																		$Pic_com="./Fotos/FotosVol/".$Foto_com;

																		date_default_timezone_set('Europe/Lisbon');
																		$data4 = date('Y-m-d H:i');

																		$date1  = new DateTime($DataHora_com);
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

																echo "<option value='".$IDValor_com."'>".$User_com." - ".$difinals."</option>";

															}
															echo "</select></div>";
															$btn="Title='Comentar ao Voluntario'";
														}else{
															$btn="disabled title='Sem Comentários de Voluntários'";
														}
													}else{
														$btn="disabled title='Organização não aprovada'";
													}
													}
																?>
													<div class="col-md-10" style="padding-top:15px;">
														<textarea style="resize: none;" type="text" class="form-control" name="descricao" placeholder="Insira o seu comentário" maxlength="500" required></textarea>
													</div>
													<div class="col-md-2" style="padding-top:25px;">
														<button class="form-control btn btn-primary" <?php echo $btn; ?> name="coment" type="submit"><i class="fa fa-share-square-o" style="color:white;"></i></button>
													</div>
												</div>
												</div>
											</form>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<!-- Course Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">

						<!-- Feature -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Informações do Evento</div>
							<div class="sidebar_feature">
								<div class="course_price"><i class='fa fa-money'></i> <?php echo $Helps_Ev;?> Helps</div>
								<?php
								date_default_timezone_set('Europe/Lisbon');
								$dh = date('Y-m-d');

								$comp1= new DateTime($DataFim_Ev);
								$comp2= new DateTime($dh);
								$comp3= new DateTime($DataInicio_Ev);

								if($comp3>$comp2 && $comp1>$comp2){
									$est="<span class='badge badge-danger' title='Inscrições para o evento abertas' style='color:white;background:green;'><i class='fa fa-check'></i> Ativo</span>";
									$estado=1;
								}else if($comp3<=$comp2 && $comp1>=$comp2){
									$est="<span class='badge badge-info' title='Inscrições fechadas' ><i class='fa fa-clock-o'></i> Em execução</span>";
									$estado=3;
								}else if($comp1<$comp2 && $comp3<$comp2){
									$est="<span class='badge badge-success' style='color:white;background:red;' title='Evento Inativo' ><i class='fa fa-times'></i> Inativo</span>";
									$estado=2;
								}
								?>
								<!-- Features -->
								<div class="feature_list">

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Estado: </span></div>
										<div class="feature_text ml-auto"><?php echo $est; ?></div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Duração: </span></div>
										<div class="feature_text ml-auto"><?php echo $Duracao_Ev; ?> H</div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-calendar" aria-hidden="true"></i><span>Data de Início:</span></div>
										<div class="feature_text ml-auto"><?php echo $DataInicioEvento; ?></div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-calendar" aria-hidden="true"></i><span>Data de Fim:</span></div>
										<div class="feature_text ml-auto"><?php echo $DataFimEvento; ?></div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-users" aria-hidden="true"></i><span>Total de Vagas</span></div>
										<div class="feature_text ml-auto"><?php echo $NumVagas_Ev; ?></div>
									</div>
									<?php
									if($tasm>=5){
										$cor="color:green;";
									}else if($tasm<5 && $tasm>=1){
										$cor="color:#FF8C00;";
									}else{
										$cor="color:red;";
									}
									?>
									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" style=<?php echo $cor; ?>><i class="fa fa-users" aria-hidden="true"></i><span>Vagas Disponíveis:</span></div>
										<div class="feature_text ml-auto" style=<?php echo $cor; ?>><?php echo $tasm; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-marker" aria-hidden="true"></i><span>Pais:</span></div>
										<div class="feature_text ml-auto" ><?php echo $Pais_ev; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-marker" aria-hidden="true"></i><span>Código Postal:</span></div>
										<div class="feature_text ml-auto" ><?php echo $CodPostal_Ev; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-o" aria-hidden="true"></i><span>Distrito:</span></div>
										<div class="feature_text ml-auto" ><?php echo $Distrito_Ev; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-signs" aria-hidden="true"></i><span>Concelho:</span></div>
										<div class="feature_text ml-auto" ><?php echo $Concelho_Ev; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-signs" aria-hidden="true"></i><span>Freguesia:</span></div>
										<div class="feature_text ml-auto" ><?php echo $Freguesia_Ev; ?></div>
									</div>
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title" ><i class="fa fa-map-signs" aria-hidden="true"></i><span>Morada:</span></div>
										<div class="feature_text ml-auto" ><?php echo $Morada_Ev; ?></div>
									</div>
									<div class="row" style="padding-bottom:20px;">
										<div class="col-md-4">
										</div>
										<div class="col-md-6">
											<form action="./course.php" method="GET">
											<?php
											$name="concorrer";
											$titulo="Aderir do Evento";
											if($logtype=='Organizacao'){
												$aderir="disabled title='Precisa de ser um voluntário para apoiar um evento'";
											}else if($logtype=='Voluntario' && $tasm>=1){
												$verifiq=mysqli_query($conn,"select * from tblvolevento where IdVoluntario='".$identidade."'&& IdEvento='".$Id_Ev."'");
												$verifiq2=mysqli_fetch_array($verifiq);
												$query=mysqli_query($conn,"select * from tblvoluntario where Id='".$identidade."'");
												$resquery=mysqli_fetch_array($query);
												$D=htmlspecialchars($resquery['Distrito']);

												if($verifiq2[0]==null && $D!=null){
													if($estado==2){
														$aderir="disabled title='Evento Inativo'";
													}else if($estado==3){
														$aderir="disabled title='Inscrições fechadas'";
													}else{
														$aderir="title='Concorrer ao evento em causa'";
													}
												}else if($D!=null){
													if($estado==2){
														$aderir="disabled title='Já aderiu ao evento!'";
													}else if($estado==3){
														$aderir="disabled title='Já aderiu ao evento!'";
													}else{
														$aderir="title='Já aderiu ao evento!'";
														$name="GetOut";
														$titulo="Sair do Evento";
													}
												}else{
													$aderir="disabled title='Atualize os seus dados primeiro!'";
												}
											}else{
												$verifiq=mysqli_query($conn,"select * from tblvolevento where IdVoluntario='".$identidade."'&& IdEvento='".$Id_Ev."'");
												$verifiq2=mysqli_fetch_array($verifiq);
													if($verifiq2[0]!=null){
														$aderir="disabled title='Já aderiu ao evento!'";
														if($estado==2){
															$aderir="disabled title='Já aderiu ao evento!'";
														}else if($estado==3){
															$aderir="disabled title='Já aderiu ao evento!'";
														}else{
															$aderir="title='Já aderiu ao evento!'";
															$name="GetOut";
															$titulo="Sair do Evento";
														}
													}else{
														$aderir="disabled title='Sem vagas disponíveis'";
													}
											}
											?>
											<button class="btn btn-primary" name=<?php echo $name ?> <?php echo $aderir; ?>><?php echo $titulo ?></button>
										</form>
										</div>
									<div class="col-md-2">
									</div>
									<div>
								</div>
							</div>
						</div>


						<!-- Feature -->
						<div class='sidebar_section'>
							<div class='sidebar_section_title'>Organizações</div>

						<?php
						$comand=mysqli_query($conn,"select IdOrganizacao from tblorgevento where IdEvento=".$targetevent);
						$turn=0;
						$form=array();
						while ($ar=mysqli_fetch_array($comand)) {

							$form[$turn]=$ar[0];
							$turn++;
						}
						$tam=count($form);
						$turns=0;
						$for=array();
						for($z=0;$z<$tam;$z++){
								$empres=mysqli_query($conn,"select * from tblorganizacao where Id=".$form[$z]);
								$are=mysqli_fetch_array($empres);
								$Foto_org=htmlspecialchars($are['Foto']);
								$Nome_org=htmlspecialchars($are['Nome']);
								$email_org=htmlspecialchars($are['Email']);
								$D=htmlspecialchars($are['Distrito']);

								if($D==null){
									$verif="<span title='Organização com informações desatualizadas' style='color:#FF8C00;'><i class='fa fa-times-circle'></i></span>";
								}else{
									$verif=null;
								}

						echo "
							<div class='sidebar_teacher'>
								<div class='teacher_title_container d-flex flex-row align-items-center justify-content-start'>
									<div class='teacher_image'><img src='./Fotos/FotosOrg/".$Foto_org."' alt=''></div>
									<div class='teacher_title'>
										<div class='teacher_name'><a href='./course.php?abrir_org=".$Nome_org."'>".$Nome_org." ".$verif."</a></div>
										<div class='teacher_position'>".$email_org."</div>
									</div>
								</div>
							</div>
						</div>
						";
					}
						?>

						<!-- Latest Course -->
						<div class="sidebar_section" style="padding-top:20px;">
							<div class="sidebar_section_title">Últimos Eventos</div>
							<div class="sidebar_latest">

								<?php
								$cmd=mysqli_query($conn,"select Id from tblevento where Inativo=0 order by Id Desc");
								$voltas=0;
								$info=array();
								while ($seg=mysqli_fetch_array($cmd)) {

									$info[$voltas]=$seg[0];
									$voltas++;
								}
								$tas=count($info);
								if($tas>=3){
									$tas=3;
								}
								for($i=0;$i<$tas;$i++){
									$result=mysqli_query($conn,"select * from tblevento where Id=".$info[$i]);
										$entrada=mysqli_fetch_array($result);
										$identity=htmlspecialchars($entrada['Id']);
										$nome=htmlspecialchars($entrada['Nome']);
										$Foto=htmlspecialchars($entrada['FotoLocal']);
										$Desc=htmlspecialchars($entrada['Descricao']);
										$BreveDesc=htmlspecialchars($entrada['BreveDesc']);
										$Vagas=htmlspecialchars($entrada['NumVagas']);
										$Dur=htmlspecialchars($entrada['Duracao']);
										$Help=htmlspecialchars($entrada['Quant_Helps']);
										$Pic="./Fotos/FotosEvent/".$Foto;

										echo	"<div class='latest d-flex flex-row align-items-start justify-content-start'>
											<div class='latest_image'><div><img src='".$Pic."' alt=''></div></div>
											<div class='latest_content'>
											<div class='latest_title'><a href='course.php?abrir=".$identity."'>".$nome."</a></div>
											<div class='latest_price'>".$Help." Helps</div>
											</div>
											</div>
											";
								}
								?>

								<!-- Latest Course
								<div class="latest d-flex flex-row align-items-start justify-content-start">
									<div class="latest_image"><div><img src="images/latest_2.jpg" alt=""></div></div>
									<div class="latest_content">
										<div class="latest_title"><a href="course.php">Photography for Beginners Masterclass</a></div>
										<div class="latest_price">$170</div>
									</div>
								</div>
 								-->
								</div>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->

	<footer class="footer">
		<div class="footer_background" style="background-image:url(images/footer_background.png)"></div>
		<div class="container">
			<div class="row footer_row">
				<div class="col">
					<div class="footer_content">
						<div class="row">

							<div class="col-lg-3 footer_col">

								<!-- Footer About -->
								<div class="footer_section footer_about">
									<div class="footer_logo_container">
										<a href="#">
											<div class="footer_logo_text">Help2<span>Everyone</span></div>
										</a>
									</div>
									<div class="footer_about_text">
										<p>Acompanha novidades através das Redes Sociais</p>
									</div>
									<div class="footer_social">
										<ul>
											<li><a target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a target="_blank" href="https://pt.linkedin.com/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
											<li><a target="_blank" href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
											<li><a target="_blank" href="https://twitter.com/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>

							</div>

							<div class="col-lg-3 footer_col">

								<!-- Footer Contact -->
								<div class="footer_section footer_contact">
									<div class="footer_title">Contacta-nos</div>
									<div class="footer_contact_info">
										<ul>
											<li>Morada: Rua Padre José Rodrigues de Barros, Carvalhais, São Pedro do Sul</li>
											<li>Telefone: 351-232465159</li>
											<li>Email: help2everyone.pap@gmail.com</li>
										</ul>
									</div>
								</div>

							</div>

							<div class="col-lg-3 footer_col">

								<!-- Footer links -->
								<div class="footer_section footer_links">
									<div class="footer_title">Navegação</div>
									<div class="footer_links_container">
										<ul>
											<li><a href="index.php">Home</a></li>
											<li><a href="about.php">Sobre</a></li>
											<li><a href="contact.php">Contato</a></li>
											<li><a href="courses.php">Eventos</a></li>
											<li><a href="blog.php">Notícias</a></li>
											<li><a href="./../H2E - Admin/login.php">Admin</a></li>
											<li><a href="listagem.php">Voluntários</a></li>
											<li><a href="listagemorg.php">Organizações</a></li>
										</ul>
									</div>
								</div>

							</div>

							<div class="col-lg-3 footer_col clearfix">

								<!-- Footer links -->
								<div class="footer_section footer_mobile">
									<div class="footer_title">Em breve...</div>
									<div class="footer_mobile_content">
										<div class="footer_image"><a><img src="images/mobile_1.png" alt=""></a></div>
										<div class="footer_image"><a><img src="images/mobile_2.png" alt=""></a></div>
									</div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>

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
							<a class="btn btn-danger" href="./fecharsessao.php">Logout  <i class="fa fa-sign-out"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="row copyright_row">
				<div class="col">
					<div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
						<div class="cr_text"><!-- Link back to Colorlib can not be removed. Template is licensed under CC BY 3.0. -->
	Copyright &copy;<script>document.write(new Date().getFullYear());</script> Help2Everyone - Todos direitos reservados
	<!-- Link back to Colorlib can not be removed. Template is licensed under CC BY 3.0. --></div>
						<div class="ml-lg-auto cr_links">
							<ul class="cr_list">
								<!--<li><a href="#">Copyright notification</a></li>
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privacy Policy</a></li>-->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/course.js"></script>
</body>
</html>
<?php
include('./fechligacao.ini');
?>
