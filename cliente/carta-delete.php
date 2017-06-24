<?php
  include_once("../config.php");
  $id_carta = $_GET["id"];
  $mysqli->query("DELETE FROM Carta_Di_Credito
                  WHERE id_carta = $id_carta");
  header("Location: profilo.php");
  EXIT;
?>
