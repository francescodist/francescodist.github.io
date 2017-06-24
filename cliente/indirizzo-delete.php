<?php
  include_once("../config.php");
  $id_indirizzo = $_GET["id"];
  $mysqli->query("DELETE FROM Indirizzo
                  WHERE id_indirizzo = $id_indirizzo");
  header("Location: profilo.php");
  EXIT;
?>
