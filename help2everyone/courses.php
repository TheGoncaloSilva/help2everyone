<?php
	include('./inicligacao.ini');
	session_start();
		if((isset ($_SESSION['user']) == true)){
			$logado=$_SESSION['user'];
			$logtype='Voluntario';
			$result=mysqli_query($conn,"select Foto from tblvoluntario where Email='".$logado."'");
			$logf=mysqli_fetch_array($result);
			$logfoto=htmlspecialchars($logf['Foto']);
			$logfotof="./Fotos/FotosVol/".$logfoto;
			$login=true;
		}else if((isset ($_SESSION['nome']) == true)){
			$logado=$_SESSION['nome'];
			$logtype='Organizacao';
			$result=mysqli_query($conn,"select Foto from tblorganizacao where Nome='".$logado."'");
			$logf=mysqli_fetch_array($result);
			$logfoto=htmlspecialchars($logf['Foto']);
			$logfotof="./Fotos/FotosOrg/".$logfoto;
			$login=true;
		}else{
			$login=false;
			$logtype='NaoExiste';
			$logfotof="./Fotos/FotosVol/userimg.png";
			session_destroy();
			unset($_SESSION['user']);
			unset($_SESSION['nome']);
		}
		$logfolder=null;
		if($logtype=='Organizacao'){
			$logfolder="listagemorg.php";
		}else{
			$logfolder="listagem.php";
		}
		$filtareaatuacao=null;
		$filtronome=null;
		$filtselnom=null;
		$ordem=1;

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir']))
	{
		$_SESSION['targetevent']=$_GET['abrir'];
		header('Location: ./course.php');
	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['order']))
{
	$ordem=$_GET['order'];
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['limparsel']))
{
	$filtselnom=null;
	$filtronome=null;
	$filtareaatuacao=null;
	$ordem=1;
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['filt']))
{
	if (!empty($_POST['filtnome'])) {
		$filtronome=htmlspecialchars($_POST['filtnome']);
	}
	if (!empty($_POST['filt_select'])) {
		$filtroselect=htmlspecialchars($_POST['filt_select']);
	}
	if($filtroselect==1){
			$filtselnom="Nome like '%".$filtronome."%' &&";
	}else if($filtroselect==2){
			$filtselnom="Id like '%".$filtronome."%' &&";
	}else if($filtroselect==3){
			$filtselnom="Pais like '%".$filtronome."%' &&";
	}else if($filtroselect==4){
			$filtselnom="Distrito like '%".$filtronome."%' &&";
	}else if($filtroselect==5){
			$filtselnom="Concelho like '%".$filtronome."%' &&";
	}else if($filtroselect==6){
			$filtselnom="Freguesia like '%".$filtronome."%' &&";
	}else if($filtroselect==7){
			$filtselnom="NumVagas like '%".$filtronome."%' &&";
	}else if($filtroselect==8){
			$filtselnom="Duracao like '%".$filtronome."%' &&";
	}else if($filtroselect==9){
			$filtselnom="Idioma like '%".$filtronome."%' &&";
	}else if($filtroselect==10){
			$filtselnom="Compromisso like '%".$filtronome."%' &&";
	}else if($filtroselect==11){
			$filtselnom="GrupoAlvo like '%".$filtronome."%' &&";
	}
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['butcerto']))
{
	if($logtype=="Organizacao"){
		$selectvalues=mysqli_query($conn,"select * from tblorganizacao where Nome='".$logado."'");
		$convertvalues=mysqli_fetch_array($selectvalues);
		$pais_vol=htmlspecialchars($convertvalues['Pais']);
		$Distrito_vol=htmlspecialchars($convertvalues['Distrito']);
		$Concelho_vol=htmlspecialchars($convertvalues['Concelho']);
	}else{
		$selectvalues=mysqli_query($conn,"select * from tblvoluntario where Email='".$logado."'");
		$convertvalues=mysqli_fetch_array($selectvalues);
		$pais_vol=htmlspecialchars($convertvalues['Pais']);
		$Distrito_vol=htmlspecialchars($convertvalues['Distrito']);
		$Concelho_vol=htmlspecialchars($convertvalues['Concelho']);
	}
	$filtselnom="Pais='".$pais_vol."' && Distrito='".$Distrito_vol."' && Concelho='".$Concelho_vol."' &&";
}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but1']))
{
	$filtareaatuacao="Ambiente";
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but2']))
{
	$filtareaatuacao="Cidadania e Direitos";
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but3']))
{
	$filtareaatuacao="Cultura e Artes";
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but4']))
{
	$filtareaatuacao='Desporto e Lazer';
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but5']))
{
	$filtareaatuacao='Novas Tecnologias';
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but6']))
{
	$filtareaatuacao='Saúde';
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but7']))
{
	$filtareaatuacao='Solidariedade Social';
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['but8']))
{
	$filtareaatuacao='Educação';
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
<title>Help2Everyone</title>
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
<link rel="stylesheet" type="text/css" href="styles/courses.css">
<link rel="stylesheet" type="text/css" href="styles/courses_responsive.css">
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
                    <img <?php  if($login==false){echo "title='Precisa de iniciar sessão primeiro'";} ?> src=<?php echo "$logfotof"; ?> class="userimage">
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
			<form action="./courses.php" method="POST">
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

	<!-- Home -->

	<div class="home">
		<div class="breadcrumbs_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li>Eventos</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Courses -->

	<div class="courses">
		<div class="container">
			<div class="row">

				<!-- Courses Main Content-->
				<!--<div class="col-lg-8">
					<div class="courses_search_container">
						<form action="./courses.php" method="POST" id="courses_search_form" class="courses_search_form d-flex flex-row align-items-center justify-content-start">
							<input type="search" class="courses_search_input" name="filtnome" placeholder="Procurar..." required>
							<select id="courses_search_select" name="filt_select" class="courses_search_select courses_search_input">
								<option value="1">Nome</option>
								<option value="2">Id</option>
								<option value="3">Pais</option>
								<option value="4">Distrito</option>
								<option value="5">Concelho</option>
								<option value="6">Freguesia</option>
								<option value="7">Nº de Vagas</option>
								<option value="8">Duracao</option>
								<option value="9">Idioma</option>
								<option value="10">Compromisso</option>
								<option value="11">Grupo Alvo</option>
							</select>
							<a style="padding-left:10px;" href="./courses.php?limparsel" title="Limpar seleção"><i class="fa fa-refresh fa-2x"></i></a>
							<button action="submit" name="filt" class="courses_search_button ml-auto"><i class="fa fa-search"></i> Procurar</button>
					</div>-->

					<div class="col-lg-8">
						<div class="container" style="background-color:lightgrey;">
							<form action="./courses.php" method="POST" id="courses_search_form" class="form-control" style="background-color:lightgrey;">
								<div class="row text-center" style="background-color:lightgrey;">
								<div class="col-md-4" style="padding-top:5px;padding-bottom:5px;">
									<input type="search" class="form-control" name="filtnome" placeholder="Procurar..." required>
								</div>
								<div class="col-md-4" style="padding-top:5px;padding-bottom:5px;">
									<select id="courses_search_select" name="filt_select" class="form-control">
										<option value="1">Nome</option>
										<option value="2">Id</option>
										<option value="3">Pais</option>
										<option value="4">Distrito</option>
										<option value="5">Concelho</option>
										<option value="6">Freguesia</option>
										<option value="7">Nº de Vagas</option>
										<option value="8">Duracao</option>
										<option value="9">Idioma</option>
										<option value="10">Compromisso</option>
										<option value="11">Grupo Alvo</option>
									</select>
								</div>
								<div class="col-md-1" style="padding-top:5px;padding-bottom:5px;">
									<a style="padding-left:10px;" href="./courses.php?limparsel" title="Limpar seleção"><i class="fa fa-refresh fa-2x"></i></a>
								</div>
								<div class="col-md-3" style="padding-top:5px;padding-bottom:5px;">
									<button action="submit" name="filt" class="btn btn-primary"><i class="fa fa-search"></i> Procurar</button>
								</div>
							</div>
						</div>
					<!--
					<div class="courses_show_container ml-auto clearfix">
						<div class="courses_show_text">Showing <span class="courses_showing">1-6</span> of <span class="courses_total">26</span> results:</div>
						<div class="courses_show_content">
							<span>Show: </span>
							<select id="courses_show_select" class="courses_show_select">
								<option>06</option>
								<option>12</option>
								<option>24</option>
								<option>36</option>
							</select>
						</div>
					</div>-->
					<?php
					if($ordem==1){
						$escolher1="selected";
						$escolher2=null;
					}else{
						$escolher1=null;
						$escolher2="selected";
					}
					?>

					<div class="row" style="padding-top:15px;">
						<div class="col-md-9">
						</div>
						<div class="col-md-3">
							<form>
								<select hidden name='order1' onchange='this.form.submit()'>
								  <option value="3" <?php echo $escolher1; ?>>Descendente</option>
								  <option value="4" <?php echo $escolher2; ?>>Ascendente</option>
								</select>
								<noscript><input type="submit" value="Submit"></noscript>
								</form>
						</div>
					</div>
					<?php
					if($filtselnom!=null or $filtareaatuacao!=null){
						$hidden='hidden';
					}else{
						$hidden=null;
					}
					?>
					<form>
						<select name='order' class="form-control" style="width:150px;" <?php echo $hidden; ?> onchange='this.form.submit()'>
						  <option value="1" <?php echo $escolher1; ?>>Descendente</option>
						  <option value="2" <?php echo $escolher2; ?>>Ascendente</option>
						</select>
						<noscript><input type="submit" value="Submit"></noscript>
					</form>

					<div class="courses_container">
						<form action="./courses.php" method="GET">
						<div class="row courses_row">

							<!-- Course -->
							<?php
							if($ordem==1){
								$ordenar="Desc";
							}else{
								$ordenar="Asc";
							}
							if($filtareaatuacao!=null){
								$cmd=mysqli_query($conn,"select IdEvento from tblareaatucaoevento where Nome='".$filtareaatuacao."'");
								$voltas=0;
								$info=array();
								while ($seg=mysqli_fetch_array($cmd)) {

									$info[$voltas]=$seg[0];
									$voltas++;
								}
								$tas=count($info);

							}else{
								$cmd=mysqli_query($conn,"select Id from tblevento where ".$filtselnom." Inativo=0 order by Id ".$ordenar);
								$voltas=0;
								$info=array();
								while ($seg=mysqli_fetch_array($cmd)) {

									$info[$voltas]=$seg[0];
									$voltas++;
								}
								$tas=count($info);
							}
							if(!empty($tas)){
							for($i=0;$i<$tas;$i++){
								$result=mysqli_query($conn,"select * from tblevento where Inativo=0 && Id=".$info[$i]);
									$entrada=mysqli_fetch_array($result);
									$identity=htmlspecialchars($entrada['Id']);
									if(!empty($identity)){
									$nome=htmlspecialchars($entrada['Nome']);
									$Foto=htmlspecialchars($entrada['FotoLocal']);
									$Desc=htmlspecialchars($entrada['Descricao']);
									$BreveDesc=htmlspecialchars($entrada['BreveDesc']);
									$DataFim_Ev=htmlspecialchars($entrada['DataTermino']);
									$Vagas=htmlspecialchars($entrada['NumVagas']);
									$Dur=htmlspecialchars($entrada['Duracao']);
									$Help=htmlspecialchars($entrada['Quant_Helps']);
									$P=htmlspecialchars($entrada['Pais']);
									$D=htmlspecialchars($entrada['Distrito']);
									$C=htmlspecialchars($entrada['Concelho']);
									$Reconhecido=htmlspecialchars($entrada['Reconhecido']);
									$Pic="./Fotos/FotosEvent/".$Foto;

									$comand=mysqli_query($conn,"select IdOrganizacao from tblorgevento where IdEvento=".$info[$i]);
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
											$empres=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$form[$z]);
											while ($are=mysqli_fetch_array($empres)) {
												$for[$turns]=$are[0];
												$turns++;
											}
										}
									if($Reconhecido==0){
										$verified=null;
									}else{
										$verified="<span title='Evento Verificado' style='color:#1E90FF;'><i class='fa fa-check-circle'></i></span>";
									}

									date_default_timezone_set('Europe/Lisbon');
									$dh = date('Y-m-d');

									$comp1= new DateTime($DataFim_Ev);
									$comp2= new DateTime($dh);

									if($comp1>$comp2){
										$est="<span class='badge badge-danger' style='color:white;background:green;'>Ativo</span>";
									}else{
										$est="<span class='badge badge-success' style='color:white;background:red;'>Inativo</span>";
									}

									echo "
									<div class='col-lg-6 course_col'>
										<div class='course'>
											<div class='course_image'><img style='min-width:100%;' src='".$Pic."' alt=''></div>
											<div class='course_body'>
												<h4>".$est."</h4>
												<h3 class='course_title'><a href='courses.php?abrir=".$identity."'>".$nome." ".$verified."</a></h3>
												<div class='course_teacher'>".implode(", ",$for)/*.$form[0]*/."</div>
												<div class='course_text'>
													<p>".$BreveDesc.".</p>
													<p style='color:black;'>".$P." - ".$D." - ".$C."</p>
												</div>
											</div>
											<div class='course_footer'>
												<div class='course_footer_content d-flex flex-row align-items-center justify-content-start'>
													<div class='course_info'>
														<i class='fa fa-users' aria-hidden='true'></i>
														<span>".$Vagas." Voluntários</span>
													</div>
													<div class='course_info'>
														<i class='fa fa-money' aria-hidden='true'></i>
														<span>".$Help." Helps</span>
													</div>
													<div class='course_price ml-auto'>".$Dur." H</div>
												</div>
											</div>
										</div>
									</div>";
							}
						}
						}else{
							echo "
							<p>Sem Resultados</p>";
						}
							?>
						</div>
						<!--
						<div class="row pagination_row">
							<div class="col">
								<div class="pagination_container d-flex flex-row align-items-center justify-content-start">
									<ul class="pagination_list">
										<li class="active"><a href="#">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
									</ul>
									<div class="courses_show_container ml-auto clearfix">
										<div class="courses_show_text">Showing <span class="courses_showing">1-6</span> of <span class="courses_total">26</span> results:</div>
										<div class="courses_show_content">
											<span>Show: </span>
											<select id="courses_show_select" class="courses_show_select">
												<option>06</option>
												<option>12</option>
												<option>24</option>
												<option>36</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>-->
					</div>
				</form>
				</div>

				<!-- Courses Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">

						<!-- Categories -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Área de Atuação</div>
							<form action="./courses.php" method="GET">
							<div class="sidebar_categories">
								<ul>
									<li><a href="./courses.php?but1">Ambiente</a></li>
									<li><a href="./courses.php?but2">Cidadania e Direitos</a></li>
									<li><a href="./courses.php?but3">Cultura e Artes</a></li>
									<li><a href="./courses.php?but4">Desporto e Lazer</a></li>
									<li><a href="./courses.php?but8">Educação</a></li>
									<li><a href="./courses.php?but5">Novas Tecnologias</a></li>
									<li><a href="./courses.php?but6">Saúde</a></li>
									<li><a href="./courses.php?but7">Solidariedade Social</a></li>
								</ul>
							</div>
							<a class="btn btn-info" href="./courses.php?butcerto">Perto de mim</a>
						</form>
						</div>

						<!-- Latest Course -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Últimos Eventos</div>
							<div class="sidebar_latest">
								<form action="./courses.php" method="GET">
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
											<div class='latest_title'><a href='courses.php?abrir=".$identity."'>".$nome."</a></div>
											<div class='latest_price'>".$Help." Helps</div>
											</div>
											</div>";
								}
								?>
							</form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Newsletter -->

	<div class="newsletter">
		<div class="newsletter_background parallax-window" data-parallax="scroll" data-image-src="images/newsletter.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="newsletter_container d-flex flex-lg-row flex-column align-items-center justify-content-start">
						<div class="newsletter_content text-lg-left text-center">
							<div class="newsletter_title">Regista-te para saberes mais</div>
							<div class="newsletter_subtitle">Para obteres mais pormenores sobre o funcionamento da nossa plataforma.</div>
						</div>
						<div class="newsletter_form_container ml-lg-auto">
							<a style="padding-top:10px;" href="./Login_Vol/index.php" class=" btn newsletter_button">Voluntário</a>
							<a style="padding-top:10px;" href="./Login_org/index.php" class=" btn newsletter_button">Organização</a>
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
<script src="js/courses.js"></script>
</body>
</html>
