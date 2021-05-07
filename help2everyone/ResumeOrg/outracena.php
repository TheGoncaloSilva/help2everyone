<?php

  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    if (!empty($_POST['alvo_evento'])) {
	    $nome=htmlspecialchars($_POST['alvo_evento']);
      echo $nome;
	  }
   }
 ?>

<!DOCTYPE html>
<!--[if lt IE 9 ]><html class="no-js oldie" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="pt">
<!--<![endif]-->

<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>PhArquive</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="icon" href="./logo.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
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

</head>

<body id="top">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="col-md-6">
    <label>Grupo Alvo: </label>
    <select class="selectpicker custom-select custom-select-sm site-input" name="alvo_evento" multiple data-live-search="true" required>
      <option value="Regular">Idosos</option>
      <option value="Ocasional">Adultos</option>
      <option value="Regular">Jovens</option>
      <option value="Regular">Crianças</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Guardar</button>
</form>
  <script> $('select').selectpicker();</script>


    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>


</body>
</html>
