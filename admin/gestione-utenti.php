<?php
  include_once("../config.php");
  include_once("../header.php");

  //PROTEZIONE ADMIN
  if($_SESSION['admin'] == false){
    header("Location: ../index.php");
    EXIT;
  }

  //ATTIVA/DISATTIVA UTENTE
  if(isset($_POST["id_utente"])){
    $id_utente = $_POST["id_utente"];
    $attivo = $_POST["attivo"];
    if($mysqli->query("UPDATE Utente
                       SET attivo = $attivo
                       WHERE id_utente=$id_utente")){

      header("Location: gestione-utenti.php");
      EXIT;
    }
    else {
      echo "Impossibile includere/escludere Utente";
    }
  }

  //PREPARO QUERY DI RICERCA
  if(isset($_POST["cerca"])){
    $nome = "%$_POST[cerca]%";
    //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
    $stmt = $mysqli->prepare("SELECT *
                              FROM Utente
                              WHERE id_gruppo_applicativo = 2
                              AND email LIKE ?");
    $stmt->bind_param("s",$nome);
    $stmt->execute();
    $utenti = $stmt->get_result();
  }
  else{
    $utenti = $mysqli->query("SELECT *
                              FROM Utente
                              WHERE id_gruppo_applicativo = 2");
  }
?>

  <div class="container" >
    <h1 align="center">Lista Utenti</h1>
    <br/>
    <!-- FORM PER RICERCA UTENTE -->
    <form id="formRicerca" method="post" action="gestione-utenti.php" class="form-group">
      <input class="form-control" type="text" name="cerca" id="cerca"></input>
    </form>
    <button onclick="cerca()" class="btn btn-default">Cerca</button>
    <!-------------------------------------->

    <!-- TABELLA PER LISTA UTENTI -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>EMAIL</th>
        </tr>
      </thead>


      <?php
      if($utenti){
        while($utente = $utenti->fetch_array(MYSQLI_ASSOC)){
          echo '<tr>
                  <th>'.$utente["id_utente"].'</th>
                  <th>'.$utente["email"].'</th>
                  <th><button onclick="listaOrdini('.$utente["id_utente"].')" class="btn btn-default">Lista Ordini</button></th>';
          if($utente["attivo"] == 1){
            echo '<th><button onclick="eliminaUtente('.$utente["id_utente"].',0)" class="btn btn-default">Disattiva</button></th>';
          }
          else{
            echo '<th><button onclick="eliminaUtente('.$utente["id_utente"].',1)" class="btn btn-default">Attiva</button></th>';
          }
          echo      '</a><br/>';
        }
      }
      else{
        echo "Nessun Utente trovato!";
      }
      ?>

    </table>
    <!----------------------------------------------------->
  </div>

  <!-- FORM PER ATTIVAZIONE/DISATTIVAZIONE UTENTE -->
  <form id="eliminaUtente" method="post" action="gestione-utenti.php" hidden>
    <input type="text" name="id_utente" id="idUtente"></input>
    <input type="text" name="attivo" id="attivo"></input>
  </form>
  <!-------------------------------------------------->

<script type="text/javascript">
  modificaUtente = function(id){
    window.open("http://localhost/JustShoes/admin/modifica-utenti.php?id="+id,"_self");
  }

  listaOrdini = function(id){
    window.open("http://localhost/JustShoes/cliente/ordini.php?id="+id,"_self");
  }

  eliminaUtente = function(id,attivo){
    $("#idUtente").val(id);
    $("#attivo").val(attivo);
    $("#eliminaUtente").submit();
  }

  cerca = function(){
    if($("#cerca").val() != "")
      $("#formRicerca").submit();
  }
</script>
