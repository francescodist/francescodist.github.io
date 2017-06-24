<?php
  include_once("../config.php");
  include_once("../header.php");


  //PROTEZIONE ADMIN
  if($_SESSION['admin'] == false){
    header("Location: ../index.php");
    EXIT;
  }

  //INSERIMENTO SCARPA
  if(isset($_POST['codice']) && $_POST['codice']!="" &&
     isset($_POST['nome']) && $_POST['nome']!="" &&
     isset($_POST['prezzo']) && $_POST['prezzo']!="" &&
     isset($_POST['sconto']) &&
     isset($_POST['marca']) && $_POST['marca']!="" &&
     isset($_POST['foto']) &&
     isset($_POST['descrizione'])){

    $codice = $_POST['codice'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $sconto = $_POST['sconto'] == "" ? '0' : $_POST['sconto'];
    $marca = $_POST['marca'];
    $foto = $_POST['foto']  == "" ? 'nopic.png' : $_POST['foto'];
    $descrizione = $_POST["descrizione"]  == "" ? 'Nessuna Descrizione!' : $_POST['descrizione'];
    $sql_ins = "INSERT INTO Scarpa (id_scarpa, codice, nome, prezzo, sconto, id_marca, foto, descrizione, attivo)
                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, '1')";
    //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
    $stmt = $mysqli->prepare($sql_ins);
    $stmt->bind_param("ssdisss",$codice,$nome,$prezzo,$sconto,$marca,$foto,$descrizione);
    if($stmt->execute()){
      $id_scarpa = $mysqli->insert_id;
      $categorie = $_POST['categorie'];
      //INSERISCO LE CATEGORIE PER LA SCARPA APPENA INSERITA
      foreach ($categorie as $key => $categoria) {
        //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
        $sql_ins_cat = "INSERT INTO Scarpa_Categoria (id_scarpa, id_categoria)
                        VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql_ins_cat);
        $stmt->bind_param("ss",$id_scarpa,$categoria);
        $stmt->execute();
      }
      //ISERITO IL MODELLO VADO ALL'INSERIMENTO IN STOCK PER TAGLIA
      header("Location: inserimento-scarpe.php?id=$id_scarpa");
      EXIT;
    }
    else{
      echo "Codice già presente in Inventario!";
    }
  }

  //DISATTIVAZIONE/ATTIVAZIONE SCARPA
  if(isset($_POST['id_scarpa']) && $_POST['id_scarpa']!=""){
    $id = $_POST['id_scarpa'];
    $attivo = $_POST["attivo"];
    //VIENE SETTATA ATTIVA/INATTIVA(LASCIATA NEL DB PER CONSERVARNE I DATI)
    $sql = "UPDATE Scarpa
            SET attivo=$attivo
            WHERE Scarpa.id_scarpa = $id";
    if($mysqli->query($sql)){
      header("Location: gestione-scarpe.php");
      EXIT;
    }
    else{
      echo "Impossibile escludere scarpa dal Catalogo!";
    }
  }

  //RICERCA SCARPA
  //PREPARO LA QUERY, CON FILTRO
  if(isset($_POST['ricerca_codice']) && $_POST['ricerca_codice']!=""){
    $codice = $_POST['ricerca_codice'];
    $sql_fetch = "SELECT *
                  FROM Scarpa
                  WHERE Scarpa.codice
                  LIKE '%$codice%'";
  }
  //O SENZA (TUTTE LE SCARPE)
  else{
    $codice="";
    $sql_fetch ="SELECT *
                 FROM Scarpa";
  }

?>

<!--FORM PER INSERIMENTO SCARPA-->
<div class="container">
  <h1 align="center">Inserimento Modello Scarpa</h1>
  <form id="inserimento-scarpa" method="post" action="gestione-scarpe.php">
    <div class="form-group">
      <label for="codice">Codice</label>
      <input type="text" name="codice" class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="prezzo">Prezzo</label>
      <input id="prezzoInput" type="text" name="prezzo" class="form-control input-control"></input>
    </div>
    <div class="form-group">
     <div class="form-group">
      <label for="sconto">Sconto %</label>
      <input id="scontoInput" type="text" name="sconto" class="form-control input-control"></input>
    </div>
    <div class="form-group">
      <!--CREO SELECT DI MARCHE CON QUERY-->
      <label>Marca
        <select name="marca" class="form-control">
          <?php
            $marche = $mysqli->query("SELECT *
                                      FROM Marca");
            while($marca = $marche->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$marca[id_marca]'>$marca[nome]</option>";
            }
          ?>
        </select>
      </label>
    </div>
    <!--CREO CHECKBOX PER LE CATEGORIE CON QUERY-->
    <div class="form-group">
      <?php
        $categorie = $mysqli->query("SELECT *
                                     FROM Categoria");
        while($categoria = $categorie->fetch_array(MYSQLI_ASSOC)) {
            echo "<label class='checkbox-inline'><input type='checkbox' name='categorie[]' value='$categoria[id_categoria]'></input>$categoria[nome]</label>";
        }
      ?>
    </div>

    <div class="form-group">
      <label for="foto">Foto</label>
      <input type="text" name="foto" class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="descrizione">Descrizione</label>
      <textarea name="descrizione" class="form-control"></textarea>
    </div>

    <button id="submitBtn" class="btn btn-default" onclick="submit()">Inserisci</button>
  </form>
</div>
<!---------------------------------------------------->
<!--FORM PER RICERCA SCARPA-->
<div class="container">
  <h1 align="center">Ricerca Codice Scarpa</h1>
  <form id="ricerca-scarpa" method="post" action="gestione-scarpe.php">
    <div class="form-group">
      <label for="codice">Codice</label>
      <input type="text" name="ricerca_codice" id="ricerca-codice" class="form-control"></input>
    </div>
    <button class="btn btn-default" onclick="search('')">Ricerca</button>
  </form>
</div>
<!------------------------------------------->

<!-- FORM ESCLUSIONE/INCLUSIONE SCARPA IN CATALOGO-->
<form id="elimina_scarpa" method="post" action="gestione-scarpe.php" class="hidden" >
  <input type="text" name="id_scarpa" id="id_scarpa" class="hidden"></input>
  <input type="text" name="attivo" id="attivo" class="hidden"></input>
</form>
<!----------------------------------------------->

<script type="text/javascript">

  submit = function(){
    $("#inserimento-scarpa").submit();
  }

  search = function(check){
    //se viene passato "reset" come parametro svuota la barra da ricerca
    //e richiede semplicemente TUTTE le scarpe
    if(check == "reset")
      $("#ricerca-codice").val('');
    $("#ricerca-scarpa").submit();
  }

  //check sulla correttezza di alcuni dati nel form di inserimento
  $(".input-control").change(function(){


    if($("#scontoInput").val() < 0 || $("#scontoInput").val() > 100){
      alert("La percentuale dev'essere un valore compreso tra 0 e 100!");
      $("#submitBtn").attr("disabled", "true");
    }


    else if(isNaN($("#prezzoInput").val())){
      alert("Inserire un valore numerico!");
      $("#submitBtn").attr("disabled", "true");

    }
    else{
      $("#submitBtn").removeAttr("disabled");
    }

  });

  elimina_scarpa = function(id,attivo){
    $("#attivo").val(attivo);
    $("#id_scarpa").val(id);
    $("#elimina_scarpa").submit();
  }

  toggleTabella = function(){

    $("#mostra-txt").toggle();
    $("#nascondi-txt").toggle();
    $("#tabella-scarpe").toggle();
  }

  mostraDettagli = function(id){
    $("#r1" + id).toggle();
    $("#r2" + id).toggle();
  }

  modificaScarpa = function(id){
    window.open("http://localhost/JustShoes/admin/modifica-scarpe.php?id="+id,'_self');
  }

  modificaQta = function(id){
    window.open("http://localhost/JustShoes/admin/inserimento-scarpe.php?id="+id,'_self');
  }

  <?php
    //NASCONDO LA PROBABILMENTE TROPPO GRANDE TABELLA COMPLETA DI DEFAULT
    if($codice!=="")
      echo "$(document).ready(function() {toggleTabella()})";
  ?>
</script>
<?php

//COSTRUZIONE TABELLA SCARPA
if($scarpe = $mysqli->query($sql_fetch)){
    $scarpa = $scarpe->fetch_array(MYSQLI_ASSOC);
    echo  "<div class='container'><button class='btn btn-default' onclick='toggleTabella()'><span id='mostra-txt' >Mostra Tabella</span><span id='nascondi-txt' style='display: none'>Nascondi Tabella</span></button></div>".
          "<div class='container' id='tabella-scarpe' style='display: none'>".
          "<h2>Scarpe</h2>".
          "<table class='table table-striped'>".
          "<thead>".
            "<tr>";
    foreach ($scarpa as $key => $value) {
      if($key == "id_marca"){
        echo "<th>MARCA</th>";
      }
      //escludo i campi attivo e descrizione dalla tabella
      elseif ($key != "attivo" && $key != "descrizione"){
        echo "<th>".strtoupper($key)."</th>";
      }

    }
    echo "    </tr>".
            "</thead>".
            "";
    while($scarpa){

      echo "<tr>";
      foreach ($scarpa as $key => $value) {

          //INSERISCO IL NOME DELLA MARCA A PARTIRE DALL'ID DELLA SCARPA
          if($key == "id_marca"){
            $marca = $mysqli->query("SELECT nome
                                     FROM Marca
                                     WHERE id_marca=$value");
            $scarpa[$key] = $marca->fetch_array(MYSQLI_ASSOC)["nome"];
          }
          //ESCLUDO ATTIVO E DESCRIZIONE DALLA TABELLA
          if ($key != "attivo" && $key != "descrizione") {
            echo "<td>".$scarpa["".$key]."</td>";
          }

      }
      //AGGIUNGO TASTO INCLUDI/ESCLUDI
      if($scarpa['attivo'] == 1){
        echo "<td><button class='btn btn-default' onclick='elimina_scarpa($scarpa[id_scarpa],0)'>Escludi</button></td>";
      }
      else{
        echo "<td><button class='btn btn-default' onclick='elimina_scarpa($scarpa[id_scarpa],1)'>Includi</button></td>";
      }
      //AGGIUNGO TASTO PER MOSTRARE LA RIGA DETTAGLI NELLA TABELLA
      echo "<td><button class='btn btn-default' onclick='mostraDettagli($scarpa[id_scarpa])'>Dettagli</button></td>";
      echo "</tr>";
      //AGGIUNGO RIGHE DETTAGLI CON ID PER TOGGLE VIA JS
      echo "<tr id='r1$scarpa[id_scarpa]' style='display : none'>";
      $categorie = $mysqli->query("SELECT nome
                                   FROM Scarpa_Categoria
                                   JOIN Categoria
                                   ON Scarpa_Categoria.id_categoria = Categoria.id_categoria
                                   WHERE id_scarpa = $scarpa[id_scarpa]");
      while($categoria = $categorie->fetch_array(MYSQLI_ASSOC)){
        echo "<td>$categoria[nome]</td>";
      }
      echo "</tr>";
      echo "<tr  style='display : none' id='r2$scarpa[id_scarpa]'>
              <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
              <td><button class='btn btn-default' onclick='modificaScarpa($scarpa[id_scarpa])'>Modifica Scarpa</button></td>
              <td><button class='btn btn-default' onclick='modificaQta($scarpa[id_scarpa])'>Modifica Q.ta</button></td>
            </tr>";
      $scarpa = $scarpe->fetch_array(MYSQLI_ASSOC);
    }
            "</table>".
          "</div>";

    //SE E' STATA EFFETTUATA RICERCA AGGIUNGO TAST PER RESET TABELLA
    if($codice != ""){
      echo "<button class='btn btn-default' onclick=search('reset')>Torna a Tabella Completa</button>";
    }
  }
  else{
    echo "Nessuna scarpa in catalogo!";
  }



?>
