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
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Help2Everyone">
<!--
<meta name="description" content="Unicat project">-->
<link rel="icon" href="./images/logo.ico">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/about.css">
<link rel="stylesheet" type="text/css" href="styles/about_responsive.css">
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
			<form action="./about.php" method="POST">
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
								<li>Sobre</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- About -->

	<div class="about">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Bem-Vindo ao Help2Everyone!</h2>
						<div class="section_subtitle"><p>Com a ajuda do Help2Everyone vais poder sentir uma alegria como nunca antes,
							 terás a hipótese de conhecer novas pessoas que também querem ajudar e poderás sentir-te útil como nunca antes.
						 	 Regista-te já hoje e começa a ajudar.</p></div>
					</div>
				</div>
			</div>
			<div class="row about_row">

				<!-- About Item -->
				<div class="col-lg-4 about_col about_col_left">
					<div class="about_item">
						<div class="about_item_image"><img src="images/image4.png" alt=""></div>
						<div class="about_item_title"><a style="color:black">Testemunhos</a></div>
						<div class="about_item_text">
							<p>Conversa com pessoas que já se voluntariaram com a ajuda dos site e perceberás logo quão util é a nossa ajuda.</p>
						</div>
					</div>
				</div>

				<!-- About Item -->
				<div class="col-lg-4 about_col about_col_middle">
					<div class="about_item">
						<div class="about_item_image"><img src="images/image2.png" alt=""></div>
						<div class="about_item_title"><a style="color:black">A nossa missão</a></div>
						<div class="about_item_text">
							<p>Promover para que o voluntariado seja uma prática mais comum, mais aceite e mais honrada na nossa sociedade.</p>
						</div>
					</div>
				</div>

				<!-- About Item -->
				<div class="col-lg-4 about_col about_col_right">
					<div class="about_item">
						<div class="about_item_image"><img src="images/image5.png" alt=""></div>
						<div class="about_item_title"><a style="color:black">A nossa visão</a></div>
						<div class="about_item_text">
							<p>Esperamos que num momento próximo grande parte da população já se tenha voluntariado, e continue a se voluntariar regularmente.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Feature -->

	<div class="feature">
		<div class="feature_background" style="background-image:url(images/courses_background.jpg)"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Porquê nós?</h2>
						<div class="section_subtitle"><p>Com a tua vontade, necessidade de ajudar e a nossa experiência podes finalmente começar a marcar positivamente a vida de outras pessoas.</p></div>
					</div>
				</div>
			</div>
			<div class="row feature_row">

				<!-- Feature Content -->
				<div class="col-lg-6 feature_col">
					<div class="feature_content">
						<!-- Accordions -->
						<div class="accordions">

							<div class="elements_accordions">

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center"><div>Verificamos cada Organização</div></div>
									<div class="accordion_panel">
										<p>Para que não percas o teu tempo em vão, verificamos pessoalmente cada organização, para garantir que não te estão a passar a perna :)</p>
									</div>
								</div>

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center active"><div>Nós temos os meios</div></div>
									<div class="accordion_panel">
										<p>Com um website fácil e inituitivo como este, vais querer voluntariar-te.</p>
									</div>
								</div>

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center"><div>Sem Problemas</div></div>
									<div class="accordion_panel">
										<p>Na H2E tiramos-te o cansaço e a burocracia em candidatares-te a um evento de voluntariado, basta avisar-nos e aparecer lá, que nós tratamos de tudo.</p>
									</div>
								</div>

								<div class="accordion_container">
									<div class="accordion d-flex flex-row align-items-center"><div>Dúvidas???</div></div>
									<div class="accordion_panel">
										<p>A experiência é uma das maiores fontes de conhecimento, por isso voluntaria-te e vê.</p>
									</div>
								</div>

							</div>

						</div>
						<!-- Accordions End -->
					</div>
				</div>

				<!-- Feature Video -->
				<div class="col-lg-6 feature_col">
					<div class="feature_video d-flex flex-column align-items-center justify-content-center">
						<div class="feature_video_background" style="background-image:url(./images/images.png)"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Team -->

	<div class="team">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title_container text-center">
						<h2 class="section_title">Organizações com mais eventos</h2>
						<div class="section_subtitle"><p>Aqui estão as organizações registadas na H2E que possuem mais eventos registados.</p></div>
					</div>
				</div>
			</div>
			<div class="row team_row">

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
									<div class='team_title'><a href='#'>".$nome."</a></div>
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
								<div class="milestone_counter" data-end-value="<?php echo $tt; ?>" data-sign-after="<?php if($tt>=1000){echo "K";}else{echo "+";} ?>">0</div>
								<div class="milestone_text">Inscritos</div>
							</div>

							<?php
							$res=mysqli_query($conn,"select Id from tblorganizacao");
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
								<div class="milestone_counter" data-end-value="<?php echo $tam; ?>" data-sign-after="<?php if($tam>=1000){echo "K";}else{echo "+";} ?>">0</div>
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

	<!-- Partners -->

	<div class="partners">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="partners_slider_container">
						<div class="owl-carousel owl-theme partners_slider">

							<!-- Partner Item -->
							<a href="https://www.amnistia.pt/" target="_blank">
								<div class="owl-item partner_item" href="./index.php"><img src="images/amnistia.png" title="Visitar o site da Amistia Internacional" alt="Visitar o site da Amistia Internacional"></div>
							</a>

							<a href="http://www.greenpeace.org/portugal/pt/" target="_blank">
							<!-- Partner Item -->
								<div class="owl-item partner_item"><img src="images/greenpeace.png" title="Visitar o site da Greenpeace" alt="Visitar o site da Greenpeace"></div>
							</a>

							<a href="https://www.unicef.pt/" target="_blank">
							<!-- Partner Item -->
								<div class="owl-item partner_item"><img src="images/unicef.png" title="Visitar o site da Unicef" alt="Visitar o site da Unicef"></div>
							</a>

							<a href="https://ami.org.pt/" target="_blank">
							<!-- Partner Item -->
								<div class="owl-item partner_item"><img src="images/ami.png" title="Visitar o site da AMI" alt="Visitar o site da AMI"></div>
							</a>

							<a href="https://www.worldwildlife.org/" target="_blank">
							<!-- Partner Item -->
								<div class="owl-item partner_item"><img src="images/wwf.png" title="Visitar o site da WWF" alt="Visitar o site da WWF"></div>
							</a>

							<a href="https://www.care-international.org/" target="_blank">
							<!-- Partner Item -->
								<div class="owl-item partner_item"><img src="images/care.png" title="Visitar o site da Care" alt="Visitar o site da Care"></div>
							</a>

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


<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyCqo1AQ9ciXQsx9IVSxyFV_Cl0P3o6wVLM",
    authDomain: "dulcet-hulling-219623.firebaseapp.com",
    databaseURL: "https://dulcet-hulling-219623.firebaseio.com",
    projectId: "dulcet-hulling-219623",
    storageBucket: "dulcet-hulling-219623.appspot.com",
    messagingSenderId: "600658613109"
  };
  firebase.initializeApp(config);
</script>

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
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/about.js"></script>
</body>
</html>
<?php
include('./fechligacao.ini');
?>
