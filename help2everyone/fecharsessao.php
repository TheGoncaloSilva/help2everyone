<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['nome']);
header('Location: ./index.php');
session_destroy();
?>
