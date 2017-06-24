<?php
  include_once("../config.php");
  $mysqli->query("DELETE FROM Wishlist
                  WHERE id_utente = $_SESSION[id_utente]
                  AND id_scarpa = $_GET[id]");
  echo "<script type='text/javascript'>history.go(-1);</script>";
  EXIT;
?>
