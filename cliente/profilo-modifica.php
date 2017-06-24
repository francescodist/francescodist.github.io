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

  //MODIFICA EMAIL
  if(isset($_POST["email"]) && $_POST["email"] != ""){
    $email = $_POST["email"];
    if($mysqli->query("UPDATE Utente
                       SET email = '$email'
                       WHERE id_utente = $_SESSION[id_utente]")){
      $_SESSION["email"] = $email;
      header("Location: profilo.php");
      EXIT;
    }
    else{
      echo "<script type='text/javascript'>alert('Questa email è già registrata');</script>";
    }
  }

  //MODIFICA PASSWORD
  if(isset($_POST["new-pwd"]) && $_POST["new-pwd"] != ""){
    $new_password = $_POST["new-pwd"];
    $old_password = $mysqli->query("SELECT password
                                    FROM Utente
                                    WHERE id_utente=$_SESSION[id_utente]")->fetch_array(MYSQLI_ASSOC)["password"];
    $_POST["old-pwd"] = md5($_POST["old-pwd"].$SAFEWORD);
    //SE LE PASSWORD INSERITE CORRISPONDONO PROVVEDO AD AGGIORNARE LA PASSWORD
    if($_POST["old-pwd"] == $old_password){
      if($new_password == $_POST["new-pwd-r"]){
        $new_password = md5($new_password.$SAFEWORD);
        if($mysqli->query("UPDATE Utente
                           SET password = '$new_password'
                           WHERE id_utente = $_SESSION[id_utente]")){

          header("Location: profilo.php");
          EXIT;
        }
        else{
          echo "<script type='text/javascript'>alert('Errore aggiornamento password!');</script>".$mysqli->error;
        }
      }
      else{
        echo "<script type='text/javascript'>alert('Le due password non corrispondono!');</script>";
      }
    }
    else {
      echo "<script type='text/javascript'>alert('Vecchia Password errata!');</script>";
    }
  }
?>

<!-- FORM PER MODIFICA EMAIL / PASSWORD -->
<div class="container">
  <h1 align="center">Modifica Email</h1>
  <form id="modifica-email" method="post" action="profilo-modifica.php">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" value=<?php echo "'$_SESSION[email]'" ?>  class="form-control"></input>
    </div>
    <button class="btn btn-primary" onclick="salvaEmail()">Salva Email</button>
  </form>
</div>
<div class="container">
  <h1 align="center">Modifica Password</h1>
  <form id="modifica-pwd" method="post" action="profilo-modifica.php">
    <div class="form-group">
      <label for="old-pwd">Vecchia Password</label>
      <input type="password" name="old-pwd" class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="new-pwd">Nuova Password</label>
      <input type="password" name="new-pwd" id="newPwd" class="form-control"></input>
    </div>
    <div class="form-group">
      <label for="new-pwd">Nuova Password</label>
      <input type="password" name="new-pwd-r" id="newPwdR" class="form-control"></input>
    </div>
    <button class="btn btn-primary" onclick="salvaPassword()">Salva Password</button>
  </form>
</div>
<script type="text/javascript">
  salvaEmail = function(){
    $("#modifica-email").submit();
  }

  salvaPassword = function(){
    $("#modifica-pwd").submit();
  }
</script>
