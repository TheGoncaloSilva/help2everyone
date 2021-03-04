<?php
include('./../inicligacao.ini');

session_start();
  $token=$_GET['token'];
  $verificar=mysqli_query($conn,"select * from tblrecuperarvol where Token='".$token."'");
  $con=mysqli_fetch_array($verificar);
  $IdVoluntario=htmlspecialchars($con['IdVoluntario']);

  if($IdVoluntario==null){
    header('Location: ./index.php');
  }else{
    $_SESSION['token']=$token;
    header('Location: ./change.php');
  }

?>
