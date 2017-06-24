<?php
  include_once("../config.php");
  include_once("../header.php");
  $carta = $_GET["card"];
  $indirizzo = $_GET["ind"];
  $data = date("Y-m-d H:i:s");
  $totale = $_SESSION["totale"];
  $id_utente = $_SESSION["id_utente"];
  $mysqli->query("INSERT INTO Acquisto (id_acquisto, data, totale, id_indirizzo, id_utente)
                  VALUES(NULL, '$data', '$totale', '$indirizzo', '$id_utente')");
  $id_acquisto = $mysqli->insert_id;
  $carrello = $_SESSION["carrello"];
  foreach ($carrello as $key => $articolo) {
    $mysqli->query("INSERT INTO Dettagli_Acquisto (id_acquisto, id_scarpa, id_taglia, quantita, prezzo)
                    VALUES ('$id_acquisto', '$articolo[id_scarpa]', '$articolo[taglia]', '$articolo[quantita]', '$articolo[prezzo]')");
  }
  $_SESSION["carrello"] = array();
?>

<div class="container">
  <h1>Pagamento Riuscito!</h1>
  <a href="http://localhost/JustShoes/index.php" class="btn btn-primary">Torna alla Home</a>
</div>
