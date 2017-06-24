<?php
//RIDUCE DI 1 LA Q.TA DI UN ARTICOLO DEL CARRELLO
  include_once("../config.php");
  $key = $_GET["key"];
  echo var_dump($_SESSION["carrello"][$key]);
  if($_SESSION["carrello"][$key]["quantita"] > 1)
    $_SESSION["carrello"][$key]["quantita"]--;
  header("Location: carrello.php");
  EXIT;
 ?>
