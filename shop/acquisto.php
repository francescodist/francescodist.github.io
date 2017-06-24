<?php
  include_once("../config.php");
  include_once("../header.php");

  //CONTROLLO SU LOGIN
  if(!isset($_SESSION["id_utente"])){
    //IN CASO NEGATIVO RIMANDA AL LOGIN
    header("Location: ../login.php?option=acquisto&id=0");
    EXIT;
  }

?>
  <!-- VISTA PER SCELTA INDIRIZZO -->
  <div class="container" >
    <h1 align="center">Scegli Indirizzo di Spedizione</h1>
    <div class="list-group">
      <?php
      $indirizzi = $mysqli->query("SELECT *
                                   FROM Indirizzo
                                   WHERE id_utente=$_SESSION[id_utente]");
      while($indirizzo = $indirizzi->fetch_array(MYSQLI_ASSOC)){
        echo "<a onclick='scegliIndirizzo($indirizzo[id_indirizzo])' class='list-group-item indirizzo' style='cursor: pointer;'>
                <h4 class='list-group-item-heading'>$indirizzo[nome]</h4>
                <p class='list-group-item-text'>$indirizzo[citta] - $indirizzo[via], $indirizzo[CAP]</p>
                <input id='ind$indirizzo[id_indirizzo]' value='$indirizzo[id_indirizzo]' class='hidden'>
              </a>";
      }
      ?>
      <a href="http://localhost/JustShoes/cliente/indirizzo-add.php" class="list-group-item active">
        <h4>Aggiungi Indirizzo</h4>
      </a>
    </div>
    <!-- VISTA PER CARTA DI CREDITO -->
    <h1 align="center">Scegli Carta Di Credito</h1>
    <div class="list-group">
      <?php
      $carte = $mysqli->query("SELECT *
                               FROM Carta_Di_Credito
                               WHERE id_utente=$_SESSION[id_utente]
                               AND scadenza > CURDATE()");
      while($carta = $carte->fetch_array(MYSQLI_ASSOC)){
        echo "<a onclick='scegliCarta($carta[id_carta])' class='list-group-item carta' style='cursor: pointer;'>
                <h4 class='list-group-item-heading'>Termina con ".substr($carta["numero_carta"],12)."</h4>
                <p class='list-group-item-text'>Scade il ".substr($carta["scadenza"],0,7)."</p>
                <input id='card$carta[id_carta]' value='$carta[id_carta]' class='hidden'>
              </a>";
      }
      ?>
      <a href="http://localhost/JustShoes/cliente/carta-add.php" class="list-group-item active">
        <h4>Aggiungi Carta Di Credito</h4>
      </a>
    </div>

    <div class="list-group">
      <a href="#" onclick="procediPagamento()" class="list-group-item active">
        <h4 class="list-group-item-heading">Completa acquisto</h4>
        <p class="list-group-item-text">Conferma i dati ed effettua il pagamento</p>
      </a>

    </div>
  </div>





<script type="text/javascript">
  scegliIndirizzo = function(id){
    $(".indirizzo").removeClass("selected-el");
    $("#ind"+id).parent().addClass("selected-el");
  }

  scegliCarta = function(id){
    $(".carta").removeClass("selected-el");
    $("#card"+id).parent().addClass("selected-el");
  }

  procediPagamento = function(){
    let indirizzo, carta;
    console.log($(".carta.selected-el"));

    if($(".indirizzo.selected-el").length != 0){
      indirizzo = $(".indirizzo.selected-el").children("input").val();
    }
    else{
      alert("Scegliere un Indirizzo!");
    }

    if($(".carta.selected-el").length != 0){
      carta = $(".carta.selected-el").children("input").val();
    }
    else{
      alert("Scegliere una Carta Di Credito!");
    }
    if(indirizzo && carta){
      window.open("http://localhost/JustShoes/shop/pagamento.php?ind="+indirizzo+"&card="+carta,"_self");
    }
  }
</script>
