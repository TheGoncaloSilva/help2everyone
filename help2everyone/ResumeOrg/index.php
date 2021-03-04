<?php
	include('./../inicligacao.ini');
  session_start();
	$orgvinda=$_SESSION['targetorg'];
  if((isset ($_SESSION['user']) == true)){
	  $logado=$_SESSION['user'];
		$logaprovado=null;
		$logtype='Voluntario';
		$login=true;
	}else if((isset ($_SESSION['nome']) == true)){
    $logado=$_SESSION['nome'];
		$result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$logado."'");
		$logf=mysqli_fetch_array($result);
		$logaprovado=htmlspecialchars($logf['Aprovada']);
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
	$aprovado=0;
	$msgvisos=0;
	$msgvisos_org=0;
	$inserir=0;
	$ordem=1;
	$Id_Evento=null;

	$result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$orgvinda."'");
	$entrada=mysqli_fetch_array($result);
	$identidade=htmlspecialchars($entrada['Id']);
	$utilizador=htmlspecialchars($entrada['Nome']);
	$fotozinha=htmlspecialchars($entrada['Foto']);
	if($logtype=="Organizacao"){
	$buscar=mysqli_query($conn,"select * from tblorganizacao where Nome='".$logado."'");
	$con=mysqli_fetch_array($buscar);
	$Identidade_Company=htmlspecialchars($con['Id']);
	$Nome_Company=htmlspecialchars($con['Nome']);
}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['order']))
	{
		$ordem=$_GET['order'];
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['removeorg']))
	{
		$orgeliminar=$_GET['removeorg'];
		$eventeliminar=$_GET['removevent'];
		echo $orgeliminar.", ".$eventeliminar;
		mysqli_query($conn,"delete from tblorgevento where IdEvento=".$eventeliminar." && IdOrganizacao=".$orgeliminar);
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['removevol']))
	{
		$voleliminar=$_GET['removevol'];
		$eventeliminar=$_GET['removevent'];
		mysqli_query($conn,"delete from tblvolevento where IdEvento=".$eventeliminar." && IdVoluntario=".$voleliminar);
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['tirar']))
	{
		$ideliminar=$_GET['tirar'];
		mysqli_query($conn,"delete from tblorgevento where IdEvento=".$ideliminar." && IdOrganizacao=".$identidade);
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['meiopartido']))
	{
		$variavel=$_GET['meiopartido'];
		mysqli_query($conn,"Delete from tblpedidos where IdEvento='".$variavel."' && IdOrgPediu='".$Identidade_Company."' && IdOrgPedida='".$identidade."'");
		unset($_GET);
		header("Location: ".$_SERVER['PHP_SELF']."#colaborar");
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['adicionar']))
	{
		$variavel=$_GET['adicionar'];
		mysqli_query($conn,"insert into tblpedidos(IdOrgPediu,IdOrgPedida,IdEvento) values('".$Identidade_Company."','".$identidade."','".$variavel."')");
		unset($_GET);
		header("Location: ".$_SERVER['PHP_SELF']."#colaborar");
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['aceitar']))
	{
		$variavel=$_GET['aceitar'];
		mysqli_query($conn,"Delete from tblpedidos where IdEvento='".$variavel."' && IdOrgPedida='".$identidade."'");
		mysqli_query($conn,"insert into tblorgevento(IdEvento,IdOrganizacao) values('".$variavel."','".$identidade."')");
		unset($_GET);
		header("Location: ".$_SERVER['PHP_SELF']."#pedidos");
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['checar']))
	{
	$variavel=$_GET['checar'];
	mysqli_query($conn,"update tblpedidos set Visto=1 Where Id=".$variavel);
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']."#pedidos");
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['pedidoeliminar']))
	{
	$variavel=$_GET['pedidoeliminar'];
	mysqli_query($conn,"delete from tblpedidos where Id=".$variavel);
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']."#pedidos");
	}

		if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['unchecar']))
	{
	$variavel=$_GET['unchecar'];
	mysqli_query($conn,"update tblpedidos set Visto=0 Where Id=".$variavel);
	unset($_GET);
	header("Location: ".$_SERVER['PHP_SELF']."#pedidos");
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

		if(mysqli_query($conn,"insert into tblreportorg(Nome,Email,Tipo,Descricao,DataHora,Id_Organizacao) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
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

		if(mysqli_query($conn,"insert into tblreportorg(Nome,Email,Tipo,Descricao,DataHora,Id_Organizacao) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
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
		if(mysqli_query($conn,"insert into tblreportorg(Nome,Email,Tipo,Descricao,DataHora,Id_Organizacao) values('".$Nome_ocorrencia."','".$Email_ocorrencia."','".$tipo."','".$Descricao_ocorrencia."','".$dh."','".$identidade."')")){
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
	 $result=mysqli_query($conn,"select Id from tblvoluntario where Utilizador='".$logado."'");
	 $entrada=mysqli_fetch_array($result);
	 $IdOrg=htmlspecialchars($entrada['Id']);
		if(mysqli_query($conn,"insert into tblorgrating(IdOrganizacao,IdVoluntarioreviewer,Stars) values('".$identidade."','".$IdOrg."','".$estrelas."')")){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
		unset($_GET);
		header("Location: ".$_SERVER['PHP_SELF']);
	}

	if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updateall'])) {
		$password=null;
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
		if (!empty($_POST['password'])) {
			$pass=htmlspecialchars($_POST['password']);
			$pass=hash('sha256',$pass);
			$password=" , Password='".$pass."'";
		}
		$result=mysqli_query($conn,"select * from tblorganizacao where Nome='".$orgvinda."'");
		$entrada=mysqli_fetch_array($result);
		$foto_volz=htmlspecialchars($entrada['Foto']);

				$caminho=$_FILES['ficheiroup']['name'];
				$caminhoTmp=$_FILES['ficheiroup']['tmp_name'];
				if(!empty($caminho)){
					$explode=(explode('.',$caminho));
					$caminho=$identidade.time().'.'.$explode[1];
					$criar=move_uploaded_file($caminhoTmp, "./../Fotos/FotosOrg/".$caminho);

					if($foto_volz!="userimg.png"){
						unlink("./../Fotos/FotosOrg/".$foto_volz);
					}
				}else{
					$caminho=$fotozinha;
				}

		if(mysqli_query($conn,"update tblorganizacao set Foto='".$caminho."' , Nome='".$nome."' , Email='".$email."' , Telefone='".$telefone."'
		, Pais='".$pais."', Morada='".$morada."' , CodPostal='".$codpostal."' , Distrito='".$distrito."' , Concelho='".$concelho."' , Freguesia='".$freguesia."'
		, DataFundacao='".$datafundacao."' , PagFacebook='".$face."' , Website='".$website."' , PagTwitter='".$twit."' , PagInstagram='".$insta."'
		, Info='".$info."' , Missao='".$missao."'".$password." where id='".$identidade."'")){
			$msgvisos_org=1;
		}else{
			$msgvisos_org=2;
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
		 $tentar=mysqli_query($conn,"select Id from tblareaatuacao where Nome='".$idop."' && IdOrganizacao='".$identidade."'");
		 $verificar=mysqli_fetch_array($tentar);
		 if($verificar[0]!=null){
				 $cmdt=mysqli_query($conn,"select Nome from tblareaatuacao where IdOrganizacao='".$identidade."'");
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
							mysqli_query($conn,"Delete from tblareaatuacao where Nome='".$dado[$finalt]."' && IdOrganizacao='".$identidade."'");
					 }
				 }

			}else{
			mysqli_query($conn,"insert into tblareaatuacao(Nome,IdOrganizacao) values('".$idop."','".$identidade."')");
		 }
	 }
 }
 unset($_POST);
 header("Location: ".$_SERVER['PHP_SELF']);
}
/*
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
						mysqli_query($conn,"Delete from tblareaatucaoevento where Nome='".$dado[$finalt]."' && IdEvento='".$$Id_Evento."'");
				 }
			 }

		}else{
		mysqli_query($conn,"insert into tblareaatucaoevento(Nome,IdEvento) values('".$idop."','".$$Id_Evento."')");
	 }
 }
}
unset($_POST);
header("Location: ".$_SERVER['PHP_SELF']);
}*/

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

	$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
	$entrada=mysqli_fetch_array($company);
	$NomeOrganização_Evento=$entrada[0];
	$inserir=1;
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['Visualizar'])){
  $user=mysqli_query($conn,"select * from tblevento where Id=".$_GET['Visualizar']);
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

	$company=mysqli_query($conn,"select Nome from tblorganizacao where Id=".$IdOrganizacao);
	$entrada=mysqli_fetch_array($company);
	$NomeOrganização_Evento=$entrada[0];
	$inserir=3;
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['LimparFormulario'])){
	$Id_Evento=null;
  $Nome_Evento=null;
  $Pais_Evento=null;
  $Morada_Evento=null;
	$CodPostal_Evento=null;
	$Distrito_Evento=null;
	$Concelho_Evento=null;
	$Freguesia_Evento=null;
	$FuncVol_Evento=null;
	$BreveDesc_Evento=null;
	$Descricao_Evento=null;
	$NumVagas_Evento=null;
	$DataInicio_Evento=null;
	$DataFim_Evento=null;
	$Duracao_Evento=null;
	$Idioma_Evento=null;
	$Compromisso_Evento=null;
	$GrupoAlvo_Evento=null;
	$Helps_Evento=null;
	$IdOrganizacao=null;
	$NomeOrganização_Evento=null;
	$inserir=0;
}

	if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['eliminar'])){
	$delete=$_GET['eliminar'];

	$volunvaga=mysqli_query($conn,"select * from tblvolevento where IdEvento=".$delete);
	$aux=0;
	$info=array();
	while ($seg=mysqli_fetch_array($volunvaga)) {
		$info[$aux]=$seg[0];
		$aux++;
	}
	if($aux==null){

		$qapa=mysqli_query($conn,"Select Id from tbleventocomentario where IdEvento=".$delete);
		$row=mysqli_fetch_array($qapa);
		$Idcomentario1=htmlspecialchars($row['Id']);

		$user=mysqli_query($conn,"select FotoLocal from tblevento where Id=".$delete);
		$rows=mysqli_fetch_array($user);
		$FotoLocal=htmlspecialchars($row['FotoLocal']);

		if($FotoLocal!=null){
			unlink('./../Fotos/FotosEvent/'.$FotoLocal);
		}

		$apagar1=mysqli_query($conn,"delete from tblareaatucaoevento where IdEvento=".$delete);
		$apagar3=mysqli_query($conn,"delete from tbleventorating where IdEvento=".$delete);
		$apagar4=mysqli_query($conn,"delete from tblorgevento where IdEvento=".$delete);
		$apagar5=mysqli_query($conn,"delete from tblvolevento where IdEvento=".$delete);
		$apagar61=mysqli_query($conn,"delete from tblpedidos where IdEvento=".$delete);
		if(!empty($Idcomentario1)){
			$qapa=mysqli_query($conn,"Select Id from tbleventocomentario where IdEvento=".$delete);
			while($row=mysqli_fetch_array($qapa)){
				$Idcomentario1=htmlspecialchars($row['Id']);
				$oqapa=mysqli_query($conn,"Select Id from tblorgcomentario where IdComentario=".$Idcomentario1);
				while($row1=mysqli_fetch_array($oqapa)){
					$IdOrgcomentario1=htmlspecialchars($row1['Id']);
					$apagar7=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$IdOrgcomentario1);
					$apagar9=mysqli_query($conn,"delete from tblorgcomentario where IdComentario=".$Idcomentario1);
				}

				$apagar6=mysqli_query($conn,"delete from tblgostocomentario where IdComentario=".$Idcomentario1);
				$apagar8=mysqli_query($conn,"delete from tbleventocomentario where IdEvento=".$delete);
			}
			/*
			$oqapa=mysqli_query($conn,"Select * from tblorgcomentario where IdComentario=".$Idcomentario1);
			$row1=mysqli_fetch_array($oqapa);
			$IdOrgcomentario1=htmlspecialchars($row1['Id']);

			$apagar6=mysqli_query($conn,"delete from tblgostocomentario where IdComentario=".$Idcomentario1);
			$apagar7=mysqli_query($conn,"delete from tblgostoorgcomentario where IdOrgComentario=".$IdOrgcomentario1);
			$apagar9=mysqli_query($conn,"delete from tblorgcomentario where IdComentario=".$Idcomentario1);
			$apagar8=mysqli_query($conn,"delete from tbleventocomentario where IdEvento=".$delete);*/

		}
		if(mysqli_query($conn,"delete from tblevento where Id=".$delete)){
			$msgvisos=3;
		}else{
			$msgvisos=2;
		}
	}else{
		if(mysqli_query($conn,"update tblevento set Inativo=1 where Id=".$delete)){
			$msgvisos=1;
		}else{
			$msgvisos=2;
		}
	}
	unset($_GET);
	//header("Location: ".$_SERVER['PHP_SELF']);
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['sair'])){
	$ideliminar=$_GET['sair'];
	if(mysqli_query($conn,"delete from tblorgevento where IdEvento=".$ideliminar." && IdOrganizacao=".$identidade)){
		$msgvisos=1;
	}else{
		$msgvisos=2;
	}

}

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['GuardarFormulario'])){
		$Id_Evento=htmlspecialchars($_POST['id_evento']);
		if (!empty($_POST['nome_ev'])) {
	    $Nome_Evento=htmlspecialchars($_POST['nome_ev']);
	  }
		if (!empty($_POST['morada_ev'])) {
			$Morada_Evento=htmlspecialchars($_POST['morada_ev']);
		}
		if (!empty($_POST['pais_ev'])) {
			$Pais_Evento=htmlspecialchars($_POST['pais_ev']);
		}
		if (!empty($_POST['codpostal_ev'])) {
			$CodPostal_Evento=htmlspecialchars($_POST['codpostal_ev']);
		}
		if (!empty($_POST['distrito_ev'])) {
			$Distrito_Evento=htmlspecialchars($_POST['distrito_ev']);
		}
		if (!empty($_POST['concelho_ev'])) {
			$Concelho_Evento=htmlspecialchars($_POST['concelho_ev']);
		}
		if (!empty($_POST['freguesia_ev'])) {
			$Freguesia_Evento=htmlspecialchars($_POST['freguesia_ev']);
		}
		if (!empty($_POST['funcaovol_ev'])) {
			$FuncVol_Evento=htmlspecialchars($_POST['funcaovol_ev']);
		}
		if (!empty($_POST['brevedesc_ev'])) {
			$BreveDesc_Evento=htmlspecialchars($_POST['brevedesc_ev']);
		}
		if (!empty($_POST['descricao_ev'])) {
			$Descricao_Evento=htmlspecialchars($_POST['descricao_ev']);
		}
		if (!empty($_POST['inicio_ev'])) {
			$DataInicio_Evento=htmlspecialchars($_POST['inicio_ev']);
		}
		if (!empty($_POST['fim_ev'])) {
			$DataFim_Evento=htmlspecialchars($_POST['fim_ev']);
		}
		if (!empty($_POST['Duracao_ev'])) {
			$Duracao_Evento=htmlspecialchars($_POST['Duracao_ev']);
		}
		if (!empty($_POST['numvagas_ev'])) {
			$NumVagas_Evento=htmlspecialchars($_POST['numvagas_ev']);
		}
		if (!empty($_POST['idioma_ev'])) {
			$Idioma_Evento=htmlspecialchars($_POST['idioma_ev']);
		}
		if (!empty($_POST['Compromisso_evento'])) {
			$Compromisso_Evento=htmlspecialchars($_POST['Compromisso_evento']);
		}
		if (!empty($_POST['alvo_evento'])) {
			$GrupoAlvo_Evento=htmlspecialchars($_POST['alvo_evento']);
		}

		$aux=$Duracao_Evento*10;
		if($Compromisso_Evento=="Ocasional"){
			$aux2=($aux*0.05);
		}else{
			$aux2=($aux*0.15);
		}
		$Helps_Evento=($aux-$aux2);

		$result=mysqli_query($conn,"select * from tblevento where Nome='".$Nome_Evento."'");
		$entrada=mysqli_fetch_array($result);
		$foto_vol2=htmlspecialchars($entrada['FotoLocal']);

				$caminho2=$_FILES['uploadfile']['name'];
				$caminhoTmp2=$_FILES['uploadfile']['tmp_name'];
				if(!empty($caminho2)){
					$explode2=(explode('.',$caminho2));
					$caminho2=$identidade.time().'.'.$explode2[1];
					$criar2=move_uploaded_file($caminhoTmp2,"./../Fotos/FotosEvent/".$caminho2);

					if($foto_vol2!="default.png"){
						unlink("./../Fotos/FotosEvent/".$foto_vol2);
					}
				}else{
					$caminho2=$foto_vol2;
				}

		if(mysqli_query($conn,"update tblevento set FotoLocal='".$caminho2."' , Nome='".$Nome_Evento."' , Pais='".$Pais_Evento."', Morada='".$Morada_Evento."'
		, CodPostal='".$CodPostal_Evento."' , Distrito='".$Distrito_Evento."' , Concelho='".$Concelho_Evento."' , Freguesia='".$Freguesia_Evento."'
		, DataInicio='".$DataInicio_Evento."' , DataTermino='".$DataFim_Evento."' , FuncaoVoluntario='".$FuncVol_Evento."' , BreveDesc='".$BreveDesc_Evento."'
		, Descricao='".$Descricao_Evento."' , NumVagas='".$NumVagas_Evento."' , Duracao='".$Duracao_Evento."' , Idioma='".$Idioma_Evento."'
		, Compromisso='".$Compromisso_Evento."' , GrupoAlvo='".$GrupoAlvo_Evento."' , Quant_Helps='".$Helps_Evento."'  where Id=".$Id_Evento)){
				$msgvisos=1;
				$Id_Evento=null;
			  $Nome_Evento=null;
			  $Pais_Evento=null;
			  $Morada_Evento=null;
				$CodPostal_Evento=null;
				$Distrito_Evento=null;
				$Concelho_Evento=null;
				$Freguesia_Evento=null;
				$FuncVol_Evento=null;
				$BreveDesc_Evento=null;
				$Descricao_Evento=null;
				$NumVagas_Evento=null;
				$DataInicio_Evento=null;
				$DataFim_Evento=null;
				$Duracao_Evento=null;
				$Idioma_Evento=null;
				$Compromisso_Evento=null;
				$GrupoAlvo_Evento=null;
				$Helps_Evento=null;
				$IdOrganizacao=null;
				$NomeOrganização_Evento=null;
				$inserir=0;
		}else{
				$msgvisos=2;
		}
		unset($_POST);
		//header("Location: ".$_SERVER['PHP_SELF']);
	}
		if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['InserirFormulario'])){
		if (!empty($_POST['nome_ev'])) {
	    $Nome_Evento=htmlspecialchars($_POST['nome_ev']);
	  }
		if (!empty($_POST['morada_ev'])) {
			$Morada_Evento=htmlspecialchars($_POST['morada_ev']);
		}
		if (!empty($_POST['pais_ev'])) {
			$Pais_Evento=htmlspecialchars($_POST['pais_ev']);
		}
		if (!empty($_POST['codpostal_ev'])) {
			$CodPostal_Evento=htmlspecialchars($_POST['codpostal_ev']);
		}
		if (!empty($_POST['distrito_ev'])) {
			$Distrito_Evento=htmlspecialchars($_POST['distrito_ev']);
		}
		if (!empty($_POST['concelho_ev'])) {
			$Concelho_Evento=htmlspecialchars($_POST['concelho_ev']);
		}
		if (!empty($_POST['freguesia_ev'])) {
			$Freguesia_Evento=htmlspecialchars($_POST['freguesia_ev']);
		}
		if (!empty($_POST['funcaovol_ev'])) {
			$FuncVol_Evento=htmlspecialchars($_POST['funcaovol_ev']);
		}
		if (!empty($_POST['brevedesc_ev'])) {
			$BreveDesc_Evento=htmlspecialchars($_POST['brevedesc_ev']);
		}
		if (!empty($_POST['descricao_ev'])) {
			$Descricao_Evento=htmlspecialchars($_POST['descricao_ev']);
		}
		if (!empty($_POST['inicio_ev'])) {
			$DataInicio_Evento=htmlspecialchars($_POST['inicio_ev']);
		}
		if (!empty($_POST['fim_ev'])) {
			$DataFim_Evento=htmlspecialchars($_POST['fim_ev']);
		}
		if (!empty($_POST['Duracao_ev'])) {
			$Duracao_Evento=htmlspecialchars($_POST['Duracao_ev']);
		}
		if (!empty($_POST['numvagas_ev'])) {
			$NumVagas_Evento=htmlspecialchars($_POST['numvagas_ev']);
		}
		if (!empty($_POST['idioma_ev'])) {
			$Idioma_Evento=htmlspecialchars($_POST['idioma_ev']);
		}
		if (!empty($_POST['Compromisso_evento'])) {
			$Compromisso_Evento=htmlspecialchars($_POST['Compromisso_evento']);
		}
		if (!empty($_POST['alvo_evento'])) {
			$GrupoAlvo_Evento=htmlspecialchars($_POST['alvo_evento']);
		}
			$aux=$Duracao_Evento*10;
			if($Compromisso_Evento=="Ocasional"){
				$aux2=($aux*0.05);
			}else{
				$aux2=($aux*0.15);
			}
			$Helps_Evento=($aux-$aux2);

		$caminho2=$_FILES['uploadfile']['name'];
		$caminhoTmp2=$_FILES['uploadfile']['tmp_name'];
		$explode2=(explode('.',$caminho2));
		$caminho2=$identidade.time().'.'.$explode2[1];
		$criar2=move_uploaded_file($caminhoTmp2,"./../Fotos/FotosEvent/".$caminho2);

		if(mysqli_query($conn,"insert into tblevento(FotoLocal,Nome,Pais,Morada,CodPostal,Distrito,Concelho,Freguesia
		,FuncaoVoluntario,BreveDesc,Descricao,NumVagas,DataInicio,DataTermino,Duracao,Idioma,Compromisso,GrupoAlvo
		,Quant_Helps,IdOrganizacao) values('".$caminho2."','".$Nome_Evento."','".$Pais_Evento."','".$Morada_Evento."',
		'".$CodPostal_Evento."','".$Distrito_Evento."','".$Concelho_Evento."','".$Freguesia_Evento."','".$FuncVol_Evento."',
		'".$BreveDesc_Evento."', '".$Descricao_Evento."','".$NumVagas_Evento."' ,'".$DataInicio_Evento."','".$DataFim_Evento."',
		'".$Duracao_Evento."','".$Idioma_Evento."','".$Compromisso_Evento."','".$GrupoAlvo_Evento."','".$Helps_Evento."',
		'".$identidade."')")){
				$msgvisos=1;
				$Id_Evento=null;
				$Nome_Evento=null;
				$Pais_Evento=null;
				$Morada_Evento=null;
				$CodPostal_Evento=null;
				$Distrito_Evento=null;
				$Concelho_Evento=null;
				$Freguesia_Evento=null;
				$FuncVol_Evento=null;
				$BreveDesc_Evento=null;
				$Descricao_Evento=null;
				$NumVagas_Evento=null;
				$DataInicio_Evento=null;
				$DataFim_Evento=null;
				$Duracao_Evento=null;
				$Idioma_Evento=null;
				$Compromisso_Evento=null;
				$GrupoAlvo_Evento=null;
				$Helps_Evento=null;
				$IdOrganizacao=null;
				$NomeOrganização_Evento=null;
				$inserir=0;
		}else{
				$msgvisos=2;
		}


		$certo=mysqli_query($conn,"select Id from tblevento where IdOrganizacao='".$identidade."' order by Id Desc");
		$l1=0;
		$dado=array();;
		while ($valor=mysqli_fetch_array($certo)) {

			$dado[$l1]=$valor[0];
			$l1++;
		}
		$ar=count($dado);

		if(!empty($ar)){
			$chec=null;
			if(mysqli_query($conn,"insert into tblorgevento(IdEvento,IdOrganizacao) values('".$dado[0]."','".$identidade."')")){
				if(!empty($_POST['chec'])){
					$chec=$_POST['chec'];
				}
				if(!empty($chec)){
				 $tam=count($chec);
				 for($i=0;$i<$tam;$i++)
				 {
						if(mysqli_query($conn,"insert into tblareaatucaoevento(Nome,IdEvento) values('".$chec[$i]."','".$dado[0]."')")){
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


	unset($_POST);
	header("Location: ".$_SERVER['PHP_SELF']);
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
			$Aprovacao=htmlspecialchars($entrada['Aprovada']);

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
								$aprovado=1;
			}else if(empty($Aprovacao) && $falso==0){
				echo "<div class='alert alert-danger' role='alert'>
  							A sua conta ainda não foi aprovada, por isso irá ter funcionalidades mínimas!!!
								</div>";
								$aprovado=1;
			}


  ?>

<!-- Wrapper -->
<div class="wrapper top_60 container">
<div class="row">

	<?php

		if($logtype=="Voluntario"){
			$selectvalor=mysqli_query($conn,"select Id from tblvoluntario where Utilizador='".$logado."'");
			$convertvalor=mysqli_fetch_array($selectvalor);
			$IdOrg=htmlspecialchars($convertvalor['Id']);
			$selectvalues=mysqli_query($conn,"select Id from tblorgrating where IdOrganizacao=".$identidade." && IdVoluntarioreviewer='".$IdOrg."'");
			$convertvalues=mysqli_fetch_array($selectvalues);
			$IdOrg=htmlspecialchars($convertvalues['Id']);
			if($IdOrg==null){
				$avaluate="title='Avaliar a Organização!'";
			}else{
				$avaluate="disabled title='Já avaliou a Organização!'";
			}
		}else{
			$avaluate="disabled title='Precisa de ser um Voluntáro para avaliar uma Organização!'";
		}
		if($Aprovacao==0){
			$avaluate="disabled title='Organização não aprovada!'";
		}

		$rat=0;
		$media=0;
		$stars5=0;
		$stars4=0;
		$stars3=0;
		$stars2=0;
		$stars1=0;

		$starsbd=mysqli_query($conn,"select Id from tblorgrating where IdOrganizacao='".$identidade."'");

			$turn=0;
			$form=array();
			while ($ent=mysqli_fetch_array($starsbd)) {

				$form[$turn]=$ent[0];
				$turn++;
			}
			$tambd=count($form);
			if(!empty($tambd)){
			for($i=0;$i<$tambd;$i++){
				$searchbd=mysqli_query($conn,"select Stars from tblorgrating where Id='".$form[$i]."'");
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
            <span class="name"><?php echo $identidade."-".$nome; ?></span><br>
            <span class="job"><?php echo $pais; ?> - Organização</span>
        </div>
        <figure class="profile-image">
            <img src=<?php echo "./../Fotos/FotosOrg/".$foto; ?> alt="">
        </figure>
        <ul class="profile-information">
            <li></li>
            <li><p><span>Nome: </span><?php echo $nome; ?></p></li>
            <li><p><span>País: </span><?php echo $pais; ?></p></li>
						<li style="max-width:100px;"><p><span>Website: </span><?php echo $website; ?></p></li>
            <li><p><span>Data Fundacao: </span><?php echo $nascimento; ?></p></li>
            <li><p><span>Email: </span><?php echo $email; ?></p></li>
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
        <div class="col-md-12">
            <button <?php echo $avaluate; ?> class="site-btn icon" data-toggle='modal' data-target='#AvaliarModal'>Avaliar Organização <i class="fa fa-star"></i></button>
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
				<h5 class="modal-title">Avaliar <?php echo $orgvinda; ?></h5>
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
	if($logado!=$utilizador && $Aprovacao==1){
		$tab="<div class='search_button'><a href='#' data-toggle='modal' data-target='#ReportModal'><i class='fa fa-exclamation-triangle'></i></a></div>";
	}else{
		$tab=null;
	}

	$p=mysqli_query($conn,"Select Id from tblpedidos where Visto=0 &&	IdOrgPedida=".$identidade);
	$n=0;
	$guardar=array();
	while ($segmento=mysqli_fetch_array($p)) {

		$guardar[$n]=$segmento[0];
		$n++;
	}
	$tpedidos=count($guardar);
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
												<?php
												if($aprovado==0){
												 if($falso==1){

													$property="hidden";
													$property2="style='display:none;'";
													$propriedades="hidden";
													$propriedades2="style='display:none;'";
													if($logtype!="Organizacao" or $Aprovacao==0){
														$property3="style='display:none; '";
														$property31="hidden";
													}else{
														$property3=null;
														$property31=null;
													}
												}else{
													$property=null;
													$property2=null;
													$propriedades=null;
													$propriedades2=null;
													if($logtype=="Organizacao"){
														$property3="style='display:none; '";
														$property31="hidden";
													}else{
														$property3=null;
														$property31=null;
													}
													}
												}else{

													$property="hidden";
													$property2="style='display:none;'";
													$property3="style='display:none;'";
													$property31="hidden";
														$propriedades=null;
														$propriedades2=null;
												}
													?>
												<li class="tab"><a href="#resume">SOBRE</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#portfolio">PORTFOLIO</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#blog">BLOG</a></li>
                        <li class="tab" style="display:none;" hidden><a href="#contact">CONTACT</a></li>
												<li class="tab" <?php echo $property2; echo $property; ?>><a href="#create">CRIAR</a></li>
												<li class="tab" <?php echo $property2; echo $property; ?>><a href="#pedidos">PEDIDOS <?php if($tpedidos>=1){echo "<span class='badge badge-warning' style='color:white;background:orange'>".$tpedidos."";}?></a></li>
												<li class="tab" <?php echo $property3; echo $property31; ?>><a href="#colaborar">COLABORAR</a></li>
                        <li class="tab" <?php echo $propriedades2; echo $propriedades; ?>><a href="#informacao">INFORMAÇÕES</a></li>
												<?php echo $tab; ?>
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

		<!-- Reportar -->
		<div class="modal fade" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Reportar <?php echo $orgvinda; ?></h5>
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
											$checks=array();
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
								if($ordem==1){
									$ordenar="Desc";
								}else{
									$ordenar="Asc";
								}

								$cmd=mysqli_query($conn,"select IdEvento from tblorgevento where IdOrganizacao=".$identidade);
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
                                    <li><i class="fa fa-road" aria-hidden="true"></i><h2 class="timeline-title">Sobre</h2></li>
																		<?php
																		if(!empty($tamanho)){
																		if($notreg==false){
																			echo "
																			<li><p style='font-weight:bold;font-size: 16px;'>".$nome."</p>
	                                        <span>Fundada a: ".$nascimento."</span>
	                                    </li>
	                                    <li><p style='font-weight:bold;font-size: 16px;'>Localizar</p>
	                                        <span>".$distrito." , ".$concelho."</span>
	                                    </li>
	                                    <li><p style='font-weight:bold;font-size: 16px;'>Registo</p>
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
							}else if($msgvisos==3){
								echo "<div class='alert alert-success' role='alert'>
								<div class='row'>
									<div class='col-md-10'>
										<strong>sucesso! </strong>- Evento apagado com sucesso!!!
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
                    <section class="contact-form col-md-12 padding_30 padbot_45">
                        <div class="section-title top_15 bottom_30"><span></span><h2>Eventos existentes <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
												<div class="row">
													<div class="col-md-1" style="margin-top: 5px;border-right: 2px solid lightgrey;">
														<a href='./index.php?LimparFormulario#Formzito' class='btn btn-warning'><i class='fa fa-plus'></i></a>
													</div>
													<div class="col-md-5" style="margin-top: 5px;">
														<?php
														if($ordem==1){
															$escolher1="selected";
															$escolher2=null;
														}else{
															$escolher1=null;
															$escolher2="selected";
														}
														?>
														<form action="./index.php#create" method="GET">
															<select name='order' class="form-control" onchange='this.form.submit()'>
																<option value="1" <?php echo $escolher1; ?>>Ordenar por: Descendente</option>
																<option value="2" <?php echo $escolher2; ?>>Ordenar por: Ascendente</option>
															</select>
															<noscript><input type="submit" value="Submit"></noscript>
														</form>
													</div>
											</div>
											<hr/>
                        <form class="site-form">
                            <div class="row table-responsive text-center">
															<table class="table">
															  <thead class="thead-dark">
															    <tr>
																		<th scope="col"><i class="fa fa-cog"></i></th>
															      <th scope="col">Id</th>
																		<th scope="col">Estado</th>
															      <th scope="col">Nome Evento</th>
															      <th scope="col">Total Vagas</th>
															      <th scope="col">Vagas</th>
																		<th scope="col">Data de Início</th>
																		<th scope="col">Data Término</th>
															    </tr>
															  </thead>
															  <tbody>
																	<?php
																	if($ordem==1){
																		$ordenar="Desc";
																	}else{
																		$ordenar="Asc";
																	}

																	$cmd=mysqli_query($conn,"select IdEvento from tblorgevento where IdOrganizacao=".$identidade." order by Id ".$ordenar);
																	$a=0;
																	$val=array();

																		while ($use=mysqli_fetch_array($cmd)) {

																			$val[$a]=$use[0];
																			$a++;
																		}
																		$tamanho=count($val);

																	if(!empty($tamanho)){
																		for($i=0;$i<$tamanho;$i++){
																			$notreg=false;
																			$selecionar=mysqli_query($conn,"select * from tblevento where Id='".$val[$i]."' && Inativo=0");
																			$volunvaga=mysqli_query($conn,"select * from tblvolevento where IdEvento=".$val[$i]);
																			if(!empty($selecionar)){
																			$row=mysqli_fetch_array($selecionar);
																			$IdEvento=htmlspecialchars($row['Id']);
																			if(!empty($IdEvento)){
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
																		$Date=date_create($DataInicioEvento);
																		$Date2=date_create($DatafimEvento);

																		date_default_timezone_set('Europe/Lisbon');
																		$dh = date('Y-m-d');

																		$comp1= new DateTime($DatafimEvento);
																		$comp2= new DateTime($dh);
																		$comp3= new DateTime($DataInicioEvento);

																		if($comp3>$comp2 && $comp1>$comp2){
																			$estado="<span class='badge badge-danger' title='Inscrições para o evento abertas' style='color:white;background:green;'><i class='fa fa-check'></i> Ativo</span>";
																		}else if($comp3<=$comp2 && $comp1>=$comp2){
																			$estado="<span class='badge badge-info' title='Inscrições fechadas' ><i class='fa fa-clock-o'></i> Em execução</span>";
																		}else if($comp1<$comp2 && $comp3<$comp2){
																			$estado="<span class='badge badge-success' style='color:white;background:red;' title='Evento Inativo' ><i class='fa fa-times'></i> Inativo</span>";
																		}

																		if($Orgs!=$identidade){
																			$disable=" disabled";
																			$out="<a style='margin-top:3px;' href='./index.php?sair=".$IdEvento."#create' class='btn btn-danger'><i class='fa fa-sign-out'></i></a>";
																		}else{
																			$disable=null;
																			$out="<a style='margin-top:3px;' href='./index.php?eliminar=".$IdEvento."#create' class='btn btn-danger'><i class='fa fa-times'></i></a>";
																		}

																				echo "
																				<tr>
																				<td style='width:145px;'><a style='margin-top:3px;' href='./index.php?Visualizar=".$IdEvento."#Formzito' class='btn btn-info'><i class='fa fa-file-o'></i></a> ".$out." <a style='margin-top:3px;' class='btn btn-success".$disable."' href='./index.php?editar=".$IdEvento."#Formzito'><i class='fa fa-pencil-square-o'></i></a></td>
																				<td>".$IdEvento."</td>
																				<td>".$estado."</td>
																				<td>".$NomeEvento."</td>
																				<td>".$NumVagas."</td>
																				<td>".$tasm."</td>
																				<td>".date_format($Date,"d/m/Y")."</td>
																				<td>".date_format($Date2,"d/m/Y")."</td>
																				</tr>";
																			}
																		}
																	}
}
																		 ?>
															  </tbody>
															</table>

														</div>
														<div class="row">
														<!--<button disabled type='button' class='btn btn-secondary'><i class='fa fa-arrow-left'></i></button>-->
														<!--<button disabled type='button' class='btn btn-secondary'><i class='fa fa-arrow-right'></i></button>-->
													</div>
													<hr/>
                        </form>

												<div class="section-title top_15 bottom_20"><span></span><h2>Operações <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
													<form class="site-form" style="font-weight: normal;" id="Formzito" action="<?php echo $_SERVER['PHP_SELF']; ?>#create" method="POST" enctype="multipart/form-data">
												<div class="row">
													<div class="col-md-5">
														<div class="section-title top_15 bottom_30"><span></span><h2><?php if($inserir==0){echo "Inserir";}else if($inserir==1){echo "Editar";}else{echo "Visualizar";} ?> Evento</h2></div>
														<div class="row">
															<div class="col-md-12">
																<input hidden type="number" name="id_evento" value="<?php if(isset($Id_Evento)){echo $Id_Evento;} ?>">
																<label>Nome: </label>
																	 <input class="site-input" maxlength="50" value="<?php if(isset($Nome_Evento)){echo $Nome_Evento;} ?>" <?php if($inserir==3 || $inserir==1){echo "readonly";} ?> type="text" value="" name="nome_ev" placeholder="Insira o Nome do Evento" required>
															 </div>
															<div class="col-md-12" style="padding-bottom: 10px;">
																<label>Foto do Local: </label>
																	<input type="file" id="uploadfile" name="uploadfile" class="btn btn-primary" <?php if($inserir==3){echo "disabled";} ?> accept="image/png, image/jpeg" style="padding-top: 5px;max-width:100%;" <?php if($inserir==0){echo "required";} ?>>
															</div>
															<div class="col-md-12">
																<label>Morada: </label>
																	<input class="site-input" maxlength="200" value="<?php if(isset($Morada_Evento)){echo $Morada_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> type="text" name="morada_ev" placeholder="Insira a morada" required>
															</div>
															<div class="col-md-6">
																<label>País: </label>
																	<input class="site-input" maxlength="100" value="<?php if(isset($Pais_Evento)){echo $Pais_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> type="text" name="pais_ev" placeholder="Insira o País" required>
															</div>
															<div class="col-md-6">
																<label>Código Postal: </label>
																	<input class="site-input" maxlength="8" type="text" value="<?php if(isset($CodPostal_Evento)){echo $CodPostal_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> name="codpostal_ev" placeholder="Insira o Código Postal"  title="Insira o Código Postal com o formato ****-***" pattern="\d{4}-\d{3}" required>
															</div>
															<div class="col-md-6">
																<label>Distrito: </label>
																	<input class="site-input" maxlength="50" type="text" value="<?php if(isset($Distrito_Evento)){echo $Distrito_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> name="distrito_ev" placeholder="Insira o Distrito" required>
															</div>
															<div class="col-md-6">
																<label>Concelho: </label>
																	<input class="site-input" maxlength="50" type="text" value="<?php if(isset($Concelho_Evento)){echo $Concelho_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> name="concelho_ev" placeholder="Insira o Concelho" required>
															</div>
															<div class="col-md-6">
																<label>Freguesia: </label>
																	<input class="site-input" maxlength="50" type="text" value="<?php if(isset($Freguesia_Evento)){echo $Freguesia_Evento;} ?>" <?php if($inserir==3){echo "readonly";} ?> name="freguesia_ev" placeholder="Insira a freguesia" required>
															</div>
															<div class="col-md-12">
																<label>Função do Voluntário: </label>
																	<textarea style="resize: none;" class="site-input" maxlength="500" type="text" name="funcaovol_ev" placeholder="Insira a função do Voluntário" <?php if($inserir==3){echo "readonly";} ?> required><?php if(isset($FuncVol_Evento)){echo $FuncVol_Evento;} ?></textarea>
															</div>
															<div class="col-md-12">
																<label>Breve Descrição: </label>
																	<textarea style="resize: none;" class="site-input" maxlength="90" type="text" name="brevedesc_ev" placeholder="Insira uma breve descrição" <?php if($inserir==3){echo "readonly";} ?> required><?php if(isset($BreveDesc_Evento)){echo $BreveDesc_Evento;} ?></textarea>
															</div>
															<div class="col-md-12">
																<label>Descrição: </label>
																	<textarea style="resize: none;" class="site-input" maxlength="1000" type="text" name="descricao_ev" placeholder="Insira a descrição" <?php if($inserir==3){echo "readonly";} ?> required><?php if(isset($Descricao_Evento)){echo $Descricao_Evento;} ?></textarea>
															</div>
															<div class="col-md-6">
																<label>Data de Início: </label>
																	<input class="site-input" type="date" value="<?php if(isset($DataInicio_Evento)){echo $DataInicio_Evento;} ?>" name="inicio_ev" <?php if($inserir==3 || $inserir==1){echo "readonly";} ?> placeholder="Insira a data de início" required>
															</div>
															<div class="col-md-6">
																<label>Data de Fim: </label>
																	<input class="site-input" type="date" value="<?php if(isset($DataFim_Evento)){echo $DataFim_Evento;} ?>" name="fim_ev" <?php if($inserir==3 || $inserir==1){echo "readonly";} ?> placeholder="Insira a data de fim" required>
															</div>
															<div class="col-md-6">
																<label>Duração: </label>
																	<input class="site-input" type="number" value="<?php if(isset($Duracao_Evento)){echo $Duracao_Evento;} ?>" name="Duracao_ev" <?php if($inserir==3){echo "readonly";} ?> placeholder="Insira a duração(em horas)" min="0" required>
															</div>
															<div class="col-md-6">
																<label>Total de Vagas: </label>
																	<input class="site-input" type="number" value="<?php if(isset($NumVagas_Evento)){echo $NumVagas_Evento;} ?>" name="numvagas_ev" <?php if($inserir==3){echo "readonly";} ?> placeholder="Insira o nº de vagas" min="0" required>
															</div>
															<div class="col-md-6">
																<label>Idioma: </label>
																	<input class="site-input" maxlength="100" value="<?php if(isset($Idioma_Evento)){echo $Idioma_Evento;} ?>" type="text" name="idioma_ev" <?php if($inserir==3){echo "readonly";} ?> placeholder="Insira o idioma do evento" required>
															</div>
															<div class="col-md-6">
																<label>Compromisso: </label>
																	<select <?php if($inserir==3){echo "disabled";} ?> class="custom-select custom-select-sm site-input" name="Compromisso_evento" required>>
																		<option <?php if(isset($Compromisso_Evento)){echo "value=".$Compromisso_Evento;}else{echo "disabled";} ?> selected><?php if(isset($Compromisso_Evento)){echo $Compromisso_Evento;}else{echo "Escolha o tipo de compromisso";} ?></option>
																		<option value="Ocasional">Ocasional</option>
																		<option value="Regular">Regular</option>
																	</select>
															</div>
															<div class="col-md-6">
																<label>Grupo Alvo: </label>
																<select <?php if($inserir==3){echo "disabled";} ?> class="custom-select custom-select-sm site-input" name="alvo_evento" required>>
																	<option <?php if(isset($GrupoAlvo_Evento)){echo "value=".$GrupoAlvo_Evento;}else{echo "disabled";} ?> selected><?php if(isset($GrupoAlvo_Evento)){echo $GrupoAlvo_Evento;}else{echo "Escolha o tipo de compromisso";} ?></option>
																	<option value="Idosos">Idosos</option>
																	<option value="Adultos">Adultos</option>
																	<option value="Jovens">Jovens</option>
																	<option value="Crianças">Crianças</option>
																</select>
															</div>
															<div class="col-md-6">
																<label>Organização: </label>
																	<input class="site-input" value="<?php if(isset($NomeOrganização_Evento)){echo $NomeOrganização_Evento;} ?>" readonly maxlength="100" type="text" name="nomeorg_ev" placeholder="Automático" required>
															</div>
															<div class="col-md-12">
																<label>Nº de Helps</label>
																	<input readonly class="site-input" value="<?php if(isset($Helps_Evento)){echo $Helps_Evento;} ?>" maxlength="50" type="text" name="helps_ev" placeholder="Automático">
															</div>
															<div class="col-md-12">
																<p><span><input required class="form-check-input" type="checkbox" value="1" name="compromisse_ev">Declaro que todos os dados fornecidos são <strong>Verdadeiros e Atualizados</span></p>
															</div>
													</div>
												</div>
													<div class="col-md-7">
														<div class="section-title top_15 bottom_30"><span></span><h2>Área de atuação Evento</h2></div>
														<div class="row">
																<div class="col-md-12">
																	<ul>
																		<?php

																		$vars1=false;
																		$vars2=false;
																		$vars3=false;
																		$vars4=false;
																		$vars5=false;
																		$vars6=false;
																		$vars7=false;
																		$vars8=false;

																		if(!empty($Id_Evento)){
																		$checn=mysqli_query($conn,"Select Nome from tblareaatucaoevento where IdEvento=".$Id_Evento);
																		$n=0;
																		$verificar=array();
																		while ($segmento=mysqli_fetch_array($checn)) {

																			$verificar[$n]=$segmento[0];
																			$n++;
																		}
																		if(!empty($verificar)){
																			$op=count($verificar);
																		for($a=0;$a<$op;$a++){
																				if($verificar[$a]=='Ambiente'){
																					$vars1=true;
																				}
																				if($verificar[$a]=='Cidadania e Direitos'){
																					$vars2=true;
																				}
																				if($verificar[$a]=='Cultura e Artes'){
																					$vars3=true;
																				}
																				if($verificar[$a]=='Desporto e Lazer'){
																					$vars4=true;
																				}
																				if($verificar[$a]=='Educação'){
																					$vars5=true;
																				}
																				if($verificar[$a]=='Novas Tecnologias'){
																					$vars6=true;
																				}
																				if($verificar[$a]=='Saúde'){
																					$vars7=true;
																				}
																				if($verificar[$a]=='Solidariedade Social'){
																					$vars8=true;
																				}
																			}
																		}
																	}
																		 ?>
																			<li><p><span><input <?php if($vars1==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Ambiente" name="chec[]"> Ambiente</span></p></li>
																			<li><p><span><input <?php if($vars2==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Cidadania e Direitos" name="chec[]"> Cidadania e Direitos</span></p></li>
																			<li><p><span><input <?php if($vars3==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Cultura e Artes" name="chec[]"> Cultura e Artes</span></p></li>
																			<li><p><span><input <?php if($vars4==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Desporto e Lazer" name="chec[]"> Desporto e Lazer</span></p></li>
																			<li><p><span><input <?php if($vars5==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Educação" name="chec[]"> Educação</span></p></li>
																			<li><p><span><input <?php if($vars6==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Novas Tecnologias" name="chec[]"> Novas Tecnologias</span></p></li>
																			<li><p><span><input <?php if($vars7==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Saúde" name="chec[]"> Saúde</span></p></li>
																			<li><p><span><input <?php if($vars8==true){echo "checked";} ?> <?php if($inserir==3 || $inserir==1){echo "disabled";} ?> class="form-check-input" type="checkbox" value="Solidariedade Social" name="chec[]"> Solidariedade Social</span></p></li>
																	</ul>
																</div>
														</div>
														<div class="col-md-6">
															<?php if($Id_Evento!=null){echo "<div class='section-title top_15 bottom_30'><span></span><h2>Organizações</h2></div>";} ?>
															<ul class="list-group">
																<?php
																if($Id_Evento!=null){
																$compa=mysqli_query($conn,"Select IdOrganizacao from tblorgevento where IdEvento=".$Id_Evento);
																$n=0;
																while ($segm=mysqli_fetch_array($compa)) {
																	$org=mysqli_query($conn,"Select Nome from tblorganizacao where Id=".$segm[0]);
																	$value=mysqli_fetch_array($org);
																	if($utilizador==$value[0]){
																		echo "<li class='list-group-item'><a>".$segm[0]." - ".$value[0]."</a></li>";
																	}else{
																		if($inserir==3){
																			echo "<li class='list-group-item'><a>".$segm[0]." - ".$value[0]."</a></li>";
																		}else{
																		echo "<li class='list-group-item'><a href='index.php?removeorg=".$segm[0]."&removevent=".$Id_Evento."#create' style='color:red;' title='Remover do Evento'><i class='fa fa-trash-o'></i></a> | <a href='./../listagem.php?open_org=".$value[0]."'>".$segm[0]." - ".$value[0]."</a></li>";
																	}
																	}
																	$n++;
																}
																if($n==0){
																	echo "<p>Sem Organizações adicionadas</p>";
																}
															}
																?>
															</ul>
															<?php if($Id_Evento!=null){echo "<div class='section-title top_15 bottom_30'><span></span><h2>Voluntários</h2></div>";} ?>
															<?php
															if($Id_Evento!=null){
															$volunvaga=mysqli_query($conn,"select IdVoluntario from tblvolevento where IdEvento=".$Id_Evento);
															$numvol=0;
															while ($entrance=mysqli_fetch_array($volunvaga)) {
																$org=mysqli_query($conn,"Select Utilizador from tblvoluntario where Id=".$entrance[0]);
																$value=mysqli_fetch_array($org);
																if($inserir==3){
																	echo "<li class='list-group-item'><a href='./../listagem.php?open_vol=".$value[0]."'>".$entrance[0]." - ".$value[0]."</a></li>";
																}else{
																	echo "<li class='list-group-item'><a href='index.php?removevol=".$entrance[0]."&removevent=".$Id_Evento."#create' style='color:red;' title='Remover do Evento'><i class='fa fa-trash-o'></i></a> | <a href='./../listagem.php?open_vol=".$value[0]."'>".$entrance[0]." - ".$value[0]."</a></li>";
																}
																$numvol++;
															}
															if($numvol==0){
																echo "<p>Sem Voluntários adicionados</p>";
															}
														}
															?>
														</div>
													</div>
												</div>
												<div class="col-md-12 text-center" style="padding-top:15px;">
												<?php
												if($inserir==0){
													echo "<a href='./index.php?LimparFormulario#create' class='btn btn-primary'><i class='fa fa-times'></i> Limpar Dados</a> ";
													echo "<button type='submit' name='InserirFormulario' class='btn btn-success'><i class='fa fa-plus'></i> Inserir Evento</button>";
												}else if($inserir==1){
													echo "<a href='./index.php?LimparFormulario' class='btn btn-primary'><i class='fa fa-times'></i> Limpar Dados</a> ";
													echo "<button type='submit' name='GuardarFormulario' class='btn btn-success'><i class='fa fa-save'></i> Guardar Evento</button>";
												}else{

												}
												?>
											</div>
											</form>

                    </section>
									</div>
								</div>

								<!-- Pedidos Page
								================================================== -->
								<div id="pedidos">
									<?php if($property!=null){echo "<p>Não é possível aceder à página, <a href='index.php'>retroceder</a> para segurança.</p>";} ?>
									<div class="row" style="font-weight:normal;" <?php if($property!=null){echo "disabled hidden";} ?>>
											<section class="contact-form col-md-12 padding_30 padbot_45">
													<div class="section-title top_15 bottom_15"><span></span><h2>Pedidos</h2></div>
														<p style="font-size:normal;padding-bottom:15px;">Pedidos recebidos para colaborar em eventos de outras organizações, pode aceitar, eliminar ou contactar a organização.</p>
													</hr>
													<form class="site-form">
															<div class="row table-responsive text-center">
																<table class="table">
																	<thead class="thead-dark">
																		<tr>
																			<th scope="col" style="width:150px;"><i class="fa fa-cog"></i></th>
																			<th scope="col">Id</th>
																			<th scope="col">Organização (Nome)</th>
																			<th scope="col">Evento (Nome)</th>
																			<th scope="col">Vagas (Total)</th>
																			<th scope="col">Data de Início</th>
																			<th scope="col">Data Término</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		$cmd=mysqli_query($conn,"select Id from tblpedidos where IdOrgPedida=".$identidade." order by Id Desc");
																		$a=0;
																		$val=array();

																			while ($use=mysqli_fetch_array($cmd)) {

																				$val[$a]=$use[0];
																				$a++;
																			}
																			$tamanho=count($val);

																		if(!empty($tamanho)){
																			for($i=0;$i<$tamanho;$i++){
																				$notreg=false;
																				$selecionar=mysqli_query($conn,"select * from tblpedidos where Id='".$val[$i]."'");
																				if(!empty($selecionar)){
																				$conver=mysqli_fetch_array($selecionar);
																				$IdPedido=htmlspecialchars($conver['Id']);
																				$IdOrgPediu=htmlspecialchars($conver['IdOrgPediu']);
																				$IdOrgPedida=htmlspecialchars($conver['IdOrgPedida']);
																				$IdEvent=htmlspecialchars($conver['IdEvento']);
																				$Visto=htmlspecialchars($conver['Visto']);

																				$search=mysqli_query($conn,"select * from tblorganizacao where Id='".$IdOrgPediu."'");
																				$c=mysqli_fetch_array($search);
																				$NomeOrg=htmlspecialchars($c['Nome']);
																				$EmailOrg=htmlspecialchars($c['Email']);

																				$pesquisar=mysqli_query($conn,"select * from tblevento where Id='".$IdEvent."'");
																				$row=mysqli_fetch_array($pesquisar);
																				$IdEvento=htmlspecialchars($row['Id']);
																				$NomeEvento=htmlspecialchars($row['Nome']);
																				$FotoLocal=htmlspecialchars($row['FotoLocal']);
																				$DescEvento=htmlspecialchars($row['Descricao']);
																				$NumVagas=htmlspecialchars($row['NumVagas']);
																				$DataInicioEvento=htmlspecialchars($row['DataInicio']);
																				$DatafimEvento=htmlspecialchars($row['DataTermino']);
																			date_default_timezone_set('Europe/Lisbon');
																			$dh = date('Y-m-d');

																			$comp1= new DateTime($DatafimEvento);
																			$comp2= new DateTime($dh);

																			$Date3=date_create($DataInicioEvento);
																			$Date4=date_create($DatafimEvento);

																			if($Visto==0){
																				$out="<a href='./index.php?aceitar=".$IdEvent."#colaborar' title='Aceitar Pedido' class='btn btn-success'><i class='fa fa-check'></i></a>";
																				$out2="<a href='./index.php?pedidoeliminar=".$IdPedido."#colaborar' title='Eliminar Pedido' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
																				$out3="<a href='./index.php?checar=".$IdPedido."#colaborar' title='Marcar Lido' class='btn btn-warning'><i class='fa fa-heart-o'></i></a>";
																			}else{
																				$out="<a href='./index.php?aceitar=".$IdEvent."#colaborar' title='Aceitar Pedido' class='btn btn-success'><i class='fa fa-check'></i></a>";
																				$out2="<a href='./index.php?pedidoeliminar=".$IdPedido."#colaborar' title='Eliminar Pedido' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
																				$out3="<a href='./index.php?unchecar=".$IdPedido."#colaborar' title='Desmarcar Lido' class='btn btn-warning'><i class='fa fa-heart'></i></a>";
																			}

																					echo "
																					<tr>
																					<td>".$out." ".$out3." ".$out2."</td>
																					<td>".$IdPedido."</td>
																					<td>".$NomeOrg."</td>
																					<td>".$NomeEvento."</td>
																					<td>".$NumVagas."</td>
																					<td>".date_format($Date3,"d/m/Y")."</td>
																					<td>".date_format($Date4,"d/m/Y")."</td>
																					</tr>";
																				}
																			}
																		}
																			 ?>
																	</tbody>
																</table>

															</div>
													</form>
											</section>
										</div>

								</div>
								<!-- End Pedidos
								================================================== -->


								<!-- COLABORAR Page
		            ================================================== -->
								<div id="colaborar">
									<?php if($property3!=null or $Aprovacao==0){echo "<p>Não é possível aceder à página, <a href='index.php'>retroceder</a> para segurança.</p>";} ?>
		                <div class="row" style="font-weight:normal;"<?php if($property3!=null or $Aprovacao==0){echo "disabled hidden";} ?>>
		                    <section class="contact-form col-md-12 padding_30 padbot_45">
		                        <div class="section-title top_15 bottom_15"><span></span><h2>Eventos Disponívies</h2></div>
															<p style="font-size:normal;padding-bottom:15px;">Colaborar ou remover esta empresa nos seus seguintes eventos.</p>
														</hr>
		                        <form class="site-form">
		                            <div class="row table-responsive text-center">
																	<table class="table">
																	  <thead class="thead-dark">
																	    <tr>
																				<th scope="col"><i class="fa fa-cog"></i></th>
																	      <th scope="col">Id</th>
																				<th scope="col">Estado</th>
																	      <th scope="col">Nome Evento</th>
																	      <th scope="col">Total Vagas</th>
																	      <th scope="col">Vagas</th>
																				<th scope="col">Data de Início</th>
																				<th scope="col">Data Término</th>
																	    </tr>
																	  </thead>
																	  <tbody>
																			<?php
																			$cmd=mysqli_query($conn,"select Id from tblevento where IdOrganizacao=".$Identidade_Company." order by Id Desc");
																			$a=0;
																			$val=array();

																				while ($use=mysqli_fetch_array($cmd)) {

																					$val[$a]=$use[0];
																					$a++;
																				}
																				$tamanho=count($val);

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
																				date_default_timezone_set('Europe/Lisbon');
																				$dh = date('Y-m-d');

																				$comp1= new DateTime($DatafimEvento);
																				$comp2= new DateTime($dh);
																				$comp3= new DateTime($DataInicioEvento);

																				if($comp3>$comp2 && $comp1>$comp2){
																					$estado="<span class='badge badge-danger' title='Inscrições para o evento abertas' style='color:white;background:green;'><i class='fa fa-check'></i> Ativo</span>";
																					$testar=1;
																				}else if($comp3<=$comp2 && $comp1>=$comp2){
																					$estado="<span class='badge badge-info' title='Inscrições fechadas' ><i class='fa fa-clock-o'></i> Em execução</span>";
																					$testar=2;
																				}else if($comp1<$comp2 && $comp3<$comp2){
																					$estado="<span class='badge badge-success' style='color:white;background:red;' title='Evento Inativo' ><i class='fa fa-times'></i> Inativo</span>";
																					$testar=2;
																				}

																				$pesquisa=mysqli_query($conn,"select IdOrganizacao from tblorgevento where IdOrganizacao=".$identidade." && IdEvento=".$IdEvento);
																				$converter=mysqli_fetch_array($pesquisa);
																				$verific=htmlspecialchars($converter['IdOrganizacao']);

																				if($identidade==$verific){
																					$out="<a href='./index.php?tirar=".$IdEvento."#colaborar' title='Remover a Organização do Evento' class='btn btn-danger'><i class='fa fa-sign-out'></i></a>";
																				}else{
																					$pesquisa=mysqli_query($conn,"select IdOrgPedida from tblpedidos where IdOrgPedida=".$identidade." && IdEvento=".$IdEvento);
																					$converter=mysqli_fetch_array($pesquisa);
																					$verific2=htmlspecialchars($converter['IdOrgPedida']);

																					if($identidade==$verific2){
																						$out="<a href='./index.php?meiopartido=".$IdEvento."#colaborar' title='Pedido para aderir ao Evento enviado' class='btn btn-warning'><i class='fa fa-upload'></i></a>";
																					}else{
																						if($testar==2){
																							$out="<a title='Evento Inativo' class='btn btn-danger'><i class='fa fa-ban'></i></a>";
																						}else if($testar==3){

																						}else{
																							$out="<a href='./index.php?adicionar=".$IdEvento."#colaborar' title='Adicionar Organização ao Evento' class='btn btn-success'><i class='fa fa-plus'></i></a>";
																						}

																					}
																				}
																				$Date5=date_create($DataInicioEvento);
																				$Date6=date_create($DatafimEvento);

																						echo "
																						<tr>
																						<td>".$out."</td>
																						<td>".$IdEvento."</td>
																						<td>".$estado."</td>
																						<td>".$NomeEvento."</td>
																						<td>".$NumVagas."</td>
																						<td>".$tasm."</td>
																						<td>".date_format($Date5,"d/m/Y")."</td>
																						<td>".date_format($Date6,"d/m/Y")."</td>
																						</tr>";
																					}
																				}
		}
																				 ?>
																	  </tbody>
																	</table>

																</div>
																<div class="row">
																<!--<button disabled type='button' class='btn btn-secondary'><i class='fa fa-arrow-left'></i></button>-->
																<!--<button disabled type='button' class='btn btn-secondary'><i class='fa fa-arrow-right'></i></button>-->
															</div>
		                        </form>

		                    </section>
											</div>

								</div>
								<!-- End COLABORAR
								================================================== -->



            <!-- Informação -->
            <div id="informacao">
							<?php if($propriedades!=null){echo "<p>Não é possível aceder à página, <a href='index.php'>retroceder</a> para segurança.</p>";} ?>
              <div class="row" <?php if($propriedades!=null){echo "disabled hidden";} ?>>
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
                    <div class="section-title top_15 bottom_10"><span></span><h2>Informações <a disabled title="Todas as Informações que nos fornecer serão guardadas com segurança, sendo esta seção oculta a todos os utilizadores" class="fa fa-question-circle"></a></h2></div>
										<p class="bottom_15">Campos obrigatórios marcados com *</p>
                    <form class="site-form" onsubmit="Checkfiles(fileup)" action="<?php echo $_SERVER['PHP_SELF']; ?>#informacao" method="POST"  enctype="multipart/form-data" style="font-weight: normal;">
                        <div class="row">
													<div class="col-md-12" style="padding-bottom: 10px;">
														<label>Foto<?php if($escolherfoto==true){echo "*";} ?> </label>
														<input type="file" id="ficheiroup" name="ficheiroup" class="btn btn-primary" accept="image/png, image/jpeg" style="padding-top: 5px;" <?php if($escolherfoto==true){echo "required";} ?>>
													</div>
                            <div class="col-md-12">
															<label>Nome* </label>
                                <input class="site-input" readonly value="<?php if(isset($nome)){echo $nome;} ?>" maxlength="100" type="text" name="nome" placeholder="Insira o Nome" required>
                            </div>
                            <div class="col-md-12">
															<label>Email* </label>
                                <input class="site-input" value="<?php if(isset($email)){echo $email;} ?>" maxlength="100" type="text" name="email" placeholder="Insira o Email" required>
                            </div>
														<div class="col-md-6">
															<label>Telefone* </label>
                                <input class="site-input" value="<?php if(isset($telefone)){echo $telefone;} ?>" minlength="9" maxlength="12" type="text" name="telefone" placeholder="Insira o nº de Telefone" required>
                            </div>
                            <div class="col-md-6">
															<label>Data de Fundação* </label>
                                <input class="site-input" value="<?php if(isset($datafundacao)){echo $datafundacao;} ?>" type="date" name="data_fund" placeholder="Insira a data de Fundação" required>
                            </div>
														<div class="col-md-12">
															<label>Website* </label>
																<input class="site-input" value="<?php if(isset($website)){echo $website;} ?>" maxlength="200" type="text" name="site" placeholder="Copie o URL do seu site" required>
														</div>
														<div class="col-md-6">
															<label>País* </label>
																<input class="site-input" value="<?php if(isset($pais)){echo $pais;} ?>" maxlength="70" type="text" name="pais" placeholder="Insira o seu País" required>
														</div>
														<div class="col-md-6">
															<label>Código-Postal* </label>
																<input class="site-input" value="<?php if(isset($codpostal)){echo $codpostal;} ?>" maxlength="8" type="text"  name="cod_pos" title="Insira o Código Postal com o formato ****-***" pattern="\d{4}-\d{3}" placeholder="Insira o seu Código-Postal (use )" required>
														</div>
														<div class="col-md-12">
															<label>Morada* </label>
																<input class="site-input" value="<?php if(isset($morada)){echo $morada;} ?>" maxlength="200" type="text" name="morada" placeholder="Insira a sua Morada" required>
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
															<label>Facebook </label>
																<input class="site-input" value="<?php if(isset($face)){echo $face;} ?>" maxlength="300" type="text" name="facebook" placeholder="Copie o url da sua página de facebook">
														</div>
														<div class="col-md-12">
															<label>Instagram </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Instagram" placeholder="Copie o url da sua página de Instagram">
														</div>
														<div class="col-md-12">
															<label>Twitter </label>
																<input class="site-input" value="<?php if(isset($insta)){echo $insta;} ?>" maxlength="300" type="text" name="Twitter" placeholder="Copie o url da sua página de Twitter">
														</div>
														<div class="col-md-12">
															<label>Informação Adicional* </label>
																<textarea style="resize: none;" class="site-area" type="text" name="info" placeholder="Escreva alguma coisa sobre si!!!" required><?php if(isset($info)){echo $info;} ?></textarea>
														</div>
														<div class="col-md-12">
															<label>Missão* </label>
																<textarea style="resize: none;" class="site-area" type="text" name="missao" placeholder="Insira a missão da empresa" required><?php if(isset($missao)){echo $missao;} ?></textarea>
														</div>
														<div class="col-md-12">
															<label>Palavra-Passe </label>
																<input class="site-input" maxlength="100" minlength=4 type="text" name="password" placeholder="Mudar Palavra-Passe">
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
