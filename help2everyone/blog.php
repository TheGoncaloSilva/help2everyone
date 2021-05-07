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
		unset($_SESSION['user']);
		unset($_SESSION['nome']);
	}
	$logfolder=null;
	if($logtype=='Organizacao'){
		$logfolder="listagemorg.php";
	}else{
		$logfolder="listagem.php";
	}
	$filtrar=null;
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['noticia']))
{
	$_SESSION['targetnoticia']=$_GET['noticia'];
	header('Location: ./blog_single.php');
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria1']))
{
	$filtrar="Where Categoria=1";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria2']))
{
	$filtrar="Where Categoria=2";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria3']))
{
	$filtrar="Where Categoria=3";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria4']))
{
	$filtrar="Where Categoria=4";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria5']))
{
	$filtrar="Where Categoria=5";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['ButCategoria6']))
{
	$filtrar="Where Categoria=6";
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['recarregar']))
{
	$filtrar=null;
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
<link href="plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/blog.css">
<link rel="stylesheet" type="text/css" href="styles/blog_responsive.css">
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
									<li class="nav-item dropdown active">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Sobre
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
											<a class="dropdown-item" href="about.php">Sobre</a>
											<a class="dropdown-item" href="blog.php">Notícias</a>
									</li>
									<li><a href="courses.php">Eventos</a></li>
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
			<form action="./blog.php" method="POST">
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
								<li>Notícias</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Blog -->

	<div class="blog">
		<div class="container">
			<form class="form-control" action="./blog.php" method="POST">
				<h6 style="padding-bottom:15px;">Filtrar Categoria:</h6>
				<button class="btn btn-success" name="ButCategoria1" style="margin-top:5px;"><i class="fa fa-tree"></i> Ambiente</button>
				<button class="btn btn-success" name="ButCategoria2" style="margin-top:5px;"><i class="fa fa-users"></i> Voluntários</button>
				<button class="btn btn-success" name="ButCategoria3" style="margin-top:5px;"><i class="fa fa-building-o"></i> Organizações</button>
				<button class="btn btn-success" name="ButCategoria4" style="margin-top:5px;"><i class="fa fa-book"></i> Eventos</button>
				<button class="btn btn-success" name="ButCategoria5" style="margin-top:5px;"><i class="fa fa-heartbeat"></i>Ajuda Humanitária</button>
				<button class="btn btn-success" name="ButCategoria6" style="margin-top:5px;"><i class="fa fa-plus"></i> Outros</button>
				<button class="btn btn-info" name="recarregar" style="margin-top:5px;"><i class="fa fa-refresh"></i></button>

			</form>
			<div class="row" style="padding-top:15px;">
				<div class="col">
					<div class="blog_post_container">

						<?php
						$query=mysqli_query($conn,"select Id from tblnoticias ".$filtrar." order by Data Desc");
						$voltas=0;
						$info=array();
						while ($res_query=mysqli_fetch_array($query)) {

							$info[$voltas]=$res_query[0];
							$voltas++;
						}
						$tas=count($info);
						if(!empty($tas)){
						for($i=0;$i<$tas;$i++){
							$result=mysqli_query($conn,"select * from tblnoticias where Id=".$info[$i]);
								$entrada=mysqli_fetch_array($result);
								$identity=htmlspecialchars($entrada['Id']);
								$Titulo=htmlspecialchars($entrada['Titulo']);
								$Data=htmlspecialchars($entrada['Data']);
								$BreveDesc=htmlspecialchars($entrada['BreveDesc']);
								$Foto=htmlspecialchars($entrada['Foto']);
								$categoria=htmlspecialchars($entrada['Categoria']);
								$Pic="./Fotos/FotosNoticias/".$Foto;
								$ts1 = strtotime($Data);
								$dia = date('d', $ts1);
								$mes = date('m', $ts1);
								$ano = date('Y', $ts1);
								switch ($mes) {
									case '01':$mes='Janeiro';break;
									case '02':$mes='Fevereiro';break;
									case '03':$mes='Março';break;
									case '04':$mes='Abril';break;
									case '05':$mes='Maio';break;
									case '06':$mes='Junho';break;
									case '07':$mes='Julho';break;
									case '08':$mes='Agosto';break;
									case '09':$mes='Setembro';break;
									case '10':$mes='Outubro';break;
									case '11':$mes='Novembro';break;
									case '12':$mes='Dezembro';break;
									default:break;
								}
								if($categoria==1){
									$cat="Ambiente";
								}else if($categoria==2){
									$cat="Voluntários";
								}else if($categoria==3){
									$cat="Organizações";
								}else if($categoria==4){
									$cat="Eventos";
								}else if($categoria==5){
									$cat="Ajuda Humanitária";
								}else if($categoria==6){
									$cat="Outros";
								}

								$nascimento=$dia." de ".$mes.", ".$ano;
								echo "
								<div class='blog_post trans_200'>
									<div class='blog_post_image'><img src='".$Pic."' alt=''></div>
									<div class='blog_post_body'>
										<div class='blog_post_title'><a href='blog.php?noticia=".$identity."'>".$Titulo."</a></div>
										<div class='blog_post_meta'>
											<ul>
												<li><a>Admin</a></li>
												<li><a>".$nascimento."</a></li>
												<li><a>Categoria: ".$cat."</a></li>
											</ul>
										</div>
										<div class='blog_post_text'>
											<p>".$BreveDesc."...</p>
										</div>
									</div>
								</div>
								";
						}
					}else{
						echo "
						<p>Sem Notícias</p>";
					}

						?>

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
<script src="plugins/easing/easing.js"></script>
<script src="plugins/masonry/masonry.js"></script>
<script src="plugins/video-js/video.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/blog.js"></script>
</body>
</html>
<?php
include('./fechligacao.ini');
?>
