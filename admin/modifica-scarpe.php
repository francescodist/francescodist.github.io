<?php
  include_once("../config.php");
  include_once("../header.php");

  //PROTEZIONE ADMIN
  if($_SESSION['admin'] == false){
    header("Location: ../index.php");
    EXIT;
  }

  //MODIFICA SCARPA (COME IN gestione-scarpe.php TRANNE PER QUERY)
  $id_scarpa = $_GET["id"];

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
    $descrizione = $_POST["descrizione"]  == "" ? 'Nessuna Descrizione!' : $_POST['descrizione'];;
    //AGGIORNO I VALORI DELLA SCARPA
    //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
    $sql_ins = "UPDATE Scarpa
                SET id_scarpa = ?,
                    codice = ?,
                    nome = ?,
                    prezzo = ?,
                    sconto = ?,
                    id_marca = ?,
                    foto = ?,
                    descrizione = ?
                WHERE id_scarpa = ?" ;
    $stmt = $mysqli->prepare($sql_ins);
    $stmt->bind_param("sssdissss",$id_scarpa,$codice,$nome,$prezzo,$sconto,$marca,$foto,$descrizione,$id_scarpa);

    //AGGIORNO LE CATEGORIE DELLA SCARPA
    if($stmt->execute()){
      $categorie = $_POST['categorie'];
      //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
      $sql_del_cat = "DELETE FROM Scarpa_Categoria
                      WHERE id_scarpa = ?";
      $stmt = $mysqli->prepare($sql_del_cat);
      $stmt->bind_param("s",$id_scarpa);
      if($stmt->execute()){

        foreach ($categorie as $key => $value) {
          //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
          $sql_ins_cat = "INSERT INTO Scarpa_Categoria (id_scarpa, id_categoria)
                          VALUES (?, ?)";
          $stmt = $mysqli->prepare($sql_ins_cat);
          $stmt->bind_param("ss",$id_scarpa,$categoria);
          $stmt->execute();
        }
      }

      header("Location: gestione-scarpe.php");
      EXIT;
    }
    else {
      echo "Impossibile modificare scarpa!";
    }
  }


  $scarpa = $mysqli->query("SELECT *
                            FROM Scarpa
                            WHERE id_scarpa = $id_scarpa")
                           ->fetch_array(MYSQLI_ASSOC);

?>

<!-- COME IN gestione-scarpe.php MA CON VALORI INIZIALI RELATIVI ALLA
     SCARPA DA MODIFICARE SELEZIONATA-->

<div class="container">
  <h1 align="center">Inserimento Modello Scarpa</h1>
  <form id="inserimento-scarpa" method="post" action=<?php echo "'modifica-scarpe.php?id=$id_scarpa'"; ?>>
    <div class="form-group">
      <label for="codice">Codice</label>
      <input type="text" name="codice" class="form-control" value=<?php echo "'$scarpa[codice]'"; ?>></input>
    </div>
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control" value=<?php echo "'$scarpa[nome]'"; ?>></input>
    </div>
    <div class="form-group">
      <label for="prezzo">Prezzo</label>
      <input type="text" name="prezzo" class="form-control" value=<?php echo "'$scarpa[prezzo]'"; ?>></input>
    </div>
     <div class="form-group">
      <label for="sconto">Sconto %</label>
      <input id="scontoInput" type="text" name="sconto" class="form-control" value=<?php echo "'$scarpa[sconto]'"; ?>></input>
    </div>
    <div class="form-group">
      <label>Marca
        <select name="marca" class="form-control">
          <?php
            $marche = $mysqli->query("SELECT *
                                      FROM Marca");
            while($marca = $marche->fetch_array(MYSQLI_ASSOC)) {
              if($scarpa["id_marca"] == $marca["id_marca"]){
                echo "<option value='$marca[id_marca]' checked>$marca[nome]</option>";
              }
              else {
                echo "<option value='$marca[id_marca]' >$marca[nome]</option>";
              }
            }
          ?>
        </select>
      </label>
    </div>
    <div class="form-group">
      <?php
        //CATEGORIE COLLEGATE ALLA SCARPA SELEZIONATE
        $categorie_si = $mysqli->query("SELECT Categoria.id_categoria, nome
                                     FROM Scarpa_Categoria
                                     JOIN Categoria ON Scarpa_Categoria.id_categoria = Categoria.id_categoria
                                     WHERE id_scarpa = $scarpa[id_scarpa]");

        if($categorie_si){
          while($categoria = $categorie_si->fetch_array(MYSQLI_ASSOC)) {
              echo "<label class='checkbox-inline'>
                    <input type='checkbox' name='categorie[]' value=$categoria[id_categoria] checked></input>
                      $categoria[nome]
                    </label>";
          }
        }

        //CATEGORIE NON COLLEGATE ALLA SCARPA NON SELEZIONATE
        $categorie_no = $mysqli->query("SELECT id_categoria, nome
                                        FROM Categoria
                                        WHERE id_categoria
                                        NOT IN (SELECT id_categoria
                                                FROM Scarpa_Categoria
                                                WHERE id_scarpa =$scarpa[id_scarpa])");

        if($categorie_no){
          while($categoria = $categorie_no->fetch_array(MYSQLI_ASSOC)) {
              echo "<label class='checkbox-inline'>
                    <input type='checkbox' name='categorie[]' value=$categoria[id_categoria]></input>
                      $categoria[nome]
                    </label>";
          }
        }

      ?>
    </div>

    <div class="form-group">
      <label for="foto">Foto</label>
      <input type="text" name="foto" class="form-control"  value=<?php echo "'$scarpa[foto]'"; ?>></input>
    </div>
    <div class="form-group">
      <label for="foto">Descrizione</label>
      <textarea name="descrizione" class="form-control" value=<?php echo "'$scarpa[descrizione]'"; ?>><?php echo $scarpa['descrizione']; ?></textarea>
    </div>

    <button id="submitBtn" class="btn btn-default" onclick="submit()">Inserisci</button>
  </form>
</div>

<script type='text/javascript'>
  submit = function(){
    $("#inserimento-scarpa").submit();
  }

    $("#scontoInput").change(function(){
    if($(this).val() < 0 || $(this).val() > 100){
      $("#submitBtn").attr("disabled", "true");
      alert("La percentuale dev'essere un valore compreso tra 0 e 100!");
    }
    else{
       $("#submitBtn").removeAttr("disabled");
    }
  });
</script>
