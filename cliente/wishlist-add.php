<?php
  include_once("../config.php");
  //IL PARAMETRO OPTION DA INFO SULLA PAGINA DI PROVENIENZA
  $option = $_GET["option"];
  $id_scarpa = $_GET["id"];


  //CONTROLLO LOGIN
  if(isset($_SESSION["id_utente"])){
    $id_utente = $_SESSION["id_utente"];
  }
  else {//RIMANDA AL LOGIN SE NON PASSA CONTROLLO
    header("Location: http://localhost/JustShoes/login.php?option=wishlist&id=$id_scarpa");
    EXIT;
  }
  if($mysqli->query("INSERT INTO Wishlist (id_utente, id_scarpa)
                     VALUES ('$id_utente','$id_scarpa')")){
    if($option == "catalogo"){
      header("Location: http://localhost/JustShoes/shop/catalogo.php?wladd=1");
    }
    elseif($option == "index"){
      header("Location: http://localhost/JustShoes/index.php?wladd=1");
    }
    else{
      header("Location: http://localhost/JustShoes/shop/scarpa.php?wladd=1&id=$id_scarpa");
    }
  }
  else {
    if($option == "catalogo"){
      header("Location: http://localhost/JustShoes/shop/catalogo.php?wladd=0");
    }
    elseif($option == "index"){
      header("Location: http://localhost/JustShoes/index.php?wladd=0");
    }
    else{
      header("Location: http://localhost/JustShoes/shop/scarpa.php?wladd=0&id=$id_scarpa");
    }
  }

  EXIT;
?>
