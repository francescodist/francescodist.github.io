<?php
  include_once("../config.php");
  include_once("../header.php");

  //RISERVATO AI CLIENTI
 if($_SESSION['admin'] == true){
    header("Location: ../index.php");
    EXIT;
  }
  //CONTROLLO LOGIN
  if(!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
    header("Location: ../index.php");
    EXIT;
  }

  //SE HO UN ID INDIRIZZO COME PARAMETRO, PRENDO I VALORI PER LA MODIFICA
  if(isset($_GET["id"]) && $_GET["id"]!=""){
    $id = $_GET["id"];
    $indirizzo = $mysqli->query("SELECT *
                                 FROM Indirizzo
                                 WHERE id_indirizzo = $id")->fetch_array(MYSQLI_ASSOC);
    $nome = $indirizzo["nome"];
    $citta = $indirizzo["citta"];
    $via = $indirizzo["via"];
    $cap = $indirizzo["CAP"];
    $altro = $indirizzo["altro"];
  }
  else{//ALTRIMENTI LI SETTO VUOTI PER INSERIRE UN NUOVO INDIRIZZO IN DB
    $id = "";
    $nome = "";
    $citta = "";
    $via = "";
    $cap = "";
    $altro = "";
  }


  //INSERIMENTO/MODIFICA INDIRIZZO IN DB
  if(isset($_POST["nome"]) && $_POST["nome"] != "" &&
     isset($_POST["citta"]) && $_POST["citta"] != "" &&
     isset($_POST["via"]) && $_POST["via"] != "" &&
     isset($_POST["cap"]) && $_POST["cap"] != ""){
       $id_utente = $_SESSION["id_utente"];
       $nome = $_POST["nome"];
       $citta = $_POST["citta"];
       $via = $_POST["via"];
       $cap = $_POST["cap"];
       if(isset($_POST["altro"])){
         $altro = $_POST["altro"];
       }
       else{
         $altro = "";
       }
       //SE ID NON E' SETTATO CREO NUOVO INDIRIZZO
       if($_GET["id"] == ""){
         $mysqli->query("INSERT INTO Indirizzo (id_indirizzo, id_utente, nome, citta, via, CAP, altro)
                         VALUES (NULL, '$id_utente', '$nome', '$citta', '$via', '$cap', '$altro')");
       }
       //ALTRIMENTI MODIFICO QUELLO GIA' ESISTENTE
       else {
         $mysqli->query("UPDATE Indirizzo
                         SET nome = '$nome',
                             citta = '$citta',
                             via = '$via',
                             CAP = '$cap',
                             altro = '$altro'
                         WHERE id_indirizzo = $_GET[id]");
       }
       header("Location: profilo.php");
       EXIT;
  }


?>
<!-- FORM PER INSERIMENTO/MODIFICA INDIRIZZO -->
<div class="container">
  <h1 align="center"><?php if($id == "")echo "Inserisci ";else echo "Modifica ";?>Indirizzo</h1>
  <form id="indirizzo-add" method="post" action=<?php echo "'indirizzo-add.php?id=$id'";?>>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" value=<?php echo "'$nome'" ?>  class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="citta">Citta</label>
      <input type="text" name="citta" value=<?php echo "'$citta'" ?>  class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="via">Via</label>
      <input type="text" name="via" value=<?php echo "'$via'" ?>  class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="cap">CAP</label>
      <input id="capInput" type="text" name="cap" value=<?php echo "'$cap'" ?>  class="form-control input-control"></input>
    </div>
    <div class="form-group">
      <label for="altro">Altro</label>
      <input type="text" name="altro" value=<?php echo "'$altro'" ?>  class="form-control"></input>
    </div>

  </form>
  <button id="submitBtn" class="btn btn-primary" onclick="salvaIndirizzo()">Salva Indirizzo</button>
  <button class="btn btn-danger" onclick=<?php echo "eliminaIndirizzo($id)"?> <?php if($id == "") echo "hiddden";?>>Elimina Indirizzo</button>


</div>
<script type='text/javascript'>
  salvaIndirizzo = function(){
    $("#indirizzo-add").submit();
  }
  eliminaIndirizzo = function(id){
    window.open("http://localhost/JustShoes/cliente/indirizzo-delete.php?id="+id,"_self");
  }

  $(".input-control").change(function(){

    if($("#capInput").val().length != 5 || isNaN($("#capInput").val())){
      alert("CAP non valido!");
      $("#submitBtn").attr("disabled", "true");
    }
    else{
       $("#submitBtn").removeAttr("disabled");
    }



  });
</script>
