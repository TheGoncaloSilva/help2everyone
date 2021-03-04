<?php
include('./../inicligacao.ini');

session_start();
  $token=$_GET['token'];
  $verificar=mysqli_query($conn,"select * from tblrecuperarorg where Token='".$token."'");
  $con=mysqli_fetch_array($verificar);
  $IdOrganizacao=htmlspecialchars($con['IdOrganizacao']);

  if($IdOrganizacao==null){
    header('Location: ./index.php');
  }else{
    $_SESSION['tokenorg']=$token;
    header('Location: ./change.php');
  }

?>
