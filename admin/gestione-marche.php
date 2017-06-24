<?php
  include_once("../config.php");
  include_once("../header.php");

  //PROTEZIONE ADMIN
  if($_SESSION['admin'] == false){
    header("Location: ../index.php");
    EXIT;
  }
  //INSERIMENTO MARCA
  if(isset($_POST['nome']) && $_POST['nome']!=""){
    $nome = $_POST['nome'];
    $sql_ins = "INSERT INTO Marca (id_marca, nome)
                VALUES (NULL, ?)";
    //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
    $stmt = $mysqli->prepare($sql_ins);
    $stmt->bind_param("s", $nome);
    if($stmt->execute()){
      header("Location: gestione-marche.php");
      EXIT;
    }
    else{
      echo "Inserimento non riuscito! Controllare connessione al DB!";
    }
  }
  //RIMOZIONE MARCA
  if(isset($_POST['id_marca']) && $_POST['id_marca']!=""){
    $id = $_POST['id_marca'];
    $sql_del = "DELETE FROM Marca
                WHERE Marca.id_marca = $id";
    if($mysqli->query($sql_del)){
      header("Location: gestione-marche.php");
      EXIT;
    }
    else{
      echo "Eliminazione non riuscita! La categoria è ancora collegata ad almeno una scarpa!";
    }
}
?>
<!-- FORM PER INSERIMENTO MARCA -->
<h1>Inserimento Marca</h1>
<form id="inserimento-marca" method="post" action="gestione-marche.php">
  <label for="nome">Nome</label>
  <input type="text" name="nome"></input>
  <button class="btn btn-default" onclick="submit()">Inserisci</button>
</form>
<script type="text/javascript">
  submit = function(){
    $("#inserimento-marca").submit();
  }
</script>
<!-------------------------------->
<?php
  $sql = "SELECT *
                FROM Marca";

  //SCRIPT GENERICO PER COSTRUZIONE TABELLA
  if($marche = $mysqli->query($sql)){
      $marca = $marche->fetch_array(MYSQLI_ASSOC);
      echo "<div class='container'>".
            "<h2>Marche</h2>".
            "<table class='table'>".
            "<thead>".
              "<tr>";
      foreach ($marca as $key => $value) {
        echo "<th>".strtoupper($key)."</th>";
      }
      echo "    </tr>".
              "</thead>".
              "";
      while($marca){

        echo "<tr>";
        foreach ($marca as $key => $value) {



            echo "<td>$value</td>";


        }
        echo "<td><button class='btn btn-default' onclick='elimina_marca($marca[id_marca])'>Elimina</button></td>";
        echo "</tr>";
        $marca = $marche->fetch_array(MYSQLI_ASSOC);
      }
              "</table>".
            "</div>";
  }
  else{
    echo "Errore nella richiesta della tabella!";
  }


?>
<form id="elimina_marca" method="post" action="gestione-marche.php" class="hidden" >
  <input type="text" name="id_marca" id="id_marca" class="hidden"></input>
</form>
<script type="text/javascript">
  elimina_marca = function(id){

    $("#id_marca").val(id);
    $("#elimina_marca").submit();
  }
</script>
