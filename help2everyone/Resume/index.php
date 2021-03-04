<?php
	include('./../inicligacao.ini');
  session_start();
	$volvinda=$_SESSION['targetvol'];
  if((isset ($_SESSION['user']) == true)){
	  $logado=$_SESSION['user'];
		$logtype='Voluntario';
		$login=true;
	}else if((isset ($_SESSION['nome']) == true)){
    $logado=$_SESSION['nome'];
  	$logtype='Organizacao';
  	$login=true;
	}else{
		$login=false;
		session_destroy();
		unset($_SESSION['user']);
		unset($_SESSION['nome']);
    header('Location: ./../index.php');
	}
	if($logado!=$volvinda){
		$falso=1;
	}else{
		$falso=0;
	}
	$result=mysqli_query($conn,"select * from tblvoluntario where Utilizador='".$volvinda."'");
	$entrada=mysqli_fetch_array($result);
	$identidade=htmlspecialchars($entrada['Id']);
	$utilizador=htmlspecialchars($entrada['Utilizador']);
	$fotozinha=htmlspecialchars($entrada['Foto']);
	$msgvisos=0;

	if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updateall'])) {
		$password=null;
	  if (!empty($_POST['nome'])) {
	    $nome=htmlspecialchars($_POST['nome']);
	  }
		if (!empty($_POST['ficheiroup'])) {
			$fic=htmlspecialchars($_POST['ficheiroup']);
		}
		if (!empty($_POST['apelido'])) {
			$apelido=htmlspecialchars($_POST['apelido']);
		}
	  if (!empty($_POST['email'])) {
	    $email=htmlspecialchars($_POST['email']);
	  }
		if (!empty($_POST['tele'])) {
	    $tele=htmlspecialchars($_POST['tele']);
	  }
		if (!empty($_POST['data_nasc'])) {
			$datanasc=htmlspecialchars($_POST['data_nasc']);
		}
		if (!empty($_POST['pais'])) {
			$pais=htmlspecialchars($_POST['pais']);
		}
		if (!empty($_POST['cod_pos'])) {
			$codpostal=htmlspecialchars($_POST['cod_pos']);
		}
		if (!empty($_POST['morada'])) {
			$mo=htmlspecialchars($_POST['morada']);
		}
		if (!empty($_POST['distrito'])) {
			$dist=htmlspecialchars($_POST['distrito']);
		}
		if (!empty($_POST['concelho'])) {
			$conc=htmlspecialchars($_POST['concelho']);
		}
		if (!empty($_POST['freguesia'])) {
			$freg=htmlspecialchars($_POST['freguesia']);
		}
		if (!empty($_POST['facebook'])) {
			$face=htmlspecialchars($_POST['facebook']);
		}else{
			$face="https://www.facebook.com/";
		}
		if (!empty($_POST['instagram'])) {
			$insta=htmlspecialchars($_POST['instagram']);
		}else{
			$insta="https://www.instagram.com/?hl=pt";
		}
		if (!empty($_POST['twitter'])) {
			$twit=htmlspecialchars($_POST['twitter']);
		}else{
			$twit="https://twitter.com/";
		}
		if (!empty($_POST['habilitacoes'])) {
			$hab=htmlspecialchars($_POST['habilitacoes']);
		}
		if (!empty($_POST['sit_profissional'])) {
			$eprof=htmlspecialchars($_POST['sit_profissional']);
		}
		if (!empty($_POST['profissao'])) {
			$cargo=htmlspecialchars($_POST['profissao']);
		}
		if (!empty($_POST['info'])) {
			$info=htmlspecialchars($_POST['info']);
		}
		if (!empty($_POST['password'])) {
			$pass=htmlspecialchars($_POST['password']);
			$pass=hash('sha256',$pass);
			$password=" , Password='".$pass."'";
		}
			$result=mysqli_query($conn,"select * from tblvoluntario where Utilizador='".$volvinda."'");
			$entrada=mysqli_fetch_array($result);
			$foto_volz=htmlspecialchars($entrada['Foto']);

				$caminho=$_FILES['ficheiroup']['name'];
				$caminhoTmp=$_FILES['ficheiroup']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$identidade.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./../Fotos/FotosVol/".$caminho);

					if($foto_volz!="userimg.png"){
						unlink("./../Fotos/FotosVol/".$foto_volz);
					}
				}else{
					$caminho=$fotozinha;
				}
		if(mysqli_query($conn,"update tblvoluntario set Nome='".$nome."' , Apelido='".$apelido."' , email='".$email."', Telemovel='".$tele."'
		, Pais='".$pais."' , Morada='".$mo."' , CodPostal='".$codpostal."' , Distrito='".$dist."' , Concelho='".$conc."' , Freguesia='".$freg."'
		, DataNasc='".$datanasc."' , Facebook='".$face."' , Twitter='".$twit."' , Instagram='".$insta."' , Info='".$info."' , Habilitacoes='".$hab."'
		, SituacaoProfissional='".$eprof."' , Profissao='".$cargo."' , Foto='".$caminho."'".$password." where Id=".$identidade)){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
		unset($_POST);
		header("Location: ".$_SERVER['PHP_SELF']);
	}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['arin']))
{
	if(!empty($_POST['checkbox'])){
		$check=$_POST['checkbox'];
	}
	if(!empty($check)){
	 $tam=count($check);
	 for($i=0;$i<$tam;$i++)
	 {
		 $idop=$check[$i];
		 $tentar=mysqli_query($conn,"select Id from tblskills where Nome='".$idop."' && IdVoluntario='".$identidade."'");
		 $verificar=mysqli_fetch_array($tentar);
		 if($verificar[0]!=null){
				 $cmdt=mysqli_query($conn,"select Nome from tblskills where IdVoluntario='".$identidade."'");
				 $l1=0;
				 $dado=array();
				 while ($linhas=mysqli_fetch_array($cmdt)) {

					 $dado[$l1]=$linhas[0];
					 $l1++;
				 }
				 $ttam=count($dado);
				 $assistant=$dado;
				 for($t=0;$t<$ttam;$t++)
				 {
					 for($p=0;$p<$tam;$p++){
						 if($dado[$t]==$check[$p]){
							 	unset($assistant[$t]);
					 }
					 }
				 }

				 if(!empty($dado)){
					 $finalt=count($assistant);
					 sort($assistant);
					 for($f=0;$f<$finalt;$f++){
							if(mysqli_query($conn,"Delete from tblskills where Nome='".$dado[$finalt]."' && IdVoluntario='".$identidade."'")){
								$msgvisos=1;
							}else{
								$msgvisos=2;
							}
					 }
				 }

			}else{
			if(mysqli_query($conn,"insert into tblskills(Nome,IdVoluntario) values('".$idop."','".$identidade."')")){
				$msgvisos=1;
			}else{
				$msgvisos=2;
			}
		 }
	 }
 }
 unset($_POST);
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

	if(mysqli_query($conn,"insert into tblreportvol(Nome,Email,Tipo,Descricao,DataHora,Id_Voluntario) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn2']))
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
	$tipo=2;
	date_default_timezone_set('Europe/Lisbon');
	$dh = date('Y-m-d H:i');

	if(mysqli_query($conn,"insert into tblreportvol(Nome,Email,Tipo,Descricao,DataHora,Id_Voluntario) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn3']))
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
	$tipo=3;
	date_default_timezone_set('Europe/Lisbon');
	$dh = date('Y-m-d H:i');
	if(mysqli_query($conn,"insert into tblreportvol(Nome,Email,Tipo,Descricao,DataHora,Id_Voluntario) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['rating']))
{
 $estrelas=$_GET['rating'];
 $result=mysqli_query($conn,"select Id from tblorganizacao where Nome='".$logado."'");
 $entrada=mysqli_fetch_array($result);
 $IdOrg=htmlspecialchars($entrada['Id']);
	if(mysqli_query($conn,"insert into tblvolrating(IdOrganizacao,IdVoluntario,Stars) values('".$IdOrg."','".$identidade."','".$estrelas."')")){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']);
}
?>
<!doctype html>
<html lang="pt">

<head>

<!-- Simple Page Needs
================================================== -->
<title>H2E: <?php echo $volvinda; ?></title>
<meta charset="UTF-8">
<meta name="author" content="Help2Everyone">
<!--
<meta name="description" content="Unicat project">-->
<link rel="icon" href="./logo.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/bootstrap.css"/>
<link rel="stylesheet" href="css/reset.css"/>
<link rel="stylesheet" href="cubeportfolio/css/cubeportfolio.min.css"/>
<link rel="stylesheet" href="css/owl.theme.css"/>
<link rel="stylesheet" href="css/owl.carousel.css"/>
<link rel="stylesheet" href="css/style.css"/>
<link rel="stylesheet" href="css/colors/color.css"/>


<!-- Google Web fonts
================================================== -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">

<!-- Font Icons
================================================== -->
<link rel="stylesheet" href="icon-fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="icon-fonts/web-design/flaticon.css" />

<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


</head>
<body>

  <?php
      $result=mysqli_query($conn,"select * from tblvoluntario where Utilizador='".$volvinda."'");
      $entrada=mysqli_fetch_array($result);
      $identidade=htmlspecialchars($entrada['Id']);
      $foto=htmlspecialchars($entrada['Foto']);
			$utilizador1=htmlspecialchars($entrada['Utilizador']);
      $nome=htmlspecialchars($entrada['Nome']);
      $apelido=htmlspecialchars($entrada['Apelido']);
			$email=htmlspecialchars($entrada['Email']);
			$telem=htmlspecialchars($entrada['Telemovel']);
			$morada=htmlspecialchars($entrada['Morada']);
			$codpostal=htmlspecialchars($entrada['CodPostal']);
			$distrito=htmlspecialchars($entrada['Distrito']);
			$concelho=htmlspecialchars($entrada['Concelho']);
      $profissao=htmlspecialchars($entrada['Profissao']);
			$freguesia=htmlspecialchars($entrada['Freguesia']);
      $aniversario=htmlspecialchars($entrada['DataNasc']);
			$habilitacoes=htmlspecialchars($entrada['Habilitacoes']);
      $pais=htmlspecialchars($entrada['Pais']);
      $sitprof=htmlspecialchars($entrada['SituacaoProfissional']);
      $face=htmlspecialchars($entrada['Facebook']);
      $twt=htmlspecialchars($entrada['Twitter']);
      $insta=htmlspecialchars($entrada['Instagram']);
      $info=htmlspecialchars($entrada['Info']);
			$datareg=htmlspecialchars($entrada['Registo']);
			$Problema=htmlspecialchars($entrada['Problema']);

			if($foto=='userimg.png'){
				$escolherfoto=true;
			}else{
				$escolherfoto=false;
			}

			if($Problema==0){
				$verified=null;
			}else{
				$verified="<span title='Voluntário com precedentes' style='color:red;'><i class='fa fa-times-circle'></i></span>";
			}

      $ts1 = strtotime($aniversario);
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
      $nascimento=$dia." de ".$mes." de ".$ano;

			if(empty($info) && $falso==0){
				echo "<div class='alert alert-warning' role='alert'>
  							Precisa de Atualizar os seus dados!!!
								</div>";
			}
  ?>

<!-- Wrapper -->
<div class="wrapper top_60 container">
<div class="row">

	<?php

	if($logtype=="Organizacao"){
		$selectvalor=mysqli_query($conn,"select * from tblorganizacao where Nome='".$logado."'");
		$convertvalor=mysqli_fetch_array($selectvalor);
		$IdOrg=htmlspecialchars($convertvalor['Id']);
		$Aprovacao=htmlspecialchars($convertvalor['Aprovada']);

		$selectvalues=mysqli_query($conn,"select Id from tblvolrating where IdVoluntario=".$identidade." && IdOrganizacao='".$IdOrg."'");
		$convertvalues=mysqli_fetch_array($selectvalues);
		$IdOrg=htmlspecialchars($convertvalues['Id']);

		if($IdOrg==null && $Aprovacao!=0){
			$avaluate="title='avaliar o Voluntário!'";
		}else if($Aprovacao==0){
			$avaluate="disabled title='Organização não aprovada!'";
		}else{
			$avaluate="disabled title='Já avaliou o Voluntário!'";
		}
	}else{
		$avaluate="disabled title='Precisa de ser uma Organizacao para avaliar um voluntário!'";
	}

	$rat=0;
	$media=0;
	$stars5=0;
	$stars4=0;
	$stars3=0;
	$stars2=0;
	$stars1=0;

	$starsbd=mysqli_query($conn,"select Id from tblvolrating where IdVoluntario='".$identidade."'");

		$turn=0;
		$form=array();
		while ($ent=mysqli_fetch_array($starsbd)) {

			$form[$turn]=$ent[0];
			$turn++;
		}
		$tambd=count($form);
		if(!empty($tambd)){
		for($i=0;$i<$tambd;$i++){
			$searchbd=mysqli_query($conn,"select Stars from tblvolrating where Id='".$form[$i]."'");
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

<!-- Profile Section
================================================== -->
<div class="col-lg-3 col-md-4">
    <div class="profile">
        <div class="profile-name">
						<a href="./../index.php" title="Ir para Home"><i class="fa fa-chevron-left"></i></a>
            <span class="name"><?php echo $identidade."-".$utilizador1." ".$verified; ?></span><br>
            <span class="job"><?php echo $pais; ?> - Voluntario</span>
        </div>
        <figure class="profile-image">
            <img src=<?php echo "./../Fotos/FotosVol/".$foto; ?> alt="">
        </figure>
        <ul class="profile-information">
            <li></li>
            <li><p><span>Nome: </span><?php echo $nome." ".$apelido; ?></p></li>
            <li><p><span>País: </span><?php echo $pais; ?></p></li>
            <li><p><span>Aniversário: </span><?php echo $nascimento; ?></p></li>
            <li><p><span>Profissao: </span><?php echo $profissao; ?></p></li>
            <li><p><span>Email: </span><?php echo $email; ?></p></li>
            <li><p><span>Situação: </span><?php echo $sitprof; ?></p></li>
						<li><p><span>Avaliação: </span>
							<?php
							if($media<1){
								echo "<i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i>";
							}else if($media>=1 && $media<2){
								echo "<i class='fa fa-star'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i>";
							}else if($media>=2 && $media<3){
								echo "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i>";
							}else if($media>=3 && $media<4){
								echo "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star-o'></i><i class='fa fa-star-o'></i>";
							}else if($media>=4 && $media<5){
								echo "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star-o'></i>";
							}else if($media==5){
								echo "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
							}
							echo " (".$tambd." avaliações)";
							?>
						</p></li>
        </ul>
				<?php
				$helps=0;
				$query=mysqli_query($conn,"select IdEvento from tblvolevento where IdVoluntario=".$identidade);
				$vol=0;
				$inf=array();
				while ($segway=mysqli_fetch_array($query)) {

					$inf[$vol]=$segway[0];
					$vol++;
				}
				$ttevento=count($inf);
				for($v=0;$v<$ttevento;$v++){
					$querys=mysqli_query($conn,"select Quant_Helps from tblevento where Id=".$inf[$v]);
					$rows=mysqli_fetch_array($querys);
					$Helps_Ganhos=htmlspecialchars($rows['Quant_Helps']);

					$helps=$helps+$Helps_Ganhos;


				}
				if($helps<1000 && $helps>=0){
					$nivel=0;
					$lar="0%";
				}else if($helps>=1000 && $helps<2000){
					$nivel="1";
					$lar="20%";
				}else if($helps>=2000 && $helps<3000){
					$nivel=2;
					$lar="40%";
				}else if($helps>=3000 && $helps<4000){
					$nivel=3;
					$lar="60%";
				}else if($helps>=4000 && $helps<5000){
					$nivel=4;
					$lar="80%";
				}else if($helps>=5000){
					$nivel="Max";
					$lar="100%";
				}
				?>
				<div class="col-md-11" style="margin-left:10px;margin-top:-20px;">
					<span>Nível da conta (Helps):</span>
					<div class="progress" style="margin-top:5px;">
					  <div class="progress-bar" role="progressbar" style="width: <?php echo $lar; ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $nivel; ?></div>
					</div>
				</div>
        <div class="col-md-12" style="margin-top:-10px;">
            <button <?php echo $avaluate; ?> class="site-btn icon" data-toggle='modal' data-target='#AvaliarModal'>Avaliar Voluntáro <i class="fa fa-star"></i></button>
        </div>
    </div>
</div>

<!-- Page Tab Container Div -->
<div id="ajax-tab-container" class="col-lg-9 col-md-8 tab-container">

	<!-- Avaliar -->
	<div class="modal fade" id="AvaliarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Avaliar <?php echo $volvinda; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="./index.php" method="POST">
			<div class="modal-body">
				<div class="row" style="">
					<div class="col-md-12" style=''>
							<a href="./index.php?rating=5" class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
						</div>
						<div class="col-md-12" style="padding-top:5px;">
							<a href="./index.php?rating=4" class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
						</div>
						<div class="col-md-12" style="padding-top:5px;">
							<a href="./index.php?rating=3" class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
						</div>
						<div class="col-md-12" style="padding-top:5px;">
							<a href="./index.php?rating=2" class='btn btn-info' style='padding-right:5px;padding-left:5px;color:white;'><i class='fa fa-check-square-o'></i></a>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
						</div>
						<div class="col-md-12" style="padding-top:5px;">
							<a href="./index.php?rating=1" class='btn btn-info' style="padding-right:5px;padding-left:5px;color:white;"><i class='fa fa-check-square-o'></i></a>
							<i class="fa fa-star fa-2x" style='color:gold;padding-left:5px;'></i>
						</div>
			</div>
			</div>
		</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Sair</button>
			</div>
		</div>
	</div>
</div>
<!-- End Avaliar -->


<!-- Header
================================================== -->
<?php
$tab=null;
	if($logado!=$utilizador){
		$tab="<div class='search_button'><a href='#' data-toggle='modal' data-target='#ReportModal'><i class='fa fa-exclamation-triangle'></i></a></div>";
	}else{
		$tab=null;
	}
?>
<div class="row">
    <header class="col-md-12">
        <nav>
            <div class="row">
                <!-- navigation bar -->
                <div class="col-md-8 col-sm-8 col-xs-4">
                    <ul class="tabs">
                        <li class="tab">
                            <a class="home-btn" href="#home"><i class="fa fa-user" aria-hidden="true"></i></a>
                        </li>
												<?php if($falso==1){$property="hidden";$property2="style='display:none;'";}else{$property="";$property2="";} ?>
                        <li class="tab"><a href="#resume">SOBRE MIM</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#portfolio">PORTFOLIO</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#blog">BLOG</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#contact">CONTACT</a></li>
												<li class="tab"	<?php echo $property2; echo $property; ?>><a href="#compromisso">COMPROMISSOS</a></li>
                        <li class="tab"	<?php echo $property2; echo $property; ?>><a href="#informacao">INFORMAÇÕES</a></li>
												<?php echo $tab; ?>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-8 dynamic">
                    <a href="mailto:<?php echo $email; ?>" class="pull-right site-btn icon hidden-xs">Contacte-me <i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                    <div class="hamburger pull-right hidden-lg hidden-md"><i class="fa fa-bars" aria-hidden="true"></i></div>
                    <div class="hidden-md social-icons pull-right">
                        <a class="fb" target="_blank" href=<?php echo $face; ?>><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a class="tw" target="_blank" href=<?php echo $twt; ?>><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a class="ins" target="_blank" href=<?php echo $insta; ?>><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

		<!-- Reportar -->
		<div class="modal fade" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Reportar <?php echo $volvinda; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="./index.php" method="POST">
				<div class="modal-body">
					<div class="row" style="padding-top:15px;padding-bottom:5px;">
						<div class="col-md-6">
							<input class="container form-control" maxlength="100" name="Nome_ocorrencia" placeholder="Nome">
						</div>
						<div class="col-md-6">
							<input class="container form-control" maxlength="300" name="Email_ocorrencia" placeholder="Email">
						</div>
						<div class="col-md-12" style="padding-top:15px;">
							<textarea style="resize:none" rows="6" maxlength="1000" name="Descricao_ocorrencia" class="container form-control" placeholder="Descreva a situação"></textarea>
						</div>
				</div>
					<p style="padding-bottom:10px; font-size: large;">Por favor escolha a razão/problema da situação</p>
					<button type="submit" name="btn1" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Publicação de conteúdo inapropriado ou ofensivo</button>
					<button type="submit" name="btn2" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Spam, perturbação ou assédio</button>
					<button type="submit" name="btn3" class="btn btn-secondary btn-lg btn-block text-left" style="font-size: medium;">Roubo, burla, fraude, ou outra atividade</button>
				</div>
			</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Sair</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Reportar -->



    <!-- Page Content
    ================================================== -->
    <div class="col-md-12">
        <div id="content" class="panel-container">

            <!-- Home Page
            ================================================== -->
            <div id="home">
                <!-- Text Section -->
                <div class="row">
                    <section class="about-me line col-md-12 padding_30 padbot_45">
                    <div class="section-title"><span></span><h2>Informação</h2></div>
                    <p class="top_30"><?php echo $info; ?></p>
                </section>
                </div>
                <!-- My Services Section -->
                <div class="row">
                    <section class="services line graybg col-md-12 padding_50 padbot_50">
                    <div class="section-title bottom_45"><span></span><h2>Áreas de Interesse principais</h2></div>
                    <div class="row">
											<?php

											$checn=mysqli_query($conn,"Select Nome from tblskills where IdVoluntario=".$identidade);
											$n=0;
											if(!empty($checn)){
											while ($segmento=mysqli_fetch_array($checn)) {

												$checks[$n]=$segmento[0];
												$n++;
											}
										}
											if(!empty($checks)){
											$op=count($checks);
											$external=false;
											for($a=0;$a<$op;$a++){
													if($checks[$a]=='Ambiente'){
														$var="fa fa-leaf";
														$var1="Várias atividades a favor do ambiente";
													}
													else if($checks[$a]=='Cidadania e Direitos'){
														$var="fa fa-users";
														$var1="Várias atividades a favor da Cidadania e do Direito";
													}
													else if($checks[$a]=='Cultura e Artes'){
														$var="fa fa-film";
														$var1="Várias atividades a favor da Cultura e das Artes";
													}
													else if($checks[$a]=='Desporto e Lazer'){
														$var="fa fa-car";
														$var1="Várias atividades a favor do Desporto e do Lazer";
													}
													else if($checks[$a]=='Educação'){
														$var="fa fa-graduation-cap";
														$var1="Várias atividades a favor da Educação";
													}
													else if($checks[$a]=='Novas Tecnologias'){
														$var="fa fa-mobile";
														$var1="Várias atividades a favor das TIC";
													}
													else if($checks[$a]=='Saúde'){
														$var="fa fa-blind";
														$var1="Várias atividades a favor da Saúde";
													}
													else if($checks[$a]=='Solidariedade Social'){
														$var="fa fa-handshake-o";
														$var1="Várias atividades a favor da Solidariedade Social";
													}else {
														$external=true;
													}
													if($external==false){
														echo "<div class='col-md-3 col-sm-6 col-xs-12' style='padding-bottom:20px;'>
																		 <div class='service'>
																				 <div class='icon'>
																						 <i class='".$var."' style='height: 100%;display: flex;align-items: center;justify-content: center;'></i>
																				 </div>
																						 <span class='title'>".$checks[$a]."</span>
																						 <p class='little-text'>".$var1."</p>
																		 </div>
																	</div>";
												}else{
													$external=false;
												}
											}
										}else{
											echo "<div class='col-md-3 col-sm-6 col-xs-12'>
															 <div class='service'>
																	 <div class='icon'>
																	 </div>
																			 <p class='little-text'>Sem interesses selecionados</p>
															 </div>
														</div>";
										}

											 ?>
                        <!--<div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="service">
                                <div class="icon">
                                    <i class="flaticon-schedule"></i>
                                </div>
                                <span class="title">Fast Delivery</span>
                                <p class="little-text">I deliver your business as fast as possible.</p>
                            </div>
                        </div>-->
                    </div>
                </section>
                </div>
                <!-- Skills Section -->
            </div>

            <!-- Resume Page
            ================================================== -->
            <div id="resume">
                <!-- Resume Section -->

								<?php
								$cmd=mysqli_query($conn,"select IdEvento from tblvolevento where IdVoluntario=".$identidade);
								$a=0;
								$val=array();
								if(!empty($cmd)){
								while ($use=mysqli_fetch_array($cmd)) {

									$val[$a]=$use[0];
									$a++;
								}
								$tamanho=count($val);
							}


								?>

                <div class="row">
                    <section class="education">
                    <div class="section-title top_30"><span></span><h2>Histórico</h2></div>
                        <div class="row">
                            <!-- Working History -->
                            <div class="working-history col-md-6 padding_15 padbot_30">
                                <ul class="timeline col-md-12 top_30">
                                    <li><i class="fa fa-suitcase" aria-hidden="true"></i><h2 class="timeline-title">Eventos</h2></li>
                                    <?php
																		$notreg=true;
																		if(!empty($tamanho)){
																		for($i=0;$i<$tamanho;$i++){
																			$notreg=false;
																			$selecionar=mysqli_query($conn,"select * from tblevento where Id=".$val[$i]);
																			if(!empty($selecionar)){
																			$row=mysqli_fetch_array($selecionar);
																			$IdEvento=htmlspecialchars($row['Id']);
																			$NomeEvento=htmlspecialchars($row['Nome']);
																			$FotoLocal=htmlspecialchars($row['FotoLocal']);
																			$DescEvento=htmlspecialchars($row['Descricao']);
																			$BreveDescEvento=htmlspecialchars($row['BreveDesc']);
																			$DataInicioEvento=htmlspecialchars($row['DataInicio']);
																			$Dur=htmlspecialchars($row['Duracao']);
																			$Help=htmlspecialchars($row['Quant_Helps']);

																			$ts2 = strtotime($DataInicioEvento);
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

																			echo "<li><p style='font-weight:bold;font-size: 16px;'>".$NomeEvento."</p>
	                                        <span>".$DataInicioEvento."</span>
	                                        <p class='little-text'>".$BreveDescEvento."</p>
	                                    </li>";

																			      $tempo = strtotime($datareg);
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
																			      $registanco=$day." de ".$month." de ".$year;
																						$notreg=false;
																		}else{
																			$notreg=true;
																		}
																	}
																}
																		?>
                                </ul>
                            </div>
                            <!-- Education History -->
                            <div class="education-history col-md-6 padding_15 padbot_30">
                                <ul class="timeline col-md-12 top_30">
                                    <li><i class="fa fa-road" aria-hidden="true"></i><h2 class="timeline-title">Sobre mim</h2></li>
																		<?php

																		if($notreg==false){
																			echo "
																			<li><p style='font-weight:bold;font-size: 16px;'>".$habilitacoes."</p>
	                                        <span>Nasceu: ".$nascimento."</span>
	                                    </li>
	                                    <li><p style='font-weight:bold;font-size: 16px;'>Localizar-me</p>
	                                        <span>".$distrito." , ".$concelho."</span>
	                                    </li>
	                                    <li><p style='font-weight:bold;font-size: 16px;'>Registo</p>
	                                        <span>Registou-se a: ".$registanco."</span>
	                                    </li> ";
																		}

																		?>

                                </ul>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!-- Portfolio Page
            ================================================== -->
            <div id="portfolio" class="row bottom_45">
                <section class="col-md-12">
                    <div class="col-md-12 content-header bottom_15">
                        <div class="section-title top_30 bottom_30"><span></span><h2>Portfolio</h2></div>
                        <div id="filters-container">
                            <!-- '*' means shows all item elements -->
                            <div data-filter="*" class="cbp-filter-item cbp-filter-item-active">All</div>
                            <div data-filter=".webdesign" class="cbp-filter-item">Web Design</div>
                            <div data-filter=".motion" class="cbp-filter-item">Motion Graphic</div>
                            <div data-filter=".illustration" class="cbp-filter-item">Illustration</div>
                            <div data-filter=".photography" class="cbp-filter-item">Photography</div>
                        </div>
                    </div>
                    <div id="grid-container" class="top_60">
                        <!-- a work -->
                        <div class="cbp-item webdesign">
                            <a href="portfolio-detail/work-01.html" class=" cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-01.jpg" alt="" >
                                    <figcaption>
                                        <span class="title">Babel Admin</span><br/>
                                        <span class="info">An admin template design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a video work -->
                        <div class="cbp-item cbp-lightbox motion">
                            <a href="http://www.youtube.com/watch?v=bpOSxM0rNPM&amp;rel=0&amp;autoplay=1" class="cbp-lightbox">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-02.jpg" alt="" >
                                    <figcaption>
                                        <span class="title">George Motion</span><br/>
                                        <span class="info">An motion graphic design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a image work -->
                        <div class="cbp-item cbp-lightbox photography">
                            <a href="images/works/work-06.jpg" class="cbp-lightbox">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-06.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Amazon Travel</span><br/>
                                        <span class="info">Nature photography work.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a work -->
                        <div class="cbp-item webdesign">
                            <a href="portfolio-detail/work-02.html" class="cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-03.jpg" alt="">
                                    <figcaption>
                                        <span class="title">My Workspace</span><br/>
                                        <span class="info">My current workspace design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a video work -->
                        <div class="cbp-item motion">
                            <a href="https://vimeo.com/199074744" class="cbp-lightbox">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-04.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Recoba Template</span><br/>
                                        <span class="info">Html template design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a work -->
                        <div class="cbp-item webdesign">
                            <a href="portfolio-detail/work-01.html" class="cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-05.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Doddy App</span><br/>
                                        <span class="info">Mobile app ui kit design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a work -->
                        <div class="cbp-item illustration">
                            <a href="portfolio-detail/work-01.html" class="cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-07.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Bob Stayler </span><br/>
                                        <span class="info">Illustration characher design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a work -->
                        <div class="cbp-item illustration">
                            <a href="portfolio-detail/work-01.html" class="cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-08.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Exemag Wordpress Theme</span><br/>
                                        <span class="info">Multiconcept Blog Theme.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <!-- a work -->
                        <div class="cbp-item illustration">
                            <a href="portfolio-detail/work-01.html" class="cbp-singlePage">
                                <figure>
                                    <div class="icon">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </div>
                                    <img src="images/works/work-09.jpg" alt="">
                                    <figcaption>
                                        <span class="title">Babel Admin Html Code</span><br/>
                                        <span class="info">An admin template design.</span>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <!-- load more button -->
                    <div id="js-loadMore-agency" class="cbp-l-loadMore-button top_30">
                        <a href="load-more/portfolio.html" class="cbp-l-loadMore-link site-btn" rel="nofollow">
                            <span class="cbp-l-loadMore-defaultText">Load More (<span class="cbp-l-loadMore-loadItems">3</span>)</span>
                            <span class="cbp-l-loadMore-loadingText">Loading...</span>
                            <span class="cbp-l-loadMore-noMoreLoading">No More Works</span>
                        </a>
                    </div>
                </section>
            </div>

            <!-- Blog Page
            ================================================== -->
            <div id="blog">
                <div class="row">
                    <section class="blog col-md-12 bottom_30">
                        <div class="col-md-12 content-header">
                            <div class="section-title top_30 bottom_15"><span></span><h2>Blog Posts</h2></div>
                        </div>
                        <div id="grid-blog" class="row">
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-1.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-6.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">General</span>
                                        <h2 class="title">See my current workspace</h2>
                                        <p class="little-text">The first thing to remember about success is that it is a process.</p>
                                        <span class="date">8 Nov 17</span>
                                    </div>
                                </a>
                            </div>
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-video-version.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-2.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">Web Design</span>
                                        <h2 class="title">How to become a web designer?</h2>
                                        <p class="little-text">He must have tried it a hundred times, shut his eyes so that he wouldn't have to look at the floundering.</p>
                                        <span class="date">27 Oct 17</span>
                                    </div>
                                </a>
                            </div>
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-music-version.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-3.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">User İnterface</span>
                                        <h2 class="title">Why is it better to work nights?</h2>
                                        <p class="little-text">Legs, and only stopped when he began to feel a mild, dull pain there that he had never felt.</p>
                                        <span class="date">19 Oct 17</span>
                                    </div>
                                </a>
                            </div>
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-video-version.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-4.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">Photography</span>
                                        <h2 class="title">Can you work everywhere?</h2>
                                        <p class="little-text">Drops of rain could be heard hitting the pane, which made him feel quite sad..</p>
                                        <span class="date">28 Sep 17</span>
                                    </div>
                                </a>
                            </div>
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-1.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-5.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">Other</span>
                                        <h2 class="title">How to connect your imac or macBook</h2>
                                        <p class="little-text">However hard he threw himself onto his right, he always rolled back to where he was.</p>
                                        <span class="date">19 Agu 17</span>
                                    </div>
                                </a>
                            </div>
                            <!-- a blog -->
                            <div class="cbp-item">
                                <a href="blog-posts/blog-1.html" class="blog-box">
                                    <div class="blog-img">
                                        <img src="images/blogs/blog-6.jpg" alt="">
                                    </div>
                                    <div class="blog-box-info">
                                        <span class="category">Work Space</span>
                                        <h2 class="title">I'm starting a new project</h2>
                                        <p class="little-text">The first thing to remember about success is that it is a process...</p>
                                        <span class="date">1 Jul 17</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- load more button -->
                        <div id="load-posts" class="cbp-l-loadMore-button top_60">
                            <a href="load-more/blog-posts.html" class="cbp-l-loadMore-link site-btn" rel="nofollow">
                                <span class="cbp-l-loadMore-defaultText">Load More (<span class="cbp-l-loadMore-loadItems">3</span>)</span>
                                <span class="cbp-l-loadMore-loadingText">Loading...</span>
                                <span class="cbp-l-loadMore-noMoreLoading">No More Works</span>
                            </a>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Contact Page
            ================================================== -->
            <div id="contact">
                <div class="row">
                    <!-- Contact Form -->
                    <section class="contact-form col-md-6 padding_30 padbot_45">
                        <div class="section-title top_15 bottom_30"><span></span><h2>Contact Form</h2></div>
                        <form class="site-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="site-input" placeholder="Name">
                                </div>
                                <div class="col-md-6">
                                    <input class="site-input" placeholder="E-mail">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="site-area" placeholder="Message"></textarea>
                                </div>
                                <div class="col-md-12 top_15 bottom_30">
                                    <button class="site-btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!-- Contact Informations -->
                    <section class="contact-info col-md-6 padding_30 padbot_45">
                        <div class="section-title top_15 bottom_30"><span></span><h2>Contact Informations</h2></div>
                        <ul>
                            <li><span>Address:</span> 107727 Santa Monica Boulevard Los Angeles</li>
                            <li><span>Phone:</span> +38 012-3456-7890</li>
                            <li><span>Job:</span> Freelancer</li>
                            <li><span>E-mail:</span> chris@domain.com</li>
                            <li><span>Skype:</span> chrisjohnson85</li>
                            <li>
                                <div class="social-icons top_15">
                                    <a class="fb" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a class="tw" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a class="ins" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    <a class="dr" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <!-- Contact Map -->
                    <section class="contact-map col-md-12 top_15 bottom_15">
                        <div class="section-title bottom_30"><span></span><h2>Contact Map.</h2></div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24396.455763004884!2d-115.13108354428735!3d36.18912977254862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos+Angeles%2C+Kaliforniya%2C+Birle%C5%9Fik+Devletler!5e0!3m2!1str!2str!4v1509525039851" height="350" style="border:0" allowfullscreen></iframe>
                    </section>
                </div>
            </div>

						<!-- Compromissos -->
						<div id="compromisso">
  						<div class="section-title top_15"><span></span><h2>Compromissos</h2></div>
							<p class="bottom_15">Aqui estão presentes todos os eventos a que aderiu</p>

							<?php
							$cmd=mysqli_query($conn,"select IdEvento from tblvolevento where IdVoluntario=".$identidade);
							$a=0;
							$val=array();
							if(!empty($cmd)){
								while ($use=mysqli_fetch_array($cmd)) {
									$val[$a]=$use[0];
									$a++;

								}
								$eventos=count($val);
							}
							if(!empty($eventos)){
								for($i=0;$i<$eventos;$i++){
									$select=mysqli_query($conn,"select * from tblevento where Id='".$val[$i]."' && Inativo=0");
									$row=mysqli_fetch_array($select);
									$IdEvento=htmlspecialchars($row['Id']);
									$NomeEvento=htmlspecialchars($row['Nome']);
									$BreveDescEvento=htmlspecialchars($row['BreveDesc']);
									$DataInicioEvento=htmlspecialchars($row['DataInicio']);
									$DataFimEvento=htmlspecialchars($row['DataTermino']);
									$Dur=htmlspecialchars($row['Duracao']);
									$Help=htmlspecialchars($row['Quant_Helps']);

									$ts2 = strtotime($DataInicioEvento);
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

												$tempo = strtotime($DataFimEvento);
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

									echo "<div class='alert alert-success' role='alert'>
									<div class='row'>
										<div class='col-md-8'>
											<p style='font-size:100%;vertical-align: bottom;'><strong><a href='./../courses.php?abrir=".$IdEvento."'>".$NomeEvento."</a></strong> - ".$DataInicioEvento." <strong>até</strong> ".$DataFimEvento."</p>
										</div>
										<div class='col-md-2'>
											<p style='font-size:100%;'><strong>Duração: </strong>".$Dur."</p>
											<p style='font-size:100%;'><strong>Helps: </strong>".$Help."</p>
										</div>
										<div class='col-md-2'>
										<button type='button' class='close' title='Limpar alerta' data-dismiss='alert' aria-label='Close'><i class='fa fa-times'></i></button>
										</div>
									</div>
									</div>";
							}
						}
							 ?>


						</div>

            <!-- Informação -->
            <div id="informacao">
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
							<?php if($property!=null){echo "<p>Não é possível aceder à página, <a href='index.php'>retroceder</a> para segurança.</p>";} ?>
              <div class="row" <?php if($property!=null){echo "disabled hidden";} ?>>
                <section class="contact-form col-md-6 padding_30 padbot_45">
                    <div class="section-title top_15 bottom_10"><span></span><h2>Informações Pessoais <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
										<p class="bottom_15">Campos obrigatórios marcados com *</p>
                    <form class="site-form" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data">
                        <div class="row">
													<div class="col-md-12" style="padding-bottom: 10px;">
														<label>Foto<?php if($escolherfoto==true){echo "*";} ?> </label>
														<input type="file" id="ficheiroup" name="ficheiroup" class="btn btn-primary" accept="image/png, image/jpeg" style="padding-top: 5px; max-width:100%;" <?php if($escolherfoto==true){echo "required";} ?>>
													</div>
                            <div class="col-md-6">
															<label>Nome* </label>
                                <input class="site-input" readonly value="<?php if(isset($nome)){echo $nome;} ?>" maxlength="50" type="text" name="nome" placeholder="Insira o Nome" required>
                            </div>
                            <div class="col-md-6">
															<label>Apelido* </label>
                                <input class="site-input" readonly value="<?php if(isset($apelido)){echo $apelido;} ?>" maxlength="50" type="text"  name="apelido" placeholder="Insira o Apelido" required>
                            </div>
                            <div class="col-md-12">
															<label>Email* </label>
                                <input class="site-input" readonly value="<?php if(isset($email)){echo $email;} ?>" maxlength="100" type="text" name="email" placeholder="Insira o Email" required></input>
                            </div>
														<div class="col-md-6">
															<label>Telemóvel* </label>
                                <input class="site-input" value="<?php if(isset($telem)){echo $telem;} ?>" minlength="9" maxlength="12" type="text" name="tele" placeholder="Insira o nº de Telemóvel" required>
                            </div>
                            <div class="col-md-6">
															<label>Utilizador* </label>
                                <input class="site-input" readonly value="<?php if(isset($utilizador1)){echo $utilizador1;} ?>" maxlength="100" type="text"  name="user" placeholder="Insira o Utilizador" required>
                            </div>
                            <div class="col-md-12">
															<label>Data de Nascimento* </label>
                                <input class="site-input" value="<?php if(isset($aniversario)){echo $aniversario;} ?>" type="date" name="data_nasc" placeholder="Insira a sua data de aniversário" required></input>
                            </div>
														<div class="col-md-6">
															<label>País* </label>
																<input class="site-input" value="<?php if(isset($pais)){echo $pais;} ?>" maxlength="70" type="text" name="pais" placeholder="Insira o seu País" required>
														</div>
														<div class="col-md-6">
															<label>Código-Postal* </label>
																<input class="site-input" value="<?php if(isset($codpostal)){echo $codpostal;} ?>" title="" maxlength="8" type="text"  name="cod_pos" title="Insira o Código Postal com o formato ****-***" pattern="\d{4}-\d{3}" placeholder="Insira o seu Código-Postal" required>
														</div>
														<div class="col-md-12">
															<label>Morada* </label>
																<input class="site-input" value="<?php if(isset($morada)){echo $morada;} ?>" maxlength="200" type="text" name="morada" placeholder="Insira a sua Morada" required></input>
														</div>
														<div class="col-md-6">
															<label>Distrito* </label>
																<input class="site-input" value="<?php if(isset($distrito)){echo $distrito;} ?>" maxlength="50" type="text" name="distrito" placeholder="Insira o seu Distrito" required>
														</div>
														<div class="col-md-6">
															<label>Concelho* </label>
																<input class="site-input" value="<?php if(isset($concelho)){echo $concelho;} ?>" maxlength="50" type="text"  name="concelho" placeholder="Insira o seu Concelho" required>
														</div>
														<div class="col-md-6">
															<label>Freguesia* </label>
																<input class="site-input" value="<?php if(isset($freguesia)){echo $freguesia;} ?>" maxlength="50" type="text"  name="freguesia" placeholder="Insira a sua Freguesia" required>
														</div>
														<div class="col-md-12">
															<label>Habilitações* </label>
																<select class="custom-select custom-select-sm site-input" name="habilitacoes" required>>
																  <option <?php if(isset($habilitacoes)){echo "value=".$habilitacoes;}else{} ?> selected><?php if(isset($habilitacoes)){echo $habilitacoes;}else{echo "Escolha as suas Habilitações";} ?></option>
																  <option value="Ensino Básico - 1º ciclo">Ensino Básico - 1º ciclo</option>
																  <option value="Ensino Básico - 2º ciclo">Ensino Básico - 2º ciclo</option>
																  <option value="Ensino Básico - 2º ciclo Vocacional">Ensino Básico - 2º ciclo Vocacional</option>
																	<option value="Ensino Básico - 3º ciclo">Ensino Básico - 3º ciclo</option>
																	<option value="Ensino Básico - 3º ciclo Vocacional">Ensino Básico - 3º ciclo Vocacional</option>
																	<option value="Ensino Secundário - Científicos">Ensino Secundário - Científicos</option>
																	<option value="Ensino Secundário - Humanidades">Ensino Secundário - Humanidades</option>
																	<option value="Ensino Secundário - Cursos Profissionais">Ensino Secundário - Cursos Profissionais</option>
																	<option value="Ensino Secundário - Cursos Artísticos Especializados">Ensino Secundário - Cursos Artísticos Especializados</option>
																	<option value="Ensino Secundário - Ensino Recorrente">Ensino Secundário - Ensino Recorrente</option>
																	<option value="Ensino Secundário - Cursos Vocacionais">Ensino Secundário - Cursos Vocacionais</option>
																	<option value="Ensino Superior Universitário - Licenciaturas">Ensino Superior Universitário - Licenciaturas</option>
																	<option value="Ensino Superior Universitário - Mestrados">Ensino Superior Universitário - Mestrados</option>
																	<option value="Ensino Superior Universitário - Mestrados Integrados">Ensino Superior Universitário - Mestrados Integrados</option>
																	<option value="Ensino Superior Universitário - Doutoramentos">Ensino Superior Universitário - Doutoramentos</option>
																	<option value="Ensino Superior Politécnico - Cursos Superiores Técnicos Profissionais(CTESP)">Ensino Superior Politécnico - Cursos Superiores Técnicos Profissionais(CTESP)</option>
																	<option value="Ensino Superior Politécnico - Licenciaturas">Ensino Superior Politécnico - Licenciaturas</option>
																	<option value="Ensino Superior Politécnico - Mestrado">Ensino Superior Politécnico - Mestrado</option>
																</select>
														</div>
														<div class="col-md-12">
															<label>Situacão Profissional* </label>
																<select class="custom-select custom-select-sm site-input" name="sit_profissional" required>>
																  <option<?php if(isset($sitprof)){echo "value=".$sitprof;}else{} ?> selected><?php if(isset($sitprof)){echo $sitprof;}else{echo "Escolha a sua situação profissional";} ?></option>
																  <option value="Empregado">Empregado</option>
																  <option value="Desempregado">Desempregado</option>
																</select>
														</div>
														<div class="col-md-12">
															<label>Profissao* </label>
																<select class="custom-select custom-select-sm site-input" name="profissao" required>>
																	<option <?php if(isset($profissao)){echo "value=".$profissao;}else{} ?> selected><?php if(isset($profissao)){echo $profissao;}else{echo "Escolha a sua profissão";} ?></option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Administração, Economia e Negócios</option>
																	<option value="Administração de Empresas">- Administração de Empresas</option>
																	<option value="Administração Pública">- Administração Pública</option>
																	<option value="Agronegócios">- Agronegócios</option>
																	<option value="Biblioteconomia">- Biblioteconomia</option>
																	<option value="Ciências Atuárias">- Ciências Atuárias</option>
																	<option value="Contabilista">- Contabilista</option>
																	<option value="Comércio Exterior">- Comércio Exterior</option>
																	<option value="Economia">- Economia</option>
																	<option value="Gestão Ambiental">- Gestão Ambiental</option>
																	<option value="Gestão Comercial">- Gestão Comercial</option>
																	<option value="Gestão de Recursos Humanos">- Gestão de Recursos Humanos</option>
																	<option value="Gestão Financeira">- Gestão Financeira</option>
																	<option value="Logística">- Logística</option>
																	<option value="Negócios Imobiliários">- Negócios Imobiliários</option>
																	<option value="Secretariado">- Secretariado</option>
																	<option value="Relações Internacionais">- Relações Internacionais</option>
																	<option value="Segurança no Trabalho">- Segurança no Trabalho</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Ciências Sociais</option>
																	<option value="Antropologia">- Antropologia</option>
																	<option value="Ciências Políticas">- Ciências Políticas</option>
																	<option value="Ciências Sociais">- Ciências Sociais</option>
																	<option value="Filosofia">- Filosofia</option>
																	<option value="Serviço Social">- Serviço Social</option>
																	<option value="Teologia">- Teologia</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Comunicação e Mídia</option>
																	<option value="Arquivologia">- Arquivologia</option>
																	<option value="Comunicação Social">- Comunicação Social</option>
																	<option value="Jornalismo">- Jornalismo</option>
																	<option value="Multimédia">- Multimédia</option>
																	<option value="Publicidade e Propaganda">- Publicidade e Propaganda</option>
																	<option value="Rádio e TV">- Rádio e TV</option>
																	<option value="Relações Públicas">- Relações Públicas</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Design e Arte</option>
																	<option value="Artes Cénicas">- Artes Cénicas</option>
																	<option value="Artes Plásticas">- Artes Plásticas</option>
																	<option value="Artes Visuais">- Artes Visuais</option>
																	<option value="Cinema">- Cinema</option>
																	<option value="Dança">- Dança</option>
																	<option value="Desenho Industrial">- Desenho Industrial</option>
																	<option value="Design de Jogos">- Design de Jogos</option>
																	<option value="Design Gráfico">- Design Gráfico</option>
																	<option value="Fotografia">- Fotografia</option>
																	<option value="Moda">- Moda</option>
																	<option value="Música">- Música</option>
																	<option value="Teatro">- Teatro</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Direito</option>
																	<option value="Direito">- Direito</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Educação</option>
																	<option value="Estudante">- Estudante</option>
																	<option value="Ciências Naturais">- Ciências Naturais</option>
																	<option value="Física">- Física</option>
																	<option value="Geografia">- Geografia</option>
																	<option value="Letras">- Letras</option>
																	<option value="Matemática">- Matemática</option>
																	<option value="Pedagogia">- Pedagogia</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Engenharia e Arquitetura</option>
																	<option value="Agronomia">- Agronomia</option>
																	<option value="Arqueologia">- Arqueologia</option>
																	<option value="Arquitetura">- Arquitetura</option>
																	<option value="Astronomia">- Astronomia</option>
																	<option value="Ciências Ambientais">- Ciências Ambientais</option>
																	<option value="Ciências Exatas">- Ciências Exatas</option>
																	<option value="Engenharia Aeronáuticas">- Engenharia Aeronáuticas</option>
																	<option value="Engenharia Aeroespacial">- Engenharia Aeroespacial</option>
																	<option value="Engenharia Agrícola">- Engenharia Agrícola</option>
																	<option value="Engenharia Ambiental">- Engenharia Ambiental</option>
																	<option value="Engenharia Biomédica">- Engenharia Biomédica</option>
																	<option value="Engenharia Civil">- Engenharia Civil</option>
																	<option value="Engenharia de Agricultura">- Engenharia de Agricultura</option>
																	<option value="Engenharia de Alimentos">- Engenharia de Alimentos</option>
																	<option value="Engenharia de Controlo e Automação">- Engenharia de Controlo e Automação</option>
																	<option value="Engenharia de Energia">- Engenharia de Energia</option>
																	<option value="Engenharia de Materiais">- Engenharia de Materiais</option>
																	<option value="Engenharia de Minas">- Engenharia de Minas</option>
																	<option value="Engenharia de Pesca">- Engenharia de Pesca</option>
																	<option value="Engenharia de Petróleo">- Engenharia de Petróleo</option>
																	<option value="Engenharia de Produção">- Engenharia de Produção</option>
																	<option value="Engenharia Elétrica">- Engenharia Elétrica</option>
																	<option value="Engenharia Florestal">- Engenharia Florestal</option>
																	<option value="Engenharia Mecânica">- Engenharia Mecânica</option>
																	<option value="Engenharia Metalúrgica">- Engenharia Metalúrgica</option>
																	<option value="Engenharia Naval">- Engenharia Naval</option>
																	<option value="Engenharia Nuclear">- Engenharia Nuclear</option>
																	<option value="Engenharia Química">- Engenharia Química</option>
																	<option value="Engenharia de Telecomunicações">- Engenharia de Telecomunicações</option>
																	<option value="Geologia">- Geologia</option>
																	<option value="Mecânica Industria">- Mecânica Industrial</option>
																	<option value="Meteorologia">- Meteorologia</option>
																	<option value="Oceanografia">- Oceanografia</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Informação e Tecnologia</option>
																	<option value="Ciências da Computação">- Ciências da Computação</option>
																	<option value="Engenharia da Computação">- Engenharia Informática</option>
																	<option value="Sistemas de Insormação">- Sistemas de Informação</option>
																	<option value="Tecnologias da Informação">- Tecnologias da Informação</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Saúde</option>
																	<option value="Biologia">- Biologia</option>
																	<option value="Biomedicina">- Biomedicina</option>
																	<option value="Biotecnologia">- Biotecnologia</option>
																	<option value="Ciências Biológicas">- Ciências Biológicas</option>
																	<option value="Educação Física">- Educação Física</option>
																	<option value="Enfermagem">- Enfermagem</option>
																	<option value="Estética">- Estética</option>
																	<option value="Farmácia">- Farmácia</option>
																	<option value="Fisioterapia">- Fisioterapia</option>
																	<option value="Gestão Hospitalar 2">- Gestão Hospitalar 2</option>
																	<option value="Medicina">- Medicina</option>
																	<option value="Medicina Veterinária">- Medicina Veterinária</option>
																	<option value="Nutrição">- Nutrição</option>
																	<option value="Odontologia">- Odontologia</option>
																	<option value="Psicologia">- Psicologia</option>
																	<option value="Química">- Química</option>
																	<option value="Radiologia">- Radiologia</option>
																	<option value="Terapia Ocupacional">- Terapia Ocupacional</option>
																	<option value="Zootecnia">- Zootecnia</option>
																	<option disabled label style="font-weight: bolder; color:#0089d9">Turismo e Gastronomia</option>
																	<option value="Gastronomia">- Gastronomia</option>
																	<option value="Hotelaria e Turismo">- Hotelaria e Turismo</option>
																</select>
														</div>
														<div class="col-md-12">
															<label>Facebook </label>
																<input class="site-input" value="<?php if(isset($face)){echo $face;} ?>" maxlength="300" type="text" name="facebook" placeholder="Copie o url da sua página de facebook"></input>
														</div>
														<div class="col-md-12">
															<label>Instagram </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Instagram" placeholder="Copie o url da sua página de Instagram"></input>
														</div>
														<div class="col-md-12">
															<label>Twitter </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Twitter" placeholder="Copie o url da sua página de Twitter"></input>
														</div>
														<div class="col-md-12">
															<label>Informação Adicional* </label>
																<textarea class="site-area" maxlength="1000" type="text" name="info" placeholder="Escreva alguma coisa sobre si!!!" required><?php if(isset($info)){echo $info;} ?></textarea>
														</div>
														<div class="col-md-12">
															<label>Password </label>
																<input class="site-input" type="text"  maxlength="100" minlength=4 name="password" placeholder="Mudar Palavra-Passe">
														</div>
                            <div class="col-md-12 top_15 bottom_30">
                                <button class="site-btn" type="submit" name="updateall">Atualizar dados</button>
                            </div>
                        </div>
                    </form>
                </section>
								<section class="contact-form col-md-6 padding_30 padbot_45">
									<!--<img src="" class="img-thumbnail" id='foto' alt="...">-->
									<div class="section-title top_15 bottom_30"><span></span><h2>Áreas de Interesse</h2></div>
									<form class="site-form" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
											<div class="row">
													<div class="col-md-12">
														<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
															<?php
															$var1=false;
															$var2=false;
															$var3=false;
															$var4=false;
															$var5=false;
															$var6=false;
															$var7=false;
															$var8=false;

															$checn=mysqli_query($conn,"Select Nome from tblskills where IdVoluntario=".$identidade);
															$n=0;
															while ($segmento=mysqli_fetch_array($checn)) {

																$checks[$n]=$segmento[0];
																$n++;
															}
															if(!empty($checks)){
																$op=count($checks);
															for($a=0;$a<$op;$a++){
																	if($checks[$a]=='Ambiente'){
																		$var1=true;
																	}
																	if($checks[$a]=='Cidadania e Direitos'){
																		$var2=true;
																	}
																	if($checks[$a]=='Cultura e Artes'){
																		$var3=true;
																	}
																	if($checks[$a]=='Desporto e Lazer'){
																		$var4=true;
																	}
																	if($checks[$a]=='Educação'){
																		$var5=true;
																	}
																	if($checks[$a]=='Novas Tecnologias'){
																		$var6=true;
																	}
																	if($checks[$a]=='Saúde'){
																		$var7=true;
																	}
																	if($checks[$a]=='Solidariedade Social'){
																		$var8=true;
																	}
																}
															}
															 ?>
														<ul>
																<li><p><span><input <?php if($var1==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Ambiente" name="checkbox[]"> Ambiente</span></p></li>
																<li><p><span><input <?php if($var2==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Cidadania e Direitos" name="checkbox[]"> Cidadania e Direitos</span></p></li>
																<li><p><span><input <?php if($var3==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Cultura e Artes" name="checkbox[]"> Cultura e Artes</span></p></li>
																<li><p><span><input <?php if($var4==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Desporto e Lazer" name="checkbox[]"> Desporto e Lazer</span></p></li>
																<li><p><span><input <?php if($var5==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Educação" name="checkbox[]"> Educação</span></p></li>
																<li><p><span><input <?php if($var6==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Novas Tecnologias" name="checkbox[]"> Novas Tecnologias</span></p></li>
																<li><p><span><input <?php if($var7==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Saúde" name="checkbox[]"> Saúde</span></p></li>
																<li><p><span><input <?php if($var8==true){echo "checked";} ?> class="form-check-input" type="checkbox" value="Solidariedade Social" name="checkbox[]"> Solidariedade Social</span></p></li>
														</ul>
														<div class="col-md-12 top_15 bottom_30">
																<button class="site-btn" type="submit" name="arin">Atualizar dados</button>
														</div>
													</form>
													</div>
											</div>
										</form>
								</section>
            </div>
            </div>

        </div><!-- Content - End -->
     </div> <!-- col-md-12 end -->
</div><!-- row end -->
<script>
function mudaImagem(fileup) {
  var foto = document.getElementById('foto');
  var origem = foto.setAttribute('src', fileup)
	alert(fileup);
}
</script>
<!-- Footer
================================================== -->
<footer>
    <div class="footer col-md-12 top_30 bottom_30">
        <div class="name col-md-4 hidden-md hidden-sm hidden-xs"><?php echo $nome." ".$apelido; ?>.</div>
        <div class="copyright col-lg-8 col-md-12">© 2019 All rights reserved. Designed by Help2Everyone </div>
    </div>
</footer>

</div> <!-- Tab Container - End -->
</div> <!-- Row - End -->
</div> <!-- Wrapper - End -->

<!-- Javascripts
================================================== -->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easytabs.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<!-- for color alternatives -->
<!--<script src="js/jquery.cookie-1.4.1.min.js"></script>
<script src="js/Demo.js"></script>
<link rel="stylesheet" href="css/Demo.min.css" />-->


</body>
</html>
<?php
include('./../fechligacao.ini');
?>
