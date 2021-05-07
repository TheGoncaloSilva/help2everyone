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
		$logfolder="listagem.php";
		$login=true;
	}else if((isset ($_SESSION['nome']) == true)){
		$logado=$_SESSION['nome'];
		$logtype='Organizacao';
		$result=mysqli_query($conn,"select Foto from tblorganizacao where Nome='".$logado."'");
		$logf=mysqli_fetch_array($result);
		$logfoto=htmlspecialchars($logf['Foto']);
		$logfotof="./Fotos/FotosOrg/".$logfoto;
		$logfolder="listagemorg.php";
		$login=true;
	}else{
		$login=false;
		$logtype='NaoExiste';
		$logfotof="./Fotos/FotosVol/userimg.png";
		$logfolder=null;
		session_destroy();
		unset($_SESSION['user']);
		unset($_SESSION['nome']);
	}
	$msgvisos=0;
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['noticia']))
{
	$_SESSION['targetnoticia']=$_GET['noticia'];
	header('Location: ./blog_single.php');
}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir']))
{
	$_SESSION['targetevent']=$_GET['abrir'];
	header('Location: ./course.php');
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['abrir_org']))
{
	if($logtype=="Voluntario"){
		$_SESSION['targetvol']=$logado;
		header('Location: ./Resume/index.php');
	}else{
		$_SESSION['targetorg']=$logado;
		header('Location: ./Resumeorg/index.php');
	}
}
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['open_org']))
{
		$_SESSION['targetorg']=$_GET['open'];
		header('Location: ./Resumeorg/index.php');
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
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Help2Everyone">
<!--
<meta name="description" content="Unicat project">-->
<link rel="icon" href="./images/logo.ico">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<link>
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
									<!--<div class="logo_text">Help <span style="color:green">2</span> <span> Everyone</span></div>-->
									<a class="navbar-brand" href="./index.php">
										<img src="./images/shortlogo.ico" class="d-inline-block align-top imgnav Logo_text" alt="Help2Everyone">
								</a>
							</div>
							<nav class="main_nav_contaner ml-auto">
								<ul class="main_nav">
									<li class="active"><a href="./index.php">Home</a></li>
									<li class="nav-item dropdown">
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
				<li class="menu_mm"><a href="./contact.php">Contato</a></li>
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
		<div class="home_slider_container">
			<!-- Home Slider -->
			<div class="owl-carousel owl-theme home_slider">

				<!-- Home Slider Item -->
				<div class="owl-item">
					<div class="home_slider_background" style="background-image:url(images/slider_1.jpg)"></div>
					<div class="home_slider_content">
						<div class="container">
							<div class="row">
								<div class="col text-center">
									<div class="home_slider_title" style="">Voluntariado é o maior exercício da democracia</div>
									<div class="home_slider_subtitle" style="font-weight: bold;">"Podes votar nas eleições uma vez por ano, mas ao voluntariares-te, votas todos os dias para o tipo de comunidade em que queres viver"</div>
									<div class="home_slider_form_container">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Home Slider Item -->
				<div class="owl-item">
					<div class="home_slider_background" style="background-image:url(images/home_slider_2.jpg);"></div>
					<div class="home_slider_content">
						<div class="container">
							<div class="row">
								<div class="col text-center">
									<div class="home_slider_title " style="">Ajudamo-nos uns aos outros</div>
									<div class="home_slider_subtitle" style="font-weight: bold;">"Ninguém pode fazer tudo, mas toda a gente junta pode fazer alguma coisa"</div>
									<div class="home_slider_form_container">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Home Slider Item -->
				<div class="owl-item">
					<div class="home_slider_background" style="background-image:url(images/slider_5.jpg)"></div>
					<div class="home_slider_content">
						<div class="container">
							<div class="row">
								<div class="col text-center">
									<div class="home_slider_title" style="">Ajuda a marcar vidas</div>
									<div class="home_slider_subtitle" style="font-weight: bold;">"Dá um pouco de ti e recebe um pouco de todos"</div>
									<div class="home_slider_form_container">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
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
				<form action="./index.php" method="POST">
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

		<!-- Home Slider Nav -->

		<div class="home_slider_nav home_slider_prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
		<div class="home_slider_nav home_slider_next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
	</div>

	<!-- Features -->
	<div class="features">
		<div class="container">
			<?php
			if($msgvisos==1){
					echo "<div class='alert alert-success' role='alert'>
					<div class='row'>
						<div class='col-md-10'>
							<strong>sucesso! </strong>- Dados Atualizados!!!
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
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Bem-vindo ao Help2Everyone</h2>
						<div class="section_subtitle"><p>Com a ajuda do Help2Everyone vais poder sentir uma alegria como nunca antes,
							 terás a hipótese de conhecer novas pessoas que também querem ajudar e poderás sentir-te útil como nunca antes.
						 	 Regista-te já hoje e começa a ajudar.</p></div>
					</div>
				</div>
			</div>
			<div class="row features_row">

				<!-- Features Item -->
				<div class="col-lg-3 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon"><img src="images/helphands.png" alt=""></div>
						<h3 class="feature_title">Ajuda e sê Ajudado</h3>
						<div class="feature_text"><p>Um Voluntário não é pago com dinheiro, mas sim com amor e apreço</p></div>
					</div>
				</div>

				<!-- Features Item -->
				<div class="col-lg-3 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon"><img src="images/meet.png" alt=""></div>
						<h3 class="feature_title">Conhece novas pessoas</h3>
						<div class="feature_text"><p>Pouca gente, em poucos lugares, a fazer coisas pequenas, pode mudar o mundo</p></div>
					</div>
				</div>

				<!-- Features Item -->
				<div class="col-lg-3 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon"><img src="images/smile.png" alt=""></div>
						<h3 class="feature_title">Experiência Memorável</h3>
						<div class="feature_text"><p>Ningúem pode fazer tudo, mas todos juntos podemos fazer o que quisermos</p></div>
					</div>
				</div>

				<!-- Features Item -->
				<div class="col-lg-3 feature_col">
					<div class="feature text-center trans_400">
						<div class="feature_icon"><img src="images/solidario.png" alt=""></div>
						<h3 class="feature_title">Sê Solidário</h3>
						<div class="feature_text"><p>Voluntariado não é só uma palavra, é amor, dedicação e também ação</p></div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Popular Courses -->

	<div class="courses">
		<div class="section_background parallax-window" data-parallax="scroll" data-image-src="images/courses_background.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Últimos Eventos</h2>
						<div class="section_subtitle"><p>Vê por ti próprio os últimos eventos realizados pelas organizações registadas no Help2Everyone. *(No entanto para visualizares os detalhes de cada eventos precisas de iniciar sessão)</p></div>
					</div>
				</div>
			</div>
			<div class="row courses_row">

				<!-- Course -->
				<?php
				$datecomp = date('Y-m-d');
				$cmd=mysqli_query($conn,"select Id from tblevento where Inativo=0 && DataTermino <= '".$datecomp."' order by Id Desc");
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
						$nome_ev=htmlspecialchars($entrada['Nome']);
						$Foto_ev=htmlspecialchars($entrada['FotoLocal']);
						$Desc_ev=htmlspecialchars($entrada['BreveDesc']);
						$BreveDesc_ev=htmlspecialchars($entrada['BreveDesc']);
						$Vagas_ev=htmlspecialchars($entrada['NumVagas']);
						$Vagas_ev=htmlspecialchars($entrada['NumVagas']);
						$Dur_ev=htmlspecialchars($entrada['Duracao']);
						$Help_ev=htmlspecialchars($entrada['Quant_Helps']);
						$IdOrg_ev=htmlspecialchars($entrada['IdOrganizacao']);
						$Reconhecido_ev=htmlspecialchars($entrada['Reconhecido']);
						$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrg_ev);
						$entr=mysqli_fetch_array($company);
						$NomeOrganização_ev=$entr[0];
						$Pic_ev="./Fotos/FotosEvent/".$Foto_ev;

						if($Reconhecido_ev==0){
							$verified=null;
						}else{
							$verified="<span title='Evento Verificado' style='color:#1E90FF;'><i class='fa fa-check-circle'></i></span>";
						}

						echo	"<div class='col-lg-4 course_col'>
							<div class='course'>
								<div class='course_image'><img style='width:100%;' src='".$Pic_ev."' alt=''></div>
								<div class='course_body'>
									<h3 class='course_title'><a href='index.php?abrir=".$identity."'>".$nome_ev." ".$verified."</a></h3>
									<div class='course_teacher'>".$NomeOrganização_ev."</div>
									<div class='course_text'>
										<p>".$Desc_ev."</p>
									</div>
								</div>
								<div class='course_footer'>
									<div class='course_footer_content d-flex flex-row align-items-center justify-content-start'>
										<div class='course_info'>
											<i class='fa fa-users' aria-hidden='true'></i>
											<span>".$Vagas_ev." Voluntários</span>
										</div>
										<div class='course_info'>
											<i class='fa fa-money' aria-hidden='true'></i>
											<span>".$Help_ev." Helps</span>
										</div>
										<div class='course_price ml-auto'>".$Dur_ev." H</div>
									</div>
								</div>
							</div>
						</div>";
				}
				?>
			</div>
			<div class="row">
				<div class="col">
					<div class="courses_button trans_200"><a href="./courses.php">Ver todos os Eventos</a></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Counter -->

	<div class="counter">
		<div class="counter_background" style="background-image:url(images/counter_background.jpg)"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="counter_content">
						<h2 class="counter_title">Regista-te Hoje!</h2>
						<div class="counter_text"><p>Junta-te a uma comunidade crescente de pessoas com o mesmo objetivo que tu e ajuda
						a tornar o mundo um lugar melhor para as pessoas que precisam. Ajuda no que conseguires, por mais pouco que seja
						e vais receber o mundo em troca.</p></div>

						<!-- Milestones -->

						<div class="milestones d-flex flex-md-row flex-column align-items-center justify-content-between">
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
							<!-- Milestone -->
							<div class="milestone">
								<div class="milestone_counter" data-end-value="<?php echo $diff; ?>">0</div>
								<div class="milestone_text">Meses</div>
							</div>

							<?php
							$resultado=mysqli_query($conn,"select Id from tblvoluntario");
							$l=0;
							$dados[0]=null;
							while ($linha=mysqli_fetch_array($resultado)) {

								$dados[$l]=$linha[0];
								$l++;
							}
							$tt=count($dados);
							?>

							<!-- Milestone -->
							<div class="milestone">
								<div class="milestone_counter" data-end-value="<?php echo $tt; ?>" data-sign-after="+">0</div>
								<div class="milestone_text">Inscritos</div>
							</div>

							<?php
							$res=mysqli_query($conn,"select Id from tblorganizacao where Aprovada=1");
							$l1=0;
							$dado[0]=null;
							while ($linhas=mysqli_fetch_array($res)) {

								$dado[$l1]=$linhas[0];
								$l1++;
							}
							$tam=count($dado);
							?>

							<!-- Milestone -->
							<div class="milestone">
								<div class="milestone_counter" data-end-value="<?php echo $tam; ?>" data-sign-after="+">0</div>
								<div class="milestone_text">Organizações</div>
							</div>

							<?php
							$cmd=mysqli_query($conn,"select Id from tblevento");
							$lol=0;
							$info[0]=null;
							while ($seg=mysqli_fetch_array($cmd)) {

								$info[$lol]=$seg[0];
								$lol++;
							}
							$tas=count($info);
							?>

							<!-- Milestone -->
							<div class="milestone">
								<div class="milestone_counter" data-end-value="<?php echo $tas; ?>">0</div>
								<div class="milestone_text">Eventos</div>
							</div>

						</div>
					</div>

				</div>
			</div>

			<div class="counter_form">
				<div class="row fill_height">
					<div class="col fill_height">
						<form class="counter_form_content d-flex flex-column align-items-center justify-content-center" action="./Login_Vol/register.php" method="GET">
							<div class="counter_form_title">Registar</div>
							<input type="text" name="Nome" class="counter_input" placeholder="Nome" required="required">
							<input type="text" name="Apelido" class="counter_input" placeholder="Apelido" required="required">
							<input type="text" name="Email" class="counter_input" placeholder="Email" required="required">
							<input type="text" name="User" class="counter_input" placeholder="Utilizador" required="required">
							<button type="submit" class="counter_form_button">Registar</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- Events -->

	<div class="events">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Próximos Eventos</h2>
						<div class="section_subtitle"><p>Eventos que se irão realizar nos próximos dias</p></div>
					</div>
				</div>
			</div>
			<div class="row events_row">

				<?php
				$cmd=mysqli_query($conn,"select Id,DataInicio from tblevento where Inativo=0 order by DataInicio DESC");
				$voltas=0;
				$info=array();
				while ($seg=mysqli_fetch_array($cmd)) {
					$info[$voltas]=$seg[0];
					$datas[$voltas]=$seg[1];
					$voltas++;
				}
				$tas=count($info);
				$info1=$info;
				$datas1=$datas;
				$data_ref=date('y-m-d');
				for($i=0;$i<$tas;$i++){
					if(strtotime($datas1[$i])<=strtotime($data_ref)){
						unset($info1[$i]);
						unset($datas1[$i]);
					}
				}
				$size=count($info1);
				if($size==0){
					$info1=$info;
					$datas1=$datas;
					if($tas>=3){
						$tas=3;
					}
					$size=$tas;
				}else if($size>=3){
					$size=3;
				}
				asort($info1);

				for($i=0;$i<$size;$i++){
					$result=mysqli_query($conn,"select * from tblevento where Id=".$info1[$i]);
						$entrada=mysqli_fetch_array($result);
						$identity=htmlspecialchars($entrada['Id']);
						$nome_e=htmlspecialchars($entrada['Nome']);
						$Foto_e=htmlspecialchars($entrada['FotoLocal']);
						$Desc_e=htmlspecialchars($entrada['Descricao']);
						$BreveDesc_e=htmlspecialchars($entrada['BreveDesc']);
						$Vagas_e=htmlspecialchars($entrada['NumVagas']);
						$DataInicio_e=htmlspecialchars($entrada['DataInicio']);
						$DataTermino_e=htmlspecialchars($entrada['DataTermino']);
						$Distrito_e=htmlspecialchars($entrada['Distrito']);
						$Dur_e=htmlspecialchars($entrada['Duracao']);
						$Help_e=htmlspecialchars($entrada['Quant_Helps']);
						$Reconhecido_e=htmlspecialchars($entrada['Reconhecido']);
						$Pic_e="./Fotos/FotosEvent/".$Foto_e;

						$time = strtotime($DataInicio_e);
						$d = date('d', $time);
						$m = date('m', $time);
						$a = date('Y', $time);

						switch ($m) {
							case '01':$meses='Jan';break;
							case '02':$meses='Fev';break;
							case '03':$meses='Mar';break;
							case '04':$meses='Abr';break;
							case '05':$meses='Mai';break;
							case '06':$meses='Jun';break;
							case '07':$meses='Jul';break;
							case '08':$meses='Ago';break;
							case '09':$meses='Set';break;
							case '10':$meses='Out';break;
							case '11':$meses='Nov';break;
							case '12':$meses='Dez';break;
							default:break;
						}
						$Date=date_create($DataInicio_e);
						$Date2=date_create($DataTermino_e);
						if($Reconhecido_e==0){
							$verified=null;
						}else{
							$verified="<span title='Evento Verificado' style='color:#1E90FF;'><i class='fa fa-check-circle'></i></span>";
						}

						echo "
						<div class='col-lg-4 event_col'>
							<div class='event event_left'>
								<div class='event_image'><img style='width:100%;' src='".$Pic_e."' alt=''></div>
								<div class='event_body d-flex flex-row align-items-start justify-content-start'>
									<div class='event_date'>
										<div class='d-flex flex-column align-items-center justify-content-center trans_200'>
											<div class='event_day trans_200'>".$d."</div>
											<div class='event_month trans_200'>".$meses."</div>
										</div>
									</div>
									<div class='event_content'>
										<div class='event_title'><a href='./index.php?abrir=".$identity."'>".$nome_e." ".$verified."</a></div>
										<div class='event_info_container'>
											<div class='event_info'><i class='fa fa-calendar' aria-hidden='true'></i><span>".date_format($Date,"d/m/Y")." até ".date_format($Date2,"d/m/Y")."</span></div>
											<div class='event_info'><i class='fa fa-map-marker' aria-hidden='true'></i><span>".$Distrito_e."</span></div>
											<div class='event_text'>
												<p>".$BreveDesc_e."</p>
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

	<!-- Team -->

	<div class="team">
		<div class="team_background parallax-window" data-parallax="scroll" data-image-src="images/team_background.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Organizações com mais eventos</h2>
						<div class="section_subtitle"><p>Aqui estão as organizações inscritas na H2E que possuem mais eventos registados.</p></div>
					</div>
				</div>
			</div>
			<div class="row team_row">

				<!-- Team Item -->
				<?php
				$selec=mysqli_query($conn,"select IdOrganizacao from tblorgevento order by IdOrganizacao Desc");
				$voltas=0;
				$info=array();
				while ($seg=mysqli_fetch_array($selec)) {

					$info[$voltas]=$seg[0];
					$voltas++;
				}
				$tas=count($info);
				$contagem = array_count_values($info);
				$vol=0;
				$vez=array();
				foreach($contagem AS $numero => $vezes) {
					$vez[$vol]=$numero;
					$vol++;
				}
				//var_dump($contagem);
				$t=count($contagem);
				for($v=0;$v<$t;$v++){
					$result=mysqli_query($conn,"select * from tblorganizacao where Id=".$vez[$v]);
						$entrada=mysqli_fetch_array($result);
						$identity=htmlspecialchars($entrada['Id']);
						$nome=htmlspecialchars($entrada['Nome']);
						$Foto=htmlspecialchars($entrada['Foto']);
						$Email=htmlspecialchars($entrada['Email']);
						$PagFacebook=htmlspecialchars($entrada['PagFacebook']);
						$PagTwitter=htmlspecialchars($entrada['PagTwitter']);
						$PagInstagram=htmlspecialchars($entrada['PagInstagram']);
						$Pic="./Fotos/FotosOrg/".$Foto;

						echo "<div class='col-lg-3 col-md-6 team_col'>
							<div class='team_item'>
								<div class='team_image'><img src='".$Pic."' alt=''></div>
								<div class='team_body'>
									<div class='team_title'><a style='color:black'>".$nome."</a></div>
									<div class='team_subtitle'>".$Email."</div>
									<div class='social_list'>
										<ul>
											<li><a href='".$PagFacebook."'><i class='fa fa-facebook' aria-hidden='true'></i></a></li>
											<li><a href='".$PagTwitter."'><i class='fa fa-twitter' aria-hidden='true'></i></a></li>
											<li><a href='".$PagInstagram."'><i class='fa fa-instagram' aria-hidden='true'></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>";
				}
				?>


				<!-- Team Item
				<div class="col-lg-3 col-md-6 team_col">
					<div class="team_item">
						<div class="team_image"><img src="images/team_2.jpg" alt=""></div>
						<div class="team_body">
							<div class="team_title"><a href="#">William James</a></div>
							<div class="team_subtitle">Designer & Website</div>
							<div class="social_list">
								<ul>
									<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				-->
			</div>
		</div>
	</div>

	<!-- Latest News -->
	<div class="news">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Últimas Notícias</h2>
						<div class="section_subtitle"><p>Nesta Secção pode ver as Últimas Notícias publicas sobre o site Help2Everyone.</p></div>
					</div>
				</div>
			</div>
			<div class="row news_row">
				<div class="col-lg-7 news_col">
					<?php
					$Nome_Noticia="Sem Notícias";
					$Pic=null;
					$nascimento=null;
					$BreveDesc=null;
					$query=mysqli_query($conn,"select Id from tblnoticias order by Data Desc");
					$voltas=0;
					$info=array();
					while ($res_query=mysqli_fetch_array($query)) {

						$info[$voltas]=$res_query[0];
						$voltas++;
					}
					$tas=count($info);
					if(!empty($tas)){
						$result=mysqli_query($conn,"select * from tblnoticias where Id=".$info[0]);
							$entrada=mysqli_fetch_array($result);
							$identity=htmlspecialchars($entrada['Id']);
							$Titulo=htmlspecialchars($entrada['Titulo']);
							$Data=htmlspecialchars($entrada['Data']);
							$BreveDesc=htmlspecialchars($entrada['BreveDesc']);
							$Foto=htmlspecialchars($entrada['Foto']);
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
							$nascimento=$dia." de ".$mes.", ".$ano;
							unset($info[0]);
							sort($info);
							$tas=count($info);
						}
					?>
					<!-- News Post Large -->
					<div class="news_post_large_container">
						<div class="news_post_large">
							<div class="news_post_image"><img src="<?php echo $Pic; ?>" alt=""></div>
							<div class="news_post_large_title"><a href="blog_single.php"><?php echo $Titulo; ?></a></div>
							<div class="news_post_meta">
								<ul>
									<li><a>admin</a></li>
									<li><a><?php echo $nascimento; ?></a></li>
								</ul>
							</div>
							<div class="news_post_text">
								<p><?php echo $BreveDesc; ?></p>
							</div>
							<div class="news_post_link"><a href="index.php?noticia=<?php echo $identity; ?>">Ver Notícia</a></div>
						</div>
					</div>
				</div>

				<div class="col-lg-5 news_col">
					<div class="news_posts_small">
						<?php
						if(!empty($tas)){
						for($i=0;$i<$tas;$i++){
							$result=mysqli_query($conn,"select * from tblnoticias where Id=".$info[$i]);
								$entrada=mysqli_fetch_array($result);
								$identity=htmlspecialchars($entrada['Id']);
								$Titulo=htmlspecialchars($entrada['Titulo']);
								$Data=htmlspecialchars($entrada['Data']);
								$BreveDesc=htmlspecialchars($entrada['BreveDesc']);
								$Foto=htmlspecialchars($entrada['Foto']);
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
								$nascimento=$dia." de ".$mes.", ".$ano;
								echo "
								<div class='news_post_small'>
									<div class='news_post_small_title'><a href='index.php?noticia=".$identity."'>".$Titulo."</a></div>
									<div class='news_post_meta'>
										<ul>
											<li><a>admin</a></li>
											<li><a>".$nascimento."</a></li>
										</ul>
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
	<script src="plugins/greensock/TweenMax.min.js"></script>
	<script src="plugins/greensock/TimelineMax.min.js"></script>
	<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
	<script src="plugins/greensock/animation.gsap.min.js"></script>
	<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
	<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
	<script src="plugins/easing/easing.js"></script>
	<script src="plugins/parallax-js-master/parallax.min.js"></script>
	<script src="js/custom.js"></script>
	</body>
	</html>
<?php
include('./fechligacao.ini');
?>
