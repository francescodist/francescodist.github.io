<?php
  include_once("../config.php");
  include_once("../header.php");

  //SOLO CLIENTI
  if($_SESSION['admin'] == true){
    header("Location: ../index.php");
    EXIT;
  }
  //CONTROLLO LOGIN
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
    header("Location: ../index.php");
    EXIT;
  }

?>
<!-- VISTA DATI DEL PROFILO -->
<div class="container" >
  <h1 align="center">Dati Profilo</h1>
  <div class="list-group">
    <li class="list-group-item">
      <h4 class="list-group-item-heading">Email</h4>
      <p class="list-group-item-text"><?php echo $_SESSION["email"]?></p>
    </li>
    <a href="http://localhost/JustShoes/cliente/profilo-modifica.php" class="list-group-item active">
      <h4 class="list-group-item-heading">Modifica</h4>
      <p class="list-group-item-text">Modifica email e/o password</p>
    </a>

  </div>
</div>

<div class="container" >
  <h1 align="center">Rubrica Indirizzi</h1>
  <div class="list-group">
    <?php
    $indirizzi = $mysqli->query("SELECT *
                                 FROM Indirizzo
                                 WHERE id_utente=$_SESSION[id_utente]");

    if($indirizzi){
      while($indirizzo = $indirizzi->fetch_array(MYSQLI_ASSOC)){
        echo "<a href='http://localhost/JustShoes/cliente/indirizzo-add.php?id=$indirizzo[id_indirizzo]' class='list-group-item'>
                <h4 class='list-group-item-heading'>$indirizzo[nome]</h4>
                <p class='list-group-item-text'>$indirizzo[citta] - $indirizzo[via], $indirizzo[CAP]</p>
              </a>";
      }
    }
    ?>
    <a href="http://localhost/JustShoes/cliente/indirizzo-add.php" class="list-group-item active">
      <h4>Aggiungi Indirizzo</h4>
    </a>
  </div>
</div>

<div class="container" >
  <h1 align="center">Elenco Carte Di Credito</h1>
  <div class="list-group">
    <?php
    $carte = $mysqli->query("SELECT *
                             FROM Carta_Di_Credito
                             WHERE id_utente=$_SESSION[id_utente]");

    if($carte){
      while($carta = $carte->fetch_array(MYSQLI_ASSOC)){
        echo "<a href='http://localhost/JustShoes/cliente/carta-add.php?id=$carta[id_carta]' class='list-group-item'>
                <h4 class='list-group-item-heading'>Termina con ".substr($carta["numero_carta"],12)."</h4>
                <p class='list-group-item-text'>Scade il ".substr($carta["scadenza"],0,7)."</p>
              </a>";
      }
    }

    ?>
    <a href="http://localhost/JustShoes/cliente/carta-add.php" class="list-group-item active">
      <h4>Aggiungi Carta</h4>
    </a>
  </div>
</div>

<div class="container" >
  <h1 align="center">Elimina Account</h1>
  <div class="list-group red-bg">
    <a href="http://localhost/JustShoes/cliente/profilo-elimina.php" class="list-group-item active red-bg">
      <h4>Elimina Account</h4>
    </a>
  </div>
</div>
