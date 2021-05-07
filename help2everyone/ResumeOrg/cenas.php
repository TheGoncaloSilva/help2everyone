<?php
	include('./../inicligacao.ini');
  session_start();
	$orgvinda=$_SESSION['targetorg'];
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
	if($logado!=$orgvinda){
		$falso=1;
	}else{
		$falso=0;
	}
	$msgvisos=0;
	$msgvisos_org=0;
	$operacao=0;
	$result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$orgvinda."'");
	$entrada=mysqli_fetch_array($result);
	$identidade=htmlspecialchars($entrada['Id']);
	$utilizador=htmlspecialchars($entrada['Nome']);
	$fotozinha=htmlspecialchars($entrada['Foto']);

	if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updateall'])) {

	  if (!empty($_POST['nome'])) {
	    $nome=htmlspecialchars($_POST['nome']);
	  }
		if (!empty($_POST['ficheiroup'])) {
			$fic=htmlspecialchars($_POST['ficheiroup']);
		}
	  if (!empty($_POST['email'])) {
	    $email=htmlspecialchars($_POST['email']);
	  }
		if (!empty($_POST['telefone'])) {
	    $telefone=htmlspecialchars($_POST['telefone']);
	  }
		if (!empty($_POST['data_fund'])) {
			$datafundacao=htmlspecialchars($_POST['data_fund']);
		}
		if (!empty($_POST['pais'])) {
			$pais=htmlspecialchars($_POST['pais']);
		}
		if (!empty($_POST['site'])) {
			$website=htmlspecialchars($_POST['site']);
		}
		if (!empty($_POST['cod_pos'])) {
			$codpostal=htmlspecialchars($_POST['cod_pos']);
		}
		if (!empty($_POST['morada'])) {
			$morada=htmlspecialchars($_POST['morada']);
		}
		if (!empty($_POST['distrito'])) {
			$distrito=htmlspecialchars($_POST['distrito']);
		}
		if (!empty($_POST['concelho'])) {
			$concelho=htmlspecialchars($_POST['concelho']);
		}
		if (!empty($_POST['freguesia'])) {
			$freguesia=htmlspecialchars($_POST['freguesia']);
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
		if (!empty($_POST['info'])) {
			$info=htmlspecialchars($_POST['info']);
		}
		if (!empty($_POST['missao'])) {
			$missao=htmlspecialchars($_POST['missao']);
		}
				$caminho=$_FILES['ficheiroup']['name'];
				$caminhoTmp=$_FILES['ficheiroup']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$utilizador.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./../Fotos/FotosOrg/".$caminho);
				}else{
					$caminho=$fotozinha;
				}

		if(mysqli_query($conn,"update tblorganizacao set Foto='".$caminho."' , Nome='".$nome."' , Email='".$email."' , Telefone='".$telefone."'
		, Pais='".$pais."', Morada='".$morada."' , CodPostal='".$codpostal."' , Distrito='".$distrito."' , Concelho='".$concelho."' , Freguesia='".$freguesia."'
		, DataFundacao='".$datafundacao."' , PagFacebook='".$face."' , Website='".$website."' , PagTwitter='".$twit."' , PagInstagram='".$insta."'
		, Info='".$info."' , Missao='".$missao."' where id='".$identidade."'")){
			$msgvisos_org=1;
		}else{
			$msgvisos_org=2;
		}

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
		 $tentar=mysqli_query($conn,"select Id from tblareaatuacao where Nome='".$idop."' && IdOrganizacao='".$identidade."'");
		 $verificar=mysqli_fetch_array($tentar);
		 if($verificar[0]!=null){
				 $cmdt=mysqli_query($conn,"select Nome from tblareaatuacao where IdOrganizacao='".$identidade."'");
				 $l1=0;
				 $dado[0]=null;
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
							mysqli_query($conn,"Delete from tblareaatuacao where Nome='".$dado[$finalt]."' && IdOrganizacao='".$identidade."'");
					 }
				 }

			}else{
			mysqli_query($conn,"insert into tblareaatuacao(Nome,IdOrganizacao) values('".$idop."','".$identidade."')");
		 }
	 }
 }
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['area_evento']))
{
if(!empty($_POST['checkbox'])){
	$check=$_POST['checkbox'];
}
if(!empty($check)){
 $tam=count($check);
 for($i=0;$i<$tam;$i++)
 {
	 $idop=$check[$i];
	 $tentar=mysqli_query($conn,"select Id from tblareaatucaoevento where Nome='".$idop."' && IdEvento='".$Id_Evento."'");
	 $verificar=mysqli_fetch_array($tentar);
	 if($verificar[0]!=null){
			 $cmdt=mysqli_query($conn,"select Nome from tblareaatucaoevento where IdEvento='".$Id_Evento."'");
			 $l1=0;
			 $dado[0]=null;
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
						mysqli_query($conn,"Delete from tblareaatucaoevento where Nome='".$dado[$finalt]."' && IdEvento='".$$Id_Evento."'");
				 }
			 }

		}else{
		mysqli_query($conn,"insert into tblareaatucaoevento(Nome,IdEvento) values('".$idop."','".$$Id_Evento."')");
	 }
 }
}
}
/*
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['editar'])){
  $user=mysqli_query($conn,"select * from tblevento where Id=".$_GET['editar']);
  $row=mysqli_fetch_array($user);
	$Id_Evento=htmlspecialchars($row['Id']);
  $Nome_Evento=htmlspecialchars($row['Nome']);
  $Pais_Evento=htmlspecialchars($row['Pais']);
  $Morada_Evento=htmlspecialchars($row['Morada']);
	$CodPostal_Evento=htmlspecialchars($row['CodPostal']);
	$Distrito_Evento=htmlspecialchars($row['Distrito']);
	$Concelho_Evento=htmlspecialchars($row['Concelho']);
	$Freguesia_Evento=htmlspecialchars($row['Freguesia']);
	$FuncVol_Evento=htmlspecialchars($row['FuncaoVoluntario']);
	$BreveDesc_Evento=htmlspecialchars($row['BreveDesc']);
	$Descricao_Evento=htmlspecialchars($row['Descricao']);
	$NumVagas_Evento=htmlspecialchars($row['NumVagas']);
	$DataInicio_Evento=htmlspecialchars($row['DataInicio']);
	$DataFim_Evento=htmlspecialchars($row['DataTermino']);
	$Duracao_Evento=htmlspecialchars($row['Duracao']);
	$Idioma_Evento=htmlspecialchars($row['Idioma']);
	$Compromisso_Evento=htmlspecialchars($row['Compromisso']);
	$GrupoAlvo_Evento=htmlspecialchars($row['GrupoAlvo']);
	$Helps_Evento=htmlspecialchars($row['Quant_Helps']);
	$IdOrganizacao=htmlspecialchars($row['IdOrganizacao']);
	$operacao=1;

	$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
	$entrada=mysqli_fetch_array($company);
	$NomeOrganização_Evento=$entrada[0];
}*/

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar'])){
  $ideliminar=$_GET['eliminar'];
  //$user=mysqli_query($conn,"select Foto from tblimg where Id=".$ideliminar);
  //$row=mysqli_fetch_array($user);
  //unlink('./userimg/'.$row['Foto']);
	//eliminar relações
  //mysqli_query($conn,"delete from tblevento where Id=".$ideliminar);

}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['GuardarFormulario'])){
		if (!empty($_GET['nome_evento'])) {
	    $Nome_Evento=htmlspecialchars($_GET['nome_evento']);
	  }
		if (!empty($_GET['morada_evento'])) {
			$Morada_Evento=htmlspecialchars($_GET['morada_evento']);
		}
		if (!empty($_GET['pais_evento'])) {
			$Pais_Evento=htmlspecialchars($_GET['pais_evento']);
		}
		if (!empty($_GET['codpostal_evento'])) {
			$CodPostal_Evento=htmlspecialchars($_GET['codpostal_evento']);
		}
		if (!empty($_GET['distrito_evento'])) {
			$Distrito_Evento=htmlspecialchars($_GET['distrito_evento']);
		}
		if (!empty($_GET['concelho_evento'])) {
			$Concelho_Evento=htmlspecialchars($_GET['concelho_evento']);
		}
		if (!empty($_GET['freguesia_evento'])) {
			$Freguesia_Evento=htmlspecialchars($_GET['freguesia_evento']);
		}
		if (!empty($_GET['funcaovol_evento'])) {
			$FuncVol_Evento=htmlspecialchars($_GET['funcaovol_evento']);
		}
		if (!empty($_GET['brevedesc_evento'])) {
			$BreveDesc_Evento=htmlspecialchars($_GET['brevedesc_evento']);
		}
		if (!empty($_GET['descricao_evento'])) {
			$Descricao_Evento=htmlspecialchars($_GET['descricao_evento']);
		}
		if (!empty($_GET['inicio_evento'])) {
			$DataInicio_Evento=htmlspecialchars($_GET['inicio_evento']);
		}
		if (!empty($_GET['fim_evento'])) {
			$DataFim_Evento=htmlspecialchars($_GET['fim_evento']);
		}
		if (!empty($_GET['Duracao_evento'])) {
			$Duracao_Evento=htmlspecialchars($_GET['Duracao_evento']);
		}
		if (!empty($_GET['numvagas_evento'])) {
			$NumVagas_Evento=htmlspecialchars($_GET['numvagas_evento']);
		}
		if (!empty($_GET['idioma_evento'])) {
			$Idioma_Evento=htmlspecialchars($_GET['idioma_evento']);
		}
		if (!empty($_GET['Compromisso_evento'])) {
			$Compromisso_Evento=htmlspecialchars($_GET['Compromisso_evento']);
		}
		if (!empty($_GET['alvo_evento'])) {
			$GrupoAlvo_Evento=htmlspecialchars($_GET['alvo_evento']);
		}
		if (!empty($_GET['helps_evento'])) {
			$Helps_Evento=htmlspecialchars($_GET['helps_evento']);
		}
		if (!empty($_GET['helps_evento'])) {
			$Helps_Evento=htmlspecialchars($_GET['helps_evento']);
		}

		/*$path=$_FILES['fileButton']['name'];
		$pathTmp=$_FILES['fileButton']['tmp_name'];
		if(!empty($path)){
			$explode=(explode('.',$path));
			$path=$utilizador.time().'.'.$explode[1];
			$criar=move_uploaded_file($pathTmp, "./../Fotos/FotosOrg/".$path);
		}else{
			$caminhozinho=mysqli_query($conn,"select FotoLocal from tblevento where IdOrganizacao='".$entr[0]."'");
			$cena=mysqli_fetch_array($caminhozinho);
			$path=$cena[0];
		}
FotoLocal='".$path."'
		*/

		if(mysqli_query($conn,"update tblevento set Nome='".$Nome_Evento."' , Pais='".$Pais_Evento."', Morada='".$Morada_Evento."'
		, CodPostal='".$CodPostal_Evento."' , Distrito='".$Distrito_Evento."' , Concelho='".$Concelho_Evento."' , Freguesia='".$Freguesia_Evento."'
		, DataInicio='".$DataInicio_Evento."' , DataTermino='".$DataFim_Evento."' , FuncaoVoluntario='".$FuncVol_Evento."' , BreveDesc='".$BreveDesc_Evento."'
		, Descricao='".$Descricao_Evento."' , NumVagas='".$NumVagas_Evento."' , Duracao='".$Duracao_Evento."' , Idioma='".$Idioma_Evento."'
		, Compromisso='".$Compromisso_Evento."' , GrupoAlvo='".$GrupoAlvo_Evento."' , Quant_Helps='".$Helps_Evento."'  where IdOrganizacao='".$entr[0]."'")){
				$msgvisos=1;
		}else{
				$msgvisos=2;
		}

	}
	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['InserirFormulario'])){
		if (!empty($_GET['nome_ev'])) {
	    $Nome_E=htmlspecialchars($_GET['nome_ev']);
	  }
		if (!empty($_GET['morada_ev'])) {
			$Morada_E=htmlspecialchars($_GET['morada_ev']);
		}
		if (!empty($_GET['pais_ev'])) {
			$Pais_E=htmlspecialchars($_GET['pais_ev']);
		}
		if (!empty($_GET['codpostal_ev'])) {
			$CodPostal_E=htmlspecialchars($_GET['codpostal_ev']);
		}
		if (!empty($_GET['distrito_ev'])) {
			$Distrito_E=htmlspecialchars($_GET['distrito_ev']);
		}
		if (!empty($_GET['concelho_ev'])) {
			$Concelho_E=htmlspecialchars($_GET['concelho_ev']);
		}
		if (!empty($_GET['freguesia_ev'])) {
			$Freguesia_E=htmlspecialchars($_GET['freguesia_ev']);
		}
		if (!empty($_GET['funcaovol_ev'])) {
			$FuncVol_E=htmlspecialchars($_GET['funcaovol_ev']);
		}
		if (!empty($_GET['brevedesc_ev'])) {
			$BreveDesc_E=htmlspecialchars($_GET['brevedesc_ev']);
		}
		if (!empty($_GET['descricao_ev'])) {
			$Descricao_E=htmlspecialchars($_GET['descricao_ev']);
		}
		if (!empty($_GET['inicio_ev'])) {
			$DataInicio_E=htmlspecialchars($_GET['inicio_ev']);
		}
		if (!empty($_GET['fim_ev'])) {
			$DataFim_E=htmlspecialchars($_GET['fim_ev']);
		}
		if (!empty($_GET['Duracao_ev'])) {
			$Duracao_E=htmlspecialchars($_GET['Duracao_ev']);
		}
		if (!empty($_GET['numvagas_ev'])) {
			$NumVagas_E=htmlspecialchars($_GET['numvagas_ev']);
		}
		if (!empty($_GET['idioma_ev'])) {
			$Idioma_E=htmlspecialchars($_GET['idioma_ev']);
		}
		if (!empty($_GET['Compromisso_ev'])) {
			$Compromisso_E=htmlspecialchars($_GET['Compromisso_ev']);
		}
		if (!empty($_GET['alvo_ev'])) {
			$GrupoAlvo_E=htmlspecialchars($_GET['alvo_ev']);
		}
		if (!empty($_GET['helps_ev'])) {
			$Helps_E=htmlspecialchars($_GET['helps_ev']);
		}
$Helps_E=200;
		/*$path=$_FILES['fileButton']['name'];
		$pathTmp=$_FILES['fileButton']['tmp_name'];
		if(!empty($path)){
			$explode=(explode('.',$path));
			$path=$utilizador.time().'.'.$explode[1];
			$criar=move_uploaded_file($pathTmp, "./../Fotos/FotosOrg/".$path);
		}else{
			$caminhozinho=mysqli_query($conn,"select FotoLocal from tblevento where IdOrganizacao='".$entr[0]."'");
			$cena=mysqli_fetch_array($caminhozinho);
			$path=$cena[0];
		}
FotoLocal='".$path."'
		*/

		if(mysqli_query($conn,"insert into tblevento(Nome,Pais,Morada,CodPostal,Distrito,Concelho,Freguesia
		,FuncaoVoluntario,BreveDesc,Descricao,NumVagas,DataInicio,DataTermino,Duracao,Idioma,Compromisso,GrupoAlvo
		,Quant_Helps,IdOrganizacao) values('".$Nome_E."','".$Pais_E."','".$Morada_E."','".$CodPostal_E."','".$Distrito_E."'
		,'".$Concelho_E."','".$Freguesia_E."','".$FuncVol_E."','".$BreveDesc_E."','".$Descricao_E."','".$NumVagas_E."'
		,'".$DataInicio_E."','".$DataFim_E."','".$Duracao_E."','".$Idioma_E."','".$Compromisso_E."','".$GrupoAlvo_E."'
		,'".$Helps_E."','".$identidade."')")){
				$msgvisos=1;
		}else{
				$msgvisos=2;
		}


		$certo=mysqli_query($conn,"select Id from tblevento where IdOrganizacao='".$identidade."'");
		$l1=0;
		$dado[0]=null;
		while ($valor=mysqli_fetch_array($certo)) {

			$dado[$l1]=$valor[0];
			$l1++;
		}
		$ar=(count($dado)-1);

		if(!empty($ar)){

			if(mysqli_query($conn,"insert into tblorgevento(IdEvento,IdOrganizacao) values('".$dado[$ar]."','".$identidade."')")){
				if(!empty($_POST['check'])){
					$chec=$_POST['check'];
				}
				if(!empty($chec)){
				 $tam=count($chec);
				 for($i=0;$i<$tam;$i++)
				 {
						if(mysqli_query($conn,"insert into tblareaatucaoevento(Nome,IdEvento) values('".$chec[$i]."','".$dado[$ar]."')")){
							$msgvisos=1;
						}
					 }
				 }
		}else{
				$msgvisos=2;
		}
	}else{
				$msgvisos=2;
	}


	}
?>
<!doctype html>
<html lang="pt">
<head>

<!-- Simple Page Needs
================================================== -->
<title>H2E: <?php echo $orgvinda; ?></title>
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
<link rel="stylesheet" href="css/colors/color2.css"/>
<link rel="stylesheet" href="css/BootstrapSelect.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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
      $result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$orgvinda."'");
      $entrada=mysqli_fetch_array($result);
      $identidade=htmlspecialchars($entrada['Id']);
      $foto=htmlspecialchars($entrada['Foto']);
      $nome=htmlspecialchars($entrada['Nome']);
			$email=htmlspecialchars($entrada['Email']);
			$telefone=htmlspecialchars($entrada['Telefone']);
			$website=htmlspecialchars($entrada['Website']);
			$datafundacao=htmlspecialchars($entrada['DataFundacao']);
			$face=htmlspecialchars($entrada['PagFacebook']);
			$twt=htmlspecialchars($entrada['PagTwitter']);
			$insta=htmlspecialchars($entrada['PagInstagram']);
			$missao=htmlspecialchars($entrada['Missao']);
			$info=htmlspecialchars($entrada['Info']);
			$morada=htmlspecialchars($entrada['Morada']);
			$codpostal=htmlspecialchars($entrada['CodPostal']);
			$distrito=htmlspecialchars($entrada['Distrito']);
			$concelho=htmlspecialchars($entrada['Concelho']);
			$freguesia=htmlspecialchars($entrada['Freguesia']);
      $pais=htmlspecialchars($entrada['Pais']);
			$datareg=htmlspecialchars($entrada['DataReg']);

			if($foto=='userimg.png'){
				$escolherfoto=true;
			}else{
				$escolherfoto=false;
			}

      $ts1 = strtotime($datafundacao);
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

			if(empty($pais) && $falso==0){
				echo "<div class='alert alert-warning' role='alert'>
  							Precisa de Atualizar os seus dados!!!
								</div>";
			}
  ?>

<!-- Wrapper -->
<div class="wrapper top_60 container">
<div class="row">


<!-- Profile Section
================================================== -->
<div class="col-lg-3 col-md-4">
    <div class="profile">
        <div class="profile-name">
						<a href="./../index.php" title="Ir para Home"><i class="fa fa-chevron-left"></i></a>
            <span class="name"><?php echo $nome; ?></span><br>
            <span class="job"><?php echo $pais; ?> - Organização</span>
        </div>
        <figure class="profile-image">
            <img src=<?php echo "./../Fotos/FotosOrg/".$foto; ?> alt="">
        </figure>
        <ul class="profile-information">
            <li></li>
            <li><p><span>Nome: </span><?php echo $nome; ?></p></li>
            <li><p><span>País: </span><?php echo $pais; ?></p></li>
						<li><p><span>Website: </span><?php echo $website; ?></p></li>
            <li><p><span>Data Fundacao: </span><?php echo $nascimento; ?></p></li>
            <li><p><span>Email: </span><?php echo $email; ?></p></li>
						<li><p><span>Avaliação: </span><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></p></li>
        </ul>
        <div class="col-md-12">
            <button class="site-btn icon">Download Cv <i class="fa fa-download" aria-hidden="true"></i></button>
        </div>
    </div>
</div>

<!-- Page Tab Container Div -->
<div id="ajax-tab-container" class="col-lg-9 col-md-8 tab-container">

<!-- Header
================================================== -->
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
                        <li class="tab"><a href="#resume">SOBRE</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#portfolio">PORTFOLIO</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#blog">BLOG</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#contact">CONTACT</a></li>
												<li class="tab" <?php echo $property2; echo $property; ?>><a href="#create">CRIAR</a></li>
                        <li class="tab" <?php echo $property2; echo $property; ?>><a href="#informacao">INFORMAÇÕES</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-8 dynamic">
                    <a href="mailto:<?php echo $email; ?>" class="pull-right site-btn icon hidden-xs">Contacte <i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                    <div class="hamburger pull-right hidden-lg hidden-md"><i class="fa fa-bars" aria-hidden="true"></i></div>
                    <div class="hidden-md social-icons pull-right">
											  <a class="fb" target="_blank" href=<?php echo $website; ?>><i class="fa fa-internet-explorer" aria-hidden="true"></i></a>
                        <a class="fb" target="_blank" href=<?php echo $face; ?>><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a class="tw" target="_blank" href=<?php echo $twt; ?>><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a class="ins" target="_blank" href=<?php echo $insta; ?>><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

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
                    <div class="section-title"><span></span><h2>Missão</h2></div>
                    <p class="top_30"><?php echo $missao; ?></p>
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

											$checn=mysqli_query($conn,"Select Nome from tblareaatuacao where IdOrganizacao=".$identidade);
											$n=0;
											if(!empty($segmento)){
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
														echo "<div class='col-md-3 col-sm-6 col-xs-12'>
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
								$cmd=mysqli_query($conn,"select IdEvento from tblorgevento where IdOrganizacao=".$identidade);
								$a=0;
								$val[0]=null;
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

																			echo "<li><h3 class='line-title'>".$NomeEvento."</h3>
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
                                    <li><i class="fa fa-road" aria-hidden="true"></i><h2 class="timeline-title">Sobre</h2></li>
																		<?php
																		if(!empty($tamanho)){
																		if($notreg==false){
																			echo "
																			<li><h3 class='line-title'>".$nome."</h3>
	                                        <span>Fundada a: ".$nascimento."</span>
	                                    </li>
	                                    <li><h3 class='line-title'>Localizar</h3>
	                                        <span>".$distrito." , ".$concelho."</span>
	                                    </li>
	                                    <li><h3 class='line-title'>Registo</h3>
	                                        <span>Registou-se a: ".$registanco."</span>
	                                    </li> ";
																		}
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

						<!-- create -->
						<div id="create">
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
                <div class="row">
                    <section class="contact-form col-md-12 padding_30 padbot_45">
                        <div class="section-title top_15 bottom_30"><span></span><h2>Eventos existentes <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
												<div class="row">
												<button type='button' data-toggle='modal' data-target='#modal3' class='btn btn-warning'><i class='fa fa-plus'></i></button>
											</div>
                        <form class="site-form">
                            <div class="row table-responsive text-center">
															<table class="table">
															  <thead class="thead-dark">
															    <tr>
																		<th scope="col"><i class="fa fa-cog"></i></th>
															      <th scope="col">Id</th>
															      <th scope="col">Nome Evento</th>
															      <th scope="col">Total Vagas</th>
															      <th scope="col">Vagas</th>
																		<th scope="col">Data de Início</th>
																		<th scope="col">Data Término</th>
															    </tr>
															  </thead>
															  <tbody>
																	<?php
																	if(!empty($tamanho)){
																		for($i=0;$i<$tamanho;$i++){
																			$notreg=false;
																			$selecionar=mysqli_query($conn,"select * from tblevento where Id='".$val[$i]."' && Inativo=0");
																			$volunvaga=mysqli_query($conn,"select * from tblvolevento where IdEvento=".$val[$i]);
																			if(!empty($selecionar)){
																			$row=mysqli_fetch_array($selecionar);
																			$IdEvento=htmlspecialchars($row['Id']);
																			$NomeEvento=htmlspecialchars($row['Nome']);
																			$FotoLocal=htmlspecialchars($row['FotoLocal']);
																			$DescEvento=htmlspecialchars($row['Descricao']);
																			$NumVagas=htmlspecialchars($row['NumVagas']);
																			$Orgs=htmlspecialchars($row['IdOrganizacao']);
																			$DataInicioEvento=htmlspecialchars($row['DataInicio']);
																			$DatafimEvento=htmlspecialchars($row['DataTermino']);
																			if(!empty($volunvaga)){
																			$numvol=0;
																			$inf=array();
																			while ($entrance=mysqli_fetch_array($volunvaga)) {

																				$inf[$numvol]=$entrance[0];
																				$numvol++;
																			}
																			$tasm=count($inf);
																			$tasm=$NumVagas-$tasm;
																		}else{
																			$tasm=$NumVagas;
																		}
																		if($Orgs!=$identidade){
																			$disable="disabled";
																		}else{
																			$disable="";
																		}

																				echo "
																				<tr>
																				<td><button type='button' onclick='teste(".$IdEvento.")' data-toggle='modal' data-target='#exampleModal' class='btn btn-info'><i class='fa fa-file-o'></i></button> <a href='./index.php?eliminar=".$IdEvento."' class='btn btn-danger'><i class='fa fa-times'></i></a> <button type='button' data-id=".$IdEvento." ".$disable." data-toggle='modal' data-target='#modal2' class='btn btn-success'><i class='fa fa-pencil-square-o'></i></button></td>
																				<td>".$IdEvento."</td>
																				<td>".$NomeEvento."</td>
																				<td>".$NumVagas."</td>
																				<td>".$tasm."</td>
																				<td>".$DataInicioEvento."</td>
																				<td>".$DatafimEvento."</td>
																				</tr>";
																			}
																		}
}
																		 ?>
															  </tbody>
															</table>
															<script>
																function teste(valor) {
																	alert(valor);
																	document.getElementById('campo').value = valor;
																}
															</script>

														</div>
														<div class="row">
														<button type='button' class='btn btn-secondary'><i class='fa fa-arrow-left'></i></button>
														<button type='button' class='btn btn-secondary'><i class='fa fa-arrow-right'></i></button>
													</div>
															<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															  <div class="modal-dialog" role="document">
															    <div class="modal-content">
															      <div class="modal-header">
															        <h5 class="modal-title" id="exampleModalLabel">Visualizar Registo</h5>
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span>
															        </button>
															      </div>
																		<div class="modal-body">
																		<div class="row text-left">
																			<div class="col-md-6">
																				<div class="section-title top_15 bottom_30"><span></span><h2>Informações</h2></div>
																				<input hidden type="text" name="campo" id="campo">

																			<ul class="">
																				<?php
																				$selecionar=mysqli_query($conn,"select * from tblevento where Id=".$IdEvento);
																				$row=mysqli_fetch_array($selecionar);
																				$Foto_ev=htmlspecialchars($row['FotoLocal']);
																				$Nome_ev=htmlspecialchars($row['Nome']);
																				$Pais_ev=htmlspecialchars($row['Pais']);
																				$Morada_Ev=htmlspecialchars($row['Morada']);
																				$CodPostal_Ev=htmlspecialchars($row['CodPostal']);
																				$Distrito_Ev=htmlspecialchars($row['Distrito']);
																				$Concelho_Ev=htmlspecialchars($row['Concelho']);
																				$Freguesia_Ev=htmlspecialchars($row['Freguesia']);
																				$FuncVol_Ev=htmlspecialchars($row['FuncaoVoluntario']);
																				$BreveDesc_Ev=htmlspecialchars($row['BreveDesc']);
																				$Descricao_Ev=htmlspecialchars($row['Descricao']);
																				$NumVagas_Ev=htmlspecialchars($row['NumVagas']);
																				$DataInicio_Ev=htmlspecialchars($row['DataInicio']);
																				$DataFim_Ev=htmlspecialchars($row['DataTermino']);
																				$Duracao_Ev=htmlspecialchars($row['Duracao']);
																				$Idioma_Ev=htmlspecialchars($row['Idioma']);
																				$Compromisso_Ev=htmlspecialchars($row['Compromisso']);
																				$GrupoAlvo_Ev=htmlspecialchars($row['GrupoAlvo']);
																				$Helps_Ev=htmlspecialchars($row['Quant_Helps']);
																				$IdOrganizacao=htmlspecialchars($row['IdOrganizacao']);
																				$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
																				$entrada=mysqli_fetch_array($company);
																				$NomeOrganização_Ev=$entrada[0];

																				 ?>
																				 <ul class="list-group">
																					<li class="list-group-item"><img <?php echo "src=./../Fotos/FotosEvent/".$Foto_ev; ?> alt="..." class="img-thumbnail"></li>
																				  <li class="list-group-item"><p><span><strong>Nome: </strong></span><?php echo $Nome_ev; ?></p></li>
																				  <li class="list-group-item"><p><span><strong>Pais: </strong></span><?php echo $Pais_ev; ?></p></li>
																				  <li class="list-group-item"><p><span><strong>Morada: </strong></span><?php echo $Morada_Ev; ?></p></li>
																				  <li class="list-group-item"><p><span><strong>Código Postal: </strong></span><?php echo $CodPostal_Ev; ?></p></li>
																				  <li class="list-group-item"><p><span><strong>Distrito: </strong></span><?php echo $Distrito_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Concelho: </strong></span><?php echo $Concelho_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Freguesia: </strong></span><?php echo $Freguesia_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Função do Voluntário: </strong></span><?php echo $FuncVol_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Breve descrição: </strong></span><?php echo $BreveDesc_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Descrição: </strong></span><?php echo $Descricao_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Total de Vagas: </strong></span><?php echo $NumVagas_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Data de início: </strong></span><?php echo $DataInicio_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Data de fim: </strong></span><?php echo $DataFim_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Duração: </strong></span><?php echo $Duracao_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Idioma: </strong></span><?php echo $Idioma_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Tipo de compromisso: </strong></span><?php echo $Compromisso_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Grupo alvo: </strong></span><?php echo $GrupoAlvo_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Nº de helps: </strong></span><?php echo $Helps_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Breve descrição: </strong></span><?php echo $BreveDesc_Ev; ?></p></li>
																					<li class="list-group-item"><p><span><strong>Organização criadora: </strong></span><?php echo $NomeOrganização_Ev; ?></p></li>
																				</ul>
																		</div>
																		<div class="col-md-6">
																			<div class="section-title top_15 bottom_30"><span></span><h2>Organizações</h2></div>
																			<ul class="list-group">
																				<?php
																				$compa=mysqli_query($conn,"Select IdOrganizacao from tblorgevento where IdEvento=".$IdEvento);
																				$n=0;
																				while ($segm=mysqli_fetch_array($compa)) {
																					$org=mysqli_query($conn,"Select Nome from tblorganizacao where Id=".$segm[0]);
																					$value=mysqli_fetch_array($org);
																					echo "<li class='list-group-item'>".$segm[0]." - ".$value[0]."</li>";
																				}
																				?>
																			</ul>
																			<div class="section-title top_15 bottom_30"><span></span><h2>Voluntários</h2></div>
																			<?php
																			$volunvaga=mysqli_query($conn,"select IdVoluntario from tblvolevento where IdEvento=".$IdEvento);
																			$numvol=0;
																			$inf[0]=null;
																			while ($entrance=mysqli_fetch_array($volunvaga)) {
																				$org=mysqli_query($conn,"Select Nome from tblvoluntario where Id=".$entrance[0]);
																				$value=mysqli_fetch_array($org);
																				echo "<li class='list-group-item'>".$entrance[0]." - ".$value[0]."</li>";
																			}
																			?>
																		</div>
																		</div>
																		</div>
															      <div class="modal-footer">
															        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
															      </div>
															    </div>
															  </div>
															</div>


															<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<?php
																$user=mysqli_query($conn,"select * from tblevento where Id=".$IdEvento);
																$row=mysqli_fetch_array($user);
																$Foto_Evento=htmlspecialchars($row['FotoLocal']);
																$Id_Evento=htmlspecialchars($row['Id']);
																$Nome_Evento=htmlspecialchars($row['Nome']);
																$Pais_Evento=htmlspecialchars($row['Pais']);
																$Morada_Evento=htmlspecialchars($row['Morada']);
																$CodPostal_Evento=htmlspecialchars($row['CodPostal']);
																$Distrito_Evento=htmlspecialchars($row['Distrito']);
																$Concelho_Evento=htmlspecialchars($row['Concelho']);
																$Freguesia_Evento=htmlspecialchars($row['Freguesia']);
																$FuncVol_Evento=htmlspecialchars($row['FuncaoVoluntario']);
																$BreveDesc_Evento=htmlspecialchars($row['BreveDesc']);
																$Descricao_Evento=htmlspecialchars($row['Descricao']);
																$NumVagas_Evento=htmlspecialchars($row['NumVagas']);
																$DataInicio_Evento=htmlspecialchars($row['DataInicio']);
																$DataFim_Evento=htmlspecialchars($row['DataTermino']);
																$Duracao_Evento=htmlspecialchars($row['Duracao']);
																$Idioma_Evento=htmlspecialchars($row['Idioma']);
																$Compromisso_Evento=htmlspecialchars($row['Compromisso']);
																$GrupoAlvo_Evento=htmlspecialchars($row['GrupoAlvo']);
																$Helps_Evento=htmlspecialchars($row['Quant_Helps']);
																$IdOrganizacao=htmlspecialchars($row['IdOrganizacao']);

																$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
																$entrada=mysqli_fetch_array($company);
																$NomeOrganização_Evento=$entrada[0];
																 ?>
															<form class="site-form" id="Formulario" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"  enctype="multipart/form-data">
															  <div class="modal-dialog" role="document">
															    <div class="modal-content">
															      <div class="modal-header">
															        <h5 class="modal-title" id="exampleModalLabel">Editar Registo</h5>
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span>
															        </button>
															      </div>
																		<div class="modal-body">
																		<div class="row">
																			<div class="col-md-6">
																				<div class="section-title top_15 bottom_30"><span></span><h2>Evento</h2></div>
																				<div class="row">
																					<div class="col-md-12">
																						<label>Nome: </label>
																							 <input class="site-input" value="<?php if(isset($Nome_Evento)){echo $Nome_Evento;} ?>" maxlength="50" type="text" name="nome_evento" placeholder="Insira o Nome do Evento" required>
																					 </div>
																					<div class="col-md-12" style="padding-bottom: 10px;">
																						<label>Foto do Local: </label>
																							<input type="file" id="fileButton" name="fileButton" class="btn btn-primary" accept="image/png, image/jpeg" style="padding-top: 5px;max-width:100% ">
																					</div>
																					<div class="col-md-12">
																						<label>Morada: </label>
																							<input class="site-input" value="<?php if(isset($Morada_Evento)){echo $Morada_Evento;} ?>" maxlength="200" type="text" name="morada_evento" placeholder="Insira a morada" required>
																					</div>
																					<div class="col-md-6">
																					  <label>País: </label>
																							<input class="site-input" value="<?php if(isset($Pais_Evento)){echo $Pais_Evento;} ?>" maxlength="100" type="text" name="pais_evento" placeholder="Insira o País" required>
																					</div>
																					<div class="col-md-6">
																						<label>Código Postal: </label>
																							<input class="site-input" value="<?php if(isset($CodPostal_Evento)){echo $CodPostal_Evento;} ?>" maxlength="8" type="text" name="codpostal_evento" placeholder="Insira o Código Postal" required>
																					</div>
																					<div class="col-md-6">
																						<label>Distrito: </label>
																							<input class="site-input" value="<?php if(isset($Distrito_Evento)){echo $Distrito_Evento;} ?>" maxlength="50" type="text" name="distrito_evento" placeholder="Insira o Distrito" required>
																					</div>
																					<div class="col-md-6">
																						<label>Concelho: </label>
																							<input class="site-input" value="<?php if(isset($Concelho_Evento)){echo $Concelho_Evento;} ?>" maxlength="50" type="text" name="concelho_evento" placeholder="Insira o Concelho" required>
																					</div>
																					<div class="col-md-6">
																						<label>Freguesia: </label>
																							<input class="site-input" value="<?php if(isset($Freguesia_Evento)){echo $Freguesia_Evento;} ?>" maxlength="50" type="text" name="freguesia_evento" placeholder="Insira a freguesia" required>
																					</div>
																					<div class="col-md-12">
																						<label>Função do Voluntário: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="500" type="text" name="funcaovol_evento" placeholder="Insira a função do Voluntário" required><?php if(isset($FuncVol_Evento)){echo $FuncVol_Evento;} ?></textarea>
																					</div>
																					<div class="col-md-12">
																						<label>Breve Descrição: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="90" type="text" name="brevedesc_evento" placeholder="Insira uma breve descrição" required><?php if(isset($BreveDesc_Evento)){echo $BreveDesc_Evento;} ?></textarea>
																					</div>
																					<div class="col-md-12">
																						<label>Descrição: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="1000" type="text" name="descricao_evento" placeholder="Insira a descrição" required><?php if(isset($Descricao_Evento)){echo $Descricao_Evento;} ?></textarea>
																					</div>
																					<div class="col-md-6">
																						<label>Data de Início: </label>
																							<input class="site-input" value="<?php if(isset($DataInicio_Evento)){echo $DataInicio_Evento;} ?>" type="date" name="inicio_evento" placeholder="Insira a data de início" required>
																					</div>
																					<div class="col-md-6">
																						<label>Data de Fim: </label>
																							<input class="site-input" value="<?php if(isset($DataFim_Evento)){echo $DataFim_Evento;} ?>" type="date" name="fim_evento" placeholder="Insira a data de fim" required>
																					</div>
																					<div class="col-md-6">
																						<label>Duração: </label>
																							<input class="site-input" value="<?php if(isset($Duracao_Evento)){echo $Duracao_Evento;} ?>" type="number" name="Duracao_evento" placeholder="Insira a duração(em horas)" required>
																					</div>
																					<div class="col-md-6">
																						<label>Total de Vagas: </label>
																							<input class="site-input" value="<?php if(isset($NumVagas_Evento)){echo $NumVagas_Evento;} ?>" type="number" name="numvagas_evento" placeholder="Insira o nº de vagas" required>
																					</div>
																					<div class="col-md-6">
																						<label>Idioma: </label>
																							<input class="site-input" value="<?php if(isset($Idioma_Evento)){echo $Idioma_Evento;} ?>" maxlength="100" type="text" name="idioma_evento" placeholder="Insira o idioma do evento" required>
																					</div>
																					<div class="col-md-6">
																						<label>Compromisso: </label>
																						<!--	<input class="site-input" value="<?php// if(isset($Compromisso_Evento)){echo $Compromisso_Evento;} ?>" maxlength="70" type="text" name="Compromisso_evento" placeholder="Insira o tipo de compromisso" required>-->
																							<select class="custom-select custom-select-sm site-input" name="Compromisso_evento" required>>
																							  <option <?php if(isset($Compromisso_Evento)){echo "value=".$Compromisso_Evento;}else{} ?> selected><?php if(isset($Compromisso_Evento)){echo $Compromisso_Evento;}else{echo "Escolha o tipo de compromisso";} ?></option>
																								<option value="Ocasional">Ocasional</option>
																								<option value="Regular">Regular</option>
																							</select>
																					</div>
																					<div class="col-md-6">
																						<label>Grupo Alvo: </label>
																						<!--
																							<select class="selectpicker custom-select custom-select-sm site-input" name="alvo_evento" multiple data-live-search="true" required>
																								<option value="Idosos">Idosos</option>
																								<option value="Adultos">Adultos</option>
																								<option value="Jovens">Jovens</option>
																								<option value="Crianças">Crianças</option>
																							</select>
																						-->
																						<select class="custom-select custom-select-sm site-input" name="alvo_evento" required>>
																							<option <?php if(isset($GrupoAlvo_Evento)){echo "value=".$GrupoAlvo_Evento;}else{} ?> selected><?php if(isset($GrupoAlvo_Evento)){echo $GrupoAlvo_Evento;}else{echo "Escolha o tipo de compromisso";} ?></option>
																							<option value="Idosos">Idosos</option>
																							<option value="Adultos">Adultos</option>
																							<option value="Jovens">Jovens</option>
																							<option value="Crianças">Crianças</option>
																						</select>
																					</div>
																					<div class="col-md-6">
																						<label>Organização: </label>
																							<input class="site-input" readonly value="<?php if(isset($NomeOrganização_Evento)){echo $NomeOrganização_Evento;}else{echo $NomeOrganização_Evento;} ?>" maxlength="100" type="text" name="nomeorg_evento" placeholder="Insira o Nome" required>
																					</div>
																					<div class="col-md-12">
																						<label>Quantidade de helps gerada pelo programa: </label>
																							<input readonly class="site-input" value="<?php if(isset($Helps_Evento)){echo $Helps_Evento;} ?>" maxlength="50" type="text" name="helps_evento" placeholder="Insira o Nome">
																					</div>
																					<div class="col-md-12">
																						<p><span><input required class="form-check-input" type="checkbox" value="1" name="compromisse">Declaro que todos os dados fornecidos são <strong>Verdadeiros e Atualizados</span></p>
																					</div>
																			</div>
																		</div>
																			<div class="col-md-6">
																				<div class="section-title top_15 bottom_30"><span></span><h2>Área de atuação</h2></div>
																				<div class="row">
																						<div class="col-md-12">
																								<?php
																								$var1=false;
																								$var2=false;
																								$var3=false;
																								$var4=false;
																								$var5=false;
																								$var6=false;
																								$var7=false;
																								$var8=false;
																								$checn=mysqli_query($conn,"Select Nome from tblareaatucaoevento where IdEvento=".$IdEvento);
																								$n=0;
																								while ($segment=mysqli_fetch_array($checn)) {
																									$verif[$n]=$segment[0];
																									$n++;
																									echo $verif[$n];
																								}
																								if(!empty($verif)){
																									$op=count($verif);
																								for($a=0;$a<$op;$a++){
																										if($verif[$a]=='Ambiente'){
																											$var1=true;
																										}
																										if($verif[$a]=='Cidadania e Direitos'){
																											$var2=true;
																										}
																										if($verif[$a]=='Cultura e Artes'){
																											$var3=true;
																										}
																										if($verif[$a]=='Desporto e Lazer'){
																											$var4=true;
																										}
																										if($verif[$a]=='Educação'){
																											$var5=true;
																										}
																										if($verif[$a]=='Novas Tecnologias'){
																											$var6=true;
																										}
																										if($verif[$a]=='Saúde'){
																											$var7=true;
																										}
																										if($verif[$a]=='Solidariedade Social'){
																											$var8=true;
																										}
																									}
																								}
																								 ?>
																							<ul>
																									<li><p><span><input <?php if($var1==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Ambiente" name="checkbox[]"> Ambiente</span></p></li>
																									<li><p><span><input <?php if($var2==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Cidadania e Direitos" name="checkbox[]"> Cidadania e Direitos</span></p></li>
																									<li><p><span><input <?php if($var3==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Cultura e Artes" name="checkbox[]"> Cultura e Artes</span></p></li>
																									<li><p><span><input <?php if($var4==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Desporto e Lazer" name="checkbox[]"> Desporto e Lazer</span></p></li>
																									<li><p><span><input <?php if($var5==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Educação" name="checkbox[]"> Educação</span></p></li>
																									<li><p><span><input <?php if($var6==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Novas Tecnologias" name="checkbox[]"> Novas Tecnologias</span></p></li>
																									<li><p><span><input <?php if($var7==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Saúde" name="checkbox[]"> Saúde</span></p></li>
																									<li><p><span><input <?php if($var8==true){echo "checked";} ?> disabled class="form-check-input" type="checkbox" value="Solidariedade Social" name="checkbox[]"> Solidariedade Social</span></p></li>
																							</ul>
																						</div>
																				</div>
																				<div class="section-title top_15 bottom_30"><span></span><h2>Organizações</h2></div>
																					<div class="row">
																						<div class="col-md-12">
																							<div class="input-group">
																								<input type="text" class="form-control" placeholder="Procura por...">
																										<span class="input-group-btn">
																											<button class="btn btn-search" type="button"><i class="fa fa-search fa-fw"></i> Procurar</button>
																										</span>
																								</div>
																								<table class="table table-borderless">
																							  <thead>
																							    <tr>
																							      <th scope="col">#</th>
																							      <th scope="col">First</th>
																							      <th scope="col">Last</th>
																							      <th scope="col">Handle</th>
																							    </tr>
																							  </thead>
																							  <tbody>
																							    <tr>
																							      <th scope="row">1</th>
																							      <td>Mark</td>
																							      <td>Otto</td>
																							      <td>@mdo</td>
																							    </tr>
																							    <tr>
																							      <th scope="row">2</th>
																							      <td>Jacob</td>
																							      <td>Thornton</td>
																							      <td>@fat</td>
																							    </tr>
																							    <tr>
																							      <th scope="row">3</th>
																							      <td colspan="2">Larry the Bird</td>
																							      <td>@twitter</td>
																							    </tr>
																							  </tbody>
																							</table>
																						</div>
																						</div>
																					</div>
																			</div>

																		</div>
																		</div>
															      <div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
																			<button type="submit" name="GuardarFormulario" class="btn btn-primary">Guardar</button>
															      </div>
															    </div>
															  </div>
																</form>
															</div>

															<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															<form class="site-form" style="font-weight: normal;" id="Formzito" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"  enctype="multipart/form-data">
															  <div class="modal-dialog" role="document">
															    <div class="modal-content">
															      <div class="modal-header">
															        <h5 class="modal-title" id="exampleModalLabel">Inserir Registo</h5>
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span>
															        </button>
															      </div>
																		<div class="modal-body">
																		<div class="row">
																			<div class="col-md-6">
																				<div class="section-title top_15 bottom_30"><span></span><h2>Evento</h2></div>
																				<div class="row">
																					<div class="col-md-12">
																						<label>Nome: </label>
																							 <input class="site-input" maxlength="50" type="text" name="nome_ev" placeholder="Insira o Nome do Evento" required>
																					 </div>
																					<div class="col-md-12" style="padding-bottom: 10px;">
																						<label>Foto do Local: </label>
																							<input type="file" id="fileBut" name="fileBut" class="btn btn-primary" accept="image/png, image/jpeg" style="padding-top: 5px;max-width:100% " required>
																					</div>
																					<div class="col-md-12">
																						<label>Morada: </label>
																							<input class="site-input" maxlength="200" type="text" name="morada_ev" placeholder="Insira a morada" required>
																					</div>
																					<div class="col-md-6">
																					  <label>País: </label>
																							<input class="site-input" maxlength="100" type="text" name="pais_ev" placeholder="Insira o País" required>
																					</div>
																					<div class="col-md-6">
																						<label>Código Postal: </label>
																							<input class="site-input" maxlength="8" type="text" name="codpostal_ev" placeholder="Insira o Código Postal" required>
																					</div>
																					<div class="col-md-6">
																						<label>Distrito: </label>
																							<input class="site-input" maxlength="50" type="text" name="distrito_ev" placeholder="Insira o Distrito" required>
																					</div>
																					<div class="col-md-6">
																						<label>Concelho: </label>
																							<input class="site-input" maxlength="50" type="text" name="concelho_ev" placeholder="Insira o Concelho" required>
																					</div>
																					<div class="col-md-6">
																						<label>Freguesia: </label>
																							<input class="site-input" maxlength="50" type="text" name="freguesia_ev" placeholder="Insira a freguesia" required>
																					</div>
																					<div class="col-md-12">
																						<label>Função do Voluntário: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="500" type="text" name="funcaovol_ev" placeholder="Insira a função do Voluntário" required></textarea>
																					</div>
																					<div class="col-md-12">
																						<label>Breve Descrição: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="90" type="text" name="brevedesc_ev" placeholder="Insira uma breve descrição" required></textarea>
																					</div>
																					<div class="col-md-12">
																						<label>Descrição: </label>
																							<textarea style="resize: none;" class="site-input" maxlength="1000" type="text" name="descricao_ev" placeholder="Insira a descrição" required></textarea>
																					</div>
																					<div class="col-md-6">
																						<label>Data de Início: </label>
																							<input class="site-input" type="date" name="inicio_ev" placeholder="Insira a data de início" required>
																					</div>
																					<div class="col-md-6">
																						<label>Data de Fim: </label>
																							<input class="site-input" type="date" name="fim_ev" placeholder="Insira a data de fim" required>
																					</div>
																					<div class="col-md-6">
																						<label>Duração: </label>
																							<input class="site-input" type="number" name="Duracao_ev" placeholder="Insira a duração(em horas)" required>
																					</div>
																					<div class="col-md-6">
																						<label>Total de Vagas: </label>
																							<input class="site-input" type="number" name="numvagas_ev" placeholder="Insira o nº de vagas" required>
																					</div>
																					<div class="col-md-6">
																						<label>Idioma: </label>
																							<input class="site-input" maxlength="100" type="text" name="idioma_ev" placeholder="Insira o idioma do evento" required>
																					</div>
																					<div class="col-md-6">
																						<label>Compromisso: </label>
																							<select class="custom-select custom-select-sm site-input" name="Compromisso_ev" required>>
																								<option disabled selected>Escolha o tipo de compromisso</option>
																								<option value="Ocasional">Ocasional</option>
																								<option value="Regular">Regular</option>
																							</select>
																					</div>
																					<div class="col-md-6">
																						<label>Grupo Alvo: </label>
																						<!--
																							<select class="selectpicker custom-select custom-select-sm site-input" name="alvo_ev" multiple data-live-search="true" required>
																								<option value="Idosos">Idosos</option>
																								<option value="Adultos">Adultos</option>
																								<option value="Jovens">Jovens</option>
																								<option value="Crianças">Crianças</option>
																							</select>
																						-->
																						<select class="custom-select custom-select-sm site-input" name="alvo_ev" required>>
																							<option disabled selected>Escolha o alvo do evento</option>
																							<option value="Idosos">Idosos</option>
																							<option value="Adultos">Adultos</option>
																							<option value="Jovens">Jovens</option>
																							<option value="Crianças">Crianças</option>
																						</select>
																					</div>
																					<div class="col-md-6">
																						<label>Organização: </label>
																							<input class="site-input" readonly maxlength="100" type="text" name="nomeorg_ev" placeholder="Insira o Nome" required>
																					</div>
																					<div class="col-md-12">
																						<label>Nº de Helps</label>
																							<input readonly class="site-input" maxlength="50" type="text" name="helps_ev" placeholder="Automático">
																					</div>
																					<div class="col-md-12">
																						<p><span><input required class="form-check-input" type="checkbox" value="1" name="compromisse_ev">Declaro que todos os dados fornecidos são <strong>Verdadeiros e Atualizados</span></p>
																					</div>
																			</div>
																		</div>
																			<div class="col-md-6">
																				<div class="section-title top_15 bottom_30"><span></span><h2>Área de atuação</h2></div>
																				<div class="row">
																						<div class="col-md-12">
																							<ul>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Ambiente" name="check[]"> Ambiente</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Cidadania e Direitos" name="check[]"> Cidadania e Direitos</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Cultura e Artes" name="check[]"> Cultura e Artes</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Desporto e Lazer" name="check[]"> Desporto e Lazer</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Educação" name="check[]"> Educação</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Novas Tecnologias" name="check[]"> Novas Tecnologias</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Saúde" name="check[]"> Saúde</span></p></li>
																									<li><p><span><input class="form-check-input" type="checkbox" value="Solidariedade Social" name="check[]"> Solidariedade Social</span></p></li>
																							</ul>
																						</div>
																				</div>
																			</div>


																		</div>
																		</div>
															      <div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
																			<button type="submit" name="InserirFormulario" class="btn btn-primary">Guardar</button>
															      </div>
															    </div>
															  </div>
																</form>
															</div>


                        </form>
                    </section>
									</div>
								</div>



            <!-- Informação -->
            <div id="informacao">
              <div class="row">
								<?php
								if($msgvisos_org==1){
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
								}else if($msgvisos_org==2){
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
                <section class="contact-form col-md-6 padding_30 padbot_45">
                    <div class="section-title top_15 bottom_30"><span></span><h2>Informações <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
                    <form class="site-form" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data">
                        <div class="row">
													<div class="col-md-12" style="padding-bottom: 10px;">
														<label>Foto: </label>
														<input type="file" id="ficheiroup" name="ficheiroup" class="btn btn-primary" accept="image/png, image/jpeg" style="padding-top: 5px;" <?php if($escolherfoto==true){echo "required";} ?>>
													</div>
                            <div class="col-md-12">
															<label>Nome: </label>
                                <input class="site-input" value="<?php if(isset($nome)){echo $nome;} ?>" maxlength="100" type="text" name="nome" placeholder="Insira o Nome" required>
                            </div>
                            <div class="col-md-12">
															<label>Email: </label>
                                <input class="site-input" value="<?php if(isset($email)){echo $email;} ?>" maxlength="100" type="text" name="email" placeholder="Insira o Email" required>
                            </div>
														<div class="col-md-6">
															<label>Telefone: </label>
                                <input class="site-input" value="<?php if(isset($telefone)){echo $telefone;} ?>" maxlength="12" type="text" name="telefone" placeholder="Insira o nº de Telefone" required>
                            </div>
                            <div class="col-md-6">
															<label>Data de Fundação: </label>
                                <input class="site-input" value="<?php if(isset($datafundacao)){echo $datafundacao;} ?>" type="date" name="data_fund" placeholder="Insira a data de Fundação" required>
                            </div>
														<div class="col-md-12">
															<label>Website: </label>
																<input class="site-input" value="<?php if(isset($website)){echo $website;} ?>" maxlength="200" type="text" name="site" placeholder="Copie o URL do seu site" required>
														</div>
														<div class="col-md-6">
															<label>País: </label>
																<input class="site-input" value="<?php if(isset($pais)){echo $pais;} ?>" maxlength="70" type="text" name="pais" placeholder="Insira o seu País" required>
														</div>
														<div class="col-md-6">
															<label>Código-Postal: </label>
																<input class="site-input" value="<?php if(isset($codpostal)){echo $codpostal;} ?>" maxlength="8" type="text"  name="cod_pos" pattern="\d{4}-\d{3}" placeholder="Insira o seu Código-Postal (use )" required>
														</div>
														<div class="col-md-12">
															<label>Morada: </label>
																<input class="site-input" value="<?php if(isset($morada)){echo $morada;} ?>" maxlength="200" type="text" name="morada" placeholder="Insira a sua Morada" required>
														</div>
														<div class="col-md-6">
															<label>Distrito: </label>
																<input class="site-input" value="<?php if(isset($distrito)){echo $distrito;} ?>" maxlength="50" type="text" name="distrito" placeholder="Insira o seu Distrito" required>
														</div>
														<div class="col-md-6">
															<label>Concelho: </label>
																<input class="site-input" value="<?php if(isset($concelho)){echo $concelho;} ?>" maxlength="50" type="text"  name="concelho" placeholder="Insira o seu Concelho" required>
														</div>
														<div class="col-md-6">
															<label>Freguesia: </label>
																<input class="site-input" value="<?php if(isset($freguesia)){echo $freguesia;} ?>" maxlength="50" type="text"  name="freguesia" placeholder="Insira a sua Freguesia" required>
														</div>
														<!--
														<div class="col-md-12">
															<label>Habilitações: </label>
																<select class="custom-select custom-select-sm site-input" name="habilitacoes" required>>
																  <option <?php// if(isset($habilitacoes)){echo "value=".$habilitacoes;}else{} ?> selected><?php// if(isset($habilitacoes)){echo $habilitacoes;}else{echo "Escolha as suas Habilitações";} ?></option>
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
													-->
														<div class="col-md-12">
															<label>Facebook: </label>
																<input class="site-input" value="<?php if(isset($face)){echo $face;} ?>" maxlength="300" type="text" name="facebook" placeholder="Copie o url da sua página de facebook">
														</div>
														<div class="col-md-12">
															<label>Instagram: </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Instagram" placeholder="Copie o url da sua página de Instagram">
														</div>
														<div class="col-md-12">
															<label>Twitter: </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Twitter" placeholder="Copie o url da sua página de Twitter">
														</div>
														<div class="col-md-12">
															<label>Informação Adicional: </label>
																<textarea style="resize: none;" class="site-area" type="text" name="info" placeholder="Escreva alguma coisa sobre si!!!" required><?php if(isset($info)){echo $info;} ?></textarea>
														</div>
														<div class="col-md-12">
															<label>Missão: </label>
																<textarea style="resize: none;" class="site-area" type="text" name="missao" placeholder="Insira a missão da empresa" required><?php if(isset($missao)){echo $missao;} ?></textarea>
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

															<?php
															$var1=false;
															$var2=false;
															$var3=false;
															$var4=false;
															$var5=false;
															$var6=false;
															$var7=false;
															$var8=false;

															$checn=mysqli_query($conn,"Select Nome from tblareaatuacao where IdOrganizacao=".$identidade);
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
        <div class="name col-md-4 hidden-md hidden-sm hidden-xs"><?php echo $email; ?>.</div>
        <div class="copyright col-lg-8 col-md-12">© 2019 All rights reserved. Designed by <a href="https://themeforest.net/user/tavonline">tavonline</a> </div>
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
