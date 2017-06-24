<?php
  include_once("../config.php");
  include_once("../header.php");
  //PROTEZIONE ADMIN
  if($_SESSION['admin'] == false){
    header("Location: ../index.php");
    EXIT;
  }
  //INSERIMENTO CATEGORIA
  if(isset($_POST['nome']) && $_POST['nome']!=""){
    $nome = $_POST['nome'];
    $sql_ins = "INSERT INTO Categoria (id_categoria, nome)
                VALUES (NULL, ?)";
    //PREPARO STATEMENT PER EVITARE CARATTERI SPECIALI E INJECTIONS
    $stmt = $mysqli->prepare($sql_ins);
    $stmt->bind_param("s", $nome);
    if($stmt->execute()){
      header("Location: gestione-categorie.php");
      EXIT;
    }
    else{
      echo "Inserimento non riuscito! Controllare connessione al DB!";
    }
  }
  //RIMOZIONE CATEGORIA
  if(isset($_POST['id_cat']) && $_POST['id_cat']!=""){
    $id = $_POST['id_cat'];
    $sql_del = "DELETE FROM Categoria
                WHERE Categoria.id_categoria = $id";
    if($mysqli->query($sql_del)){
      header("Location: gestione-categorie.php");
      EXIT;
    }
    else{
      echo "Eliminazione non riuscita! La marca è ancora collegata ad almeno una scarpa!";
    }
  }

?>
<!-- FORM PER INSERIMENTO CATEGORIA -->
<h1>Inserimento Categoria</h1>
<form id="inserimento-categoria" method="post" action="gestione-categorie.php">
  <label for="nome">Nome</label>
  <input type="text" name="nome"></input>
  <button class="btn btn-default" onclick="submit()">Inserisci</button>
</form>
<script type="text/javascript">
  submit = function(){
    $("#inserimento-categoria").submit();
  }
</script>
<!------------------------------------>
<?php
  $query = "SELECT *
            FROM Categoria";

  //SCRIPT GENERICO PER COSTRUZIONE TABELLA
  if($categorie = $mysqli->query($query)) {
      $categoria = $categorie->fetch_array(MYSQLI_ASSOC);
      echo "<div class='container'>".
            "<h2>Categorie</h2>".
            "<table class='table'>".
            "<thead>".
              "<tr>";
      foreach ($categoria as $key => $value) {
        echo "<th>".strtoupper($key)."</th>";
      }
      echo "    </tr>".
              "</thead>".
              "";
      while($categoria){

        echo "<tr>";
        foreach ($categoria as $key => $value) {



            echo "<td>$value</td>";


        }
        echo "<td><button class='btn btn-default' onclick='elimina_categoria($categoria[id_categoria])'>Elimina</button></td>";
        echo "</tr>";
        $categoria = $categorie->fetch_array(MYSQLI_ASSOC);
      }
              "</table>".
            "</div>";
  }
  else{
    echo "Errore nella richiesta della tabella!";
  }


?>

<!--FORM NASCOSTO PER ELIMINAZIONE CATEGORIA TRAMITE SUBMIT-->
<form id="elimina_categoria" method="post" action="gestione-categorie.php" class="hidden" >
  <input type="text" name="id_cat" id="id_cat" class="hidden"></input>
</form>
<script type="text/javascript">
  elimina_categoria = function(id){

    $("#id_cat").val(id);
    $("#elimina_categoria").submit();
  }
</script>
<!------------------------------------------------------------>
