<?php
	include('./inicligacao.ini');
	session_start();
	if((isset ($_SESSION['user']) == true)){
	  $logado=$_SESSION['user'];
		$logtype='Voluntario';
		$result=mysqli_query($conn,"select Foto from tblvoluntario where Utilizador='".$logado."'");
		$logf=mysqli_fetch_array($result);
		$logfoto=htmlspecialchars($logf['Foto']);
		$logfotof="./Fotos/FotosVol/".$logfoto;
		$login=true;
		if($_SESSION['targetnoticia']==true){
			$targetnoticia=$_SESSION['targetnoticia'];
		}else{
			header('Location: ./blog.php');
		}
	}else if((isset ($_SESSION['nome']) == true)){
		$logado=$_SESSION['nome'];
		$logtype='Organizacao';
		$result=mysqli_query($conn,"select Foto from tblorganizacao where Nome='".$logado."'");
		$logf=mysqli_fetch_array($result);
		$logfoto=htmlspecialchars($logf['Foto']);
		$logfotof="./Fotos/FotosOrg/".$logfoto;
		$login=true;
		if($_SESSION['targetnoticia']==true){
			$targetnoticia=$_SESSION['targetnoticia'];
		}else{
			header('Location: ./blog.php');
		}
	}else{
		$login=false;
		$logtype='NaoExiste';
		$logfotof="./Fotos/FotosVol/userimg.png";
		unset($_SESSION['user']);
		unset($_SESSION['nome']);
		if($_SESSION['targetnoticia']==true){
			$targetnoticia=$_SESSION['targetnoticia'];
		}else{
			header('Location: ./blog.php');
		}
	}
	$logfolder=null;
	if($logtype=='Organizacao'){
		$logfolder="listagemorg.php";
	}else{
		$logfolder="listagem.php";
	}
	$msgvisos=0;

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['Comentar']))
{
	if (!empty($_POST['Coment'])) {
		$Comentario=htmlspecialchars($_POST['Coment']);
	}
	if (!empty($_POST['Nome'])) {
		$Nome=htmlspecialchars($_POST['Nome']);
	}
	if (!empty($_POST['Email'])) {
		$Email=htmlspecialchars($_POST['Email']);
	}
	date_default_timezone_set('Europe/Lisbon');
	$data_hora = date('Y-m-d H:i');
	if(mysqli_query($conn,"insert into tblvolnoticiacomentario(Nome,Email,IdNoticia,Descricao,DataHora) values('".$Nome."','".$Email."','".$targetnoticia."','".$Comentario."','".$data_hora."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
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
<title>Help2Everyone: Notícias</title>
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
<link rel="stylesheet" type="text/css" href="styles/blog_single.css">
<link rel="stylesheet" type="text/css" href="styles/blog_single_responsive.css">
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
			<form action="./blog_single.php" method="POST">
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
								<li><a href="blog.php">Notícias</a></li>
								<li>Detalhe Notícia</li>
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
			<div class="row">

				<!-- Blog Content -->
				<div class="col-lg-8">
					<?php
					$select=mysqli_query($conn,"select * from tblnoticias where Id=".$targetnoticia);
					$linha=mysqli_fetch_array($select);
					$Id_Noticia=htmlspecialchars($linha['Id']);
					$Titulo_Noticia=htmlspecialchars($linha['Titulo']);
					$Subtitulo_Noticia=htmlspecialchars($linha['Subtitulo']);
					$Data_Noticia=htmlspecialchars($linha['Data']);
					$BreveDesc_Noticia=htmlspecialchars($linha['BreveDesc']);
					$Descricao_Noticia=($linha['Descricao']);
					$Descricao_Subtitulo_Noticia=($linha['DescricaoSubtitulo']);
					$Foto_Noticia=htmlspecialchars($linha['Foto']);
					$Foto_extra_Noticia=htmlspecialchars($linha['Foto_extra']);
					$Foto_extra_extra_Noticia=htmlspecialchars($linha['Foto_extra_extra']);
					$Face_Noticia=htmlspecialchars($linha['Facebook']);
					$Insta_Noticia=htmlspecialchars($linha['Instagram']);
					$TWT_Noticia=htmlspecialchars($linha['Twitter']);
					$Linkedin_Noticia=htmlspecialchars($linha['Linkedin']);
					$Tags_Noticia=htmlspecialchars($linha['Tags']);
					$Categoria_Noticia=htmlspecialchars($linha['Categoria']);
					$Pic1_Noticia="./Fotos/FotosNoticias/".$Foto_Noticia;
					$Pic2_Noticia="./Fotos/FotosNoticias/".$Foto_extra_Noticia;
					$Pic3_Noticia="./Fotos/FotosNoticias/".$Foto_extra_extra_Noticia;

					$ts1 = strtotime($Data_Noticia);
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

					switch ($Categoria_Noticia) {
						case '1':$Cat_Noticia='Ambiente';break;
						case '2':$Cat_Noticia='Voluntários';break;
						case '3':$Cat_Noticia='Organizações';break;
						case '4':$Cat_Noticia='Eventos';break;
						case '5':$Cat_Noticia='Ajuda Humanitária';break;
						case '6':$Cat_Noticia='Outros';break;
						default:break;
					}

					?>
					<div class="blog_content">
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
						<div class="blog_title"><?php echo $Titulo_Noticia; ?></div>
						<div class="blog_meta">
							<ul>
								<li>Postado em <a><?php echo $nascimento; ?></a></li>
								<li>Por <a>Admin</a></li>
								<li>Categoria <a><?php echo $Cat_Noticia; ?></a></li>
							</ul>
						</div>
						<div class="blog_image"><img  style='min-width:100%;' src="<?php echo $Pic1_Noticia; ?>" alt=""></div>
						<p><?php echo $Descricao_Noticia; ?></p>
						<div class="blog_subtitle"><?php echo $Subtitulo_Noticia; ?></div>
						<p><?php echo $Descricao_Subtitulo_Noticia; ?>.</p>
						<div class="blog_images">
							<div class="row">
								<div class="col-lg-6 blog_images_col"><div class="blog_image_small"><img src="<?php echo $Pic2_Noticia; ?>" alt=""></div></div>
								<div class="col-lg-6 blog_images_col"><div class="blog_image_small"><img src="<?php echo $Pic3_Noticia; ?>" alt=""></div></div>
							</div>
						</div>
						<p>Em nome da Help2Everyone agradecemos muito ter gasto o seu tempo precioso a ler esta Notícia. Estamos muito gratos e Disfrute do nosso website.</p>
					</div>


					<div class="blog_extra d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
						<div class="blog_tags">
							<span>Tags: </span>
							<ul>
								<li><a><?php echo $Tags_Noticia; ?></a>, </li>
							</ul>
						</div>
						<div class="blog_social ml-lg-auto">
							<span>Partilhar: </span>
							<ul>
								<li><a target="_blank" href="<?php echo $Face_Noticia; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a target="_blank" href="<?php echo $TWT_Noticia; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a target="_blank" href="<?php echo $Instagram_Noticia; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
								<li><a target="_blank" href="<?php echo $Linkedin_Noticia; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- Comments -->
					<?php
					$query=mysqli_query($conn,"select Id from tblvolnoticiacomentario where IdNoticia=".$targetnoticia);
					$voltas=0;
					$info=array();
					while ($res_query=mysqli_fetch_array($query)) {
						$info[$voltas]=$res_query[0];
						$voltas++;
					}
					$tamcom=count($info);
					?>
					<div class="comments_container">
						<div class="comments_title"><span><?php echo $tamcom; ?></span> Comentários</div>
						<ul class="comments_list">
							<li>
								<?php
									$selectcom=mysqli_query($conn,"select Id from tblvolnoticiacomentario where IdNoticia=".$targetnoticia."");
										$turn=0;
										$form=array();
										while ($ent=mysqli_fetch_array($selectcom)) {

											$form[$turn]=$ent[0];
											$turn++;
										}
										$tambd=count($form);
										if(!empty($tambd)){
										for($i=0;$i<$tambd;$i++){
											$searchcom=mysqli_query($conn,"select * from tblvolnoticiacomentario where Id='".$form[$i]."'");
											$convertcom=mysqli_fetch_array($searchcom);
											$Nome_com=htmlspecialchars($convertcom['Nome']);
											$Email_com=htmlspecialchars($convertcom['Email']);
											$Desc_com=htmlspecialchars($convertcom['Descricao']);
											$DataHora_com=htmlspecialchars($convertcom['DataHora']);
											$Pic_com="./Fotos/FotosNoticias/unknown_user.png";

											date_default_timezone_set('Europe/Lisbon');
											$data3 = date('Y-m-d H:i');

											$date  = new DateTime($DataHora_com);
											$date2 = new DateTime($data3);

											$diference=($date2->diff($date));
											$diferenca=($date2->diff($date));
											$diff=$diference->format('%H Horas');
											$diff2=$diferenca->format('%a dias');
											//var_dump($diference);
											if($diff2<1){
												$difinal=$diff;
											}else{
												$difinal=$diff2;
											}

									echo "
									<div class='comment_item d-flex flex-row align-items-start jutify-content-start'>
										<div class='comment_image'><div><img src='".$Pic_com."' alt=''></div></div>
										<div class='comment_content'>
											<div class='comment_title_container d-flex flex-row align-items-center justify-content-start'>
												<div class='comment_author'><a style='color:black;'>".$Nome_com."</a></div>
												<div class='comment_rating'>".$Email_com."</div>
												<div class='comment_time ml-auto'>Há ".$difinal."</div>
											</div>
											<div class='comment_text'>
												<p>".$Desc_com."</p>
											</div>
										</div>
									</div>";

									$selectorg=mysqli_query($conn,"select Id from tbladminnoticiacomentario where IdComentario='".$form[$i]."'");

										$vol=0;
										$dado=array();
										while ($er=mysqli_fetch_array($selectorg)) {

											$dado[$vol]=$er[0];
											$vol++;
										}
										$tamsel=count($dado);

										if(!empty($tamsel)){
										for($v=0;$v<$tamsel;$v++){
											$scom=mysqli_query($conn,"select * from tbladminnoticiacomentario where Id='".$dado[$v]."'");
											$ccom=mysqli_fetch_array($scom);
											$IdOrg_com=htmlspecialchars($ccom['IdAdmin']);
											$DescOrg_com=htmlspecialchars($ccom['Descricao']);
											$DataHoraOrg_com=htmlspecialchars($ccom['DataHora']);

											$sorg=mysqli_query($conn,"select * from tbladmin where Id='".$IdOrg_com."'");
											$corgcom=mysqli_fetch_array($sorg);
											$NomeOrg_com=htmlspecialchars($corgcom['Nome']);
											$ApelidoOrg_com=htmlspecialchars($corgcom['Apelido']);
											$EmailOrg_com=htmlspecialchars($corgcom['Email']);
											$FotoOrg_com=htmlspecialchars($corgcom['Foto']);
											$PicOrg_com="./../H2E - Admin/Fotos/FotosAdmin/".$FotoOrg_com;

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
									echo "
									<ul>
										<li>
											<div class='comment_item d-flex flex-row align-items-start jutify-content-start'>
												<div class='comment_image'><div><img src='".$PicOrg_com."' alt=''></div></div>
												<div class='comment_content'>
													<div class='comment_title_container d-flex flex-row align-items-center justify-content-start'>
														<div class='comment_author'><a style='color:black;'>".$NomeOrg_com." ".$ApelidoOrg_com."</a></div>
														<div class='comment_rating'>".$EmailOrg_com."</div>
														<div class='comment_time ml-auto'>Há ".$difinals."</div>
													</div>
													<div class='comment_text'>
														<p>".$DescOrg_com."</p>
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
								</div>";
							}
								?>

							</li>
						</ul>
						<div class="add_comment_container">
							<div class="add_comment_title">Dá uma Opinião</div>
							<div class="add_comment_text">Campos requeridos estão marcados com *</div>
							<form action="./blog_single.php" method="POST" class="comment_form">
								<div>
									<div class="form_title">Comentário*</div>
									<textarea class="comment_input comment_textarea" name="Coment" required="required"></textarea>
								</div>
								<div class="row">
									<div class="col-md-6 input_col">
										<div class="form_title">Nome*</div>
										<input type="text" class="comment_input" name="Nome" required="required">
									</div>
									<div class="col-md-6 input_col">
										<div class="form_title">Email*</div>
										<input type="text" class="comment_input" name="Email" required="required">
									</div>
								</div>
								<div class="comment_notify">
								</div>
								<div>
									<button type="submit" class="comment_button trans_200" name="Comentar">Comentar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
				$query=mysqli_query($conn,"select Categoria from tblnoticias");
				$cat1=0;
				$cat2=0;
				$cat3=0;
				$cat4=0;
				$cat5=0;
				$cat6=0;
				while ($res_query=mysqli_fetch_array($query)) {

					if($res_query[0]==1){
						$cat1=$cat1+1;
					}else if($res_query[0]==2){
						$cat2=$cat2+1;
					}else if($res_query[0]==3){
						$cat3=$cat3+1;
					}else if($res_query[0]==4){
						$cat4=$cat4+1;
					}else if($res_query[0]==5){
						$cat5=$cat5+1;
					}else if($res_query[0]==6){
						$cat6=$cat6+1;
					}
				}
				?>
				<!-- Blog Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">
						<!-- Categories -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Categorias</div>
							<div class="sidebar_categories">
								<ul class="categories_list">
									<li><a class="clearfix">Ambiente<span>(<?php echo $cat1; ?>)</span></a></li>
									<li><a class="clearfix">Voluntários<span>(<?php echo $cat2; ?>)</span></a></li>
									<li><a class="clearfix">Organizações<span>(<?php echo $cat3; ?>)</span></a></li>
									<li><a class="clearfix">Eventos<span>(<?php echo $cat4; ?>)</span></a></li>
									<li><a class="clearfix">Ajuda Humanitária<span>(<?php echo $cat5; ?>)</span></a></li>
									<li><a class="clearfix">Outros<span>(<?php echo $cat6; ?>)</span></a></li>
								</ul>
							</div>
						</div>

						<!-- Latest News -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Últimas Notícias</div>
							<div class="sidebar_latest">
								<?php
								$query=mysqli_query($conn,"select Id from tblnoticias order by Data Desc");
								$voltas=0;
								$info=array();
								while ($res_query=mysqli_fetch_array($query)) {

									$info[$voltas]=$res_query[0];
									$voltas++;
								}
								$tas=count($info);
								if($tas>=5){
									$tas=4;
								}
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
										<div class='latest d-flex flex-row align-items-start justify-content-start'>
											<div class='latest_image'><div><img src='".$Pic."' alt=''></div></div>
											<div class='latest_content'>
												<div class='latest_title'><a href='blog.php?noticia=".$identity."'>".$Titulo."</a></div>
												<div class='latest_date'>".$nascimento."</div>
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
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/blog_single.js"></script>
</body>
</html>
<?php
include('./fechligacao.ini');
?>
