<?php
  include_once("../config.php");
  $id_utente = $_SESSION["id_utente"];

  //SE UTENTE SCEGLIE ELIMINAZIONE SETTO INATTIVO SU DB
  if(isset($_POST["scelta"])){
    if($_POST["scelta"] == "0"){
      $mysqli->query("UPDATE Utente
                      SET attivo = '0'
                      WHERE id_utente = $id_utente");
      header("Location: ../logout.php");
    }
    //ALTRIMENTI TORNO INDIETRO
    else{
      header("Location: profilo.php");
    }
    EXIT;
  }
?>

<!-- FORM PER SCELTA ELIMINAZIONE -->
<div class="container" style="text-align: center">
  <h1 align="center">Sicuro di voler eliminare l'account?</h1>
</br>
  <form id="eliminazione" method="post" action="profilo-elimina.php">
    <input type="text" name="scelta" id="scelta" hidden></input>
  </form>
  <button onclick="submitScelta('0')" class="btn btn-danger" style="width: 200px">Sì</button>
  <button onclick="submitScelta('1')" class="btn btn-primary" style="width: 200px">No</button>
</div>
<script type="text/javascript">
 submitScelta = function(scelta){
   $("#scelta").val(scelta);
   $("#eliminazione").submit();
 }
</script>
