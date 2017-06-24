<?php
  include_once("../config.php");
  include_once("../header.php");

  //RISERVATO AI CLIENTI
   if($_SESSION['admin'] == true){
    header("Location: ../index.php");
    EXIT;
  }

  //CONTROLLO LOGIN
  if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: ../index.php");
    EXIT;
  }

  //SE HO UN ID CARTA COME PARAMETRO, PRENDO I VALORI PER LA MODIFICA
  if(isset($_GET["id"]) && $_GET["id"]!=""){
    $id = $_GET["id"];
    $carta = $mysqli->query("SELECT *
                             FROM Carta_Di_Credito
                             WHERE id_carta = $id")->fetch_array(MYSQLI_ASSOC);
    $numero = $carta["numero_carta"];
    $scadenza = $carta["scadenza"];
    $anno = substr($scadenza, 0, 4);
    $mese = substr($scadenza, 5, 2);
  }
  else{//ALTRIMENTI LI SETTO VUOTI PER INSERIRE UNA NUOVA CARTA IN DB
    $id = "";
    $carta = "";
    $numero = "";
    $scadenza = "";
    $anno = "";
    $mese = "";
  }

  //INSERIMENTO/MODIFICA CARTA DI CREDITO IN DB
  if(isset($_POST["numero"]) && $_POST["numero"] != "" &&
     isset($_POST["mese"]) && $_POST["mese"] != "" &&
     isset($_POST["anno"]) && $_POST["anno"] != ""){
       $id_utente = $_SESSION["id_utente"];
       $numero = $_POST["numero"];
       $mese = $_POST["mese"];
       $anno = $_POST["anno"];
       if($mese == "02"){
         if($anno % 4 == 0){
           $giorno = "29";
         }
         else{
           $giorno = "28";
         }
       }
       elseif ($mese == "04" || $mese == "06" || $mese == "09" || $mese == "11") {
         $giorno = "30";
       }
       else{
         $giorno = "31";
       }
       $scadenza = $anno.'-'.$mese.'-'.$giorno;
       //SE ID E' VUOTO INSERISCO NUOVA CARTA
       if($_GET["id"] == ""){
         //PREPARO LO STATEMENT PER GESTIRE CARATTERI SPECIALI E INJECTIONS
         $stmt = $mysqli->prepare("INSERT INTO Carta_Di_Credito (id_carta, id_utente, numero_carta, scadenza)
                                   VALUES (NULL, ?, ?, ?)");
         $stmt->bind_param("sss",$id_utente,$numero,$scadenza);
         $stmt->execute();
       }
       //ALTRIMENTI MODIFICO LA CARTA CON QUELL'ID
       else {
         //PREPARO LO STATEMENT PER GESTIRE CARATTERI SPECIALI E INJECTIONS
         $stmt = $mysqli->prepare("UPDATE Carta_Di_Credito
                                   SET numero_carta = ?,
                                       scadenza = ?
                                   WHERE id_carta=?");
         $stmt->bind_param("sss",$numero,$scadenza,$_GET["id"]);
         $stmt->execute();
       }
       header("Location: profilo.php");
       EXIT;
  }



?>
<!-- FORM PER INSERIMENTO/MODIFICA CARTA -->
<div class="container">
  <h1 align="center"><?php if($id == "")echo "Inserisci ";else echo "Modifica ";?>Carta Di Credito</h1>
  <form id="carta-add" method="post" action=<?php echo "'carta-add.php?id=$id'";?>>
    <div class="form-group">
      <label for="numero">Numero Carta</label>
      <input id="numeroCartaInput" type="text" name="numero" value=<?php echo "'$numero'" ?>  class="form-control input-control"></input>
    </div>
    <div class="form-group">
      <label for="">Mese</label>
      <!-- IN CASO DI MODIFICA SETTO I VALORI DI DEFAULT RELATIVI ALLA CARTA DA MODIFICARE -->
      <select id="mese" name="mese" class="form-control" value=<?php echo "'".substr($scadenza,6)."'";?>>>
        <option value='01' <?php if($mese == '01') echo "selected";?>>01</option>
        <option value='02' <?php if($mese == '02') echo "selected";?>>02</option>
        <option value='03' <?php if($mese == '03') echo "selected";?>>03</option>
        <option value='04' <?php if($mese == '04') echo "selected";?>>04</option>
        <option value='05' <?php if($mese == '05') echo "selected";?>>05</option>
        <option value='06' <?php if($mese == '06') echo "selected";?>>06</option>
        <option value='07' <?php if($mese == '07') echo "selected";?>>07</option>
        <option value='08' <?php if($mese == '08') echo "selected";?>>08</option>
        <option value='09' <?php if($mese == '09') echo "selected";?>>09</option>
        <option value='10' <?php if($mese == '10') echo "selected";?>>10</option>
        <option value='11' <?php if($mese == '11') echo "selected";?>>11</option>
        <option value='12' <?php if($mese == '12') echo "selected";?>>12</option>
      </select>
    </div>
    <div class="form-group">
      <label for="">Anno</label>
      <select id="anno" name="anno" class="form-control" value=<?php echo "'".substr($scadenza,0,4)."'";?>>
        <option value='2017' <?php if($anno == '2017') echo "selected";?>>2017</option>
        <option value='2018' <?php if($anno == '2018') echo "selected";?>>2018</option>
        <option value='2019' <?php if($anno == '2019') echo "selected";?>>2019</option>
        <option value='2020' <?php if($anno == '2020') echo "selected";?>>2020</option>
        <option value='2021' <?php if($anno == '2021') echo "selected";?>>2021</option>
        <option value='2022' <?php if($anno == '2022') echo "selected";?>>2022</option>
        <option value='2023' <?php if($anno == '2023') echo "selected";?>>2023</option>
        <option value='2024' <?php if($anno == '2024') echo "selected";?>>2024</option>
        <option value='2025' <?php if($anno == '2025') echo "selected";?>>2025</option>
        <option value='2026' <?php if($anno == '2026') echo "selected";?>>2026</option>
        <option value='2027' <?php if($anno == '2027') echo "selected";?>>2027</option>
      </select>
    </div>
  </form>
  <button id="submitBtn" class="btn btn-primary" onclick="salvaCarta()">Salva Carta</button>
  <button class="btn btn-danger" onclick=<?php echo "eliminaCarta($id)"?> <?php if($id == "") echo "hiddden";?>>Elimina Carta</button>
</div>
<script type='text/javascript'>
  salvaCarta = function(){

    date = new Date();
    //CONTROLLO VALIDITA DATA DI SCADENZA
    if((date.getFullYear() == $("#anno").val() && $("#mese").val()  >= date.getMonth()) || ($("#anno").val() >date.getFullYear())){
      $("#carta-add").submit();
    }

    else alert("Data di scadenza non valida!");

  }

  eliminaCarta = function(id){
    window.open("http://localhost/JustShoes/cliente/carta-delete.php?id="+id,"_self");
  }


   $(".input-control").change(function(){

    if($("#numeroCartaInput").val().length != 16 || isNaN($("#numeroCartaInput").val())){
      alert("Numero di carta non valido!");
      $("#submitBtn").attr("disabled", "true");
    }
    else{
       $("#submitBtn").removeAttr("disabled");
    }



  });
</script>
