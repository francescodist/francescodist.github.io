<?php
include_once("./config.php");
include_once("./header.php");


if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header("Location: index.php");
    EXIT;
}

if(isset($_GET["option"])){
  $option = $_GET["option"];
}
else{
  $option = "default";
}
if(isset($_GET["id"])){
  $id = $_GET["id"];
}
else{
  $id = "";
}

if(isset($_POST['email']) && $_POST['email'] != "" &&
   isset($_POST['password']) && $_POST['password'] != "") {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']).$SAFEWORD);

    //SE IL LOGIN HA SUCCESSO SETTO LE VARIABILI DI SESSIONE
    if($utente = $mysqli->query("SELECT *
                                 FROM Utente
                                 WHERE email = '$email'
                                 AND password = '$password'
                                 AND attivo = '1'")
                                 ->fetch_array(MYSQLI_ASSOC)) {
        $_SESSION['logged'] = true;
        $_SESSION['id_utente'] = $utente['id_utente'];
        $_SESSION['email'] = $utente['email'];
        if($utente['id_gruppo_applicativo'] === "1"){
          $_SESSION['admin'] = true;
          header('Location: http://localhost/JustShoes/admin/gestione-scarpe.php');
          EXIT;
        }
        else{
          $_SESSION['admin'] = false;
        }
        if($option == "default"){
          header("Location: http://localhost/JustShoes/index.php");
        }
        if($option == "wishlist"){
          header("Location: http://localhost/JustShoes/cliente/wishlist-add.php?id=$id");
        }
        if($option == "acquisto"){
          header("Location: http://localhost/JustShoes/shop/acquisto.php");
        }
        EXIT;
    }
    //ALTRIMENTI INFORMO L'UTENTE DELLA NON RIUSCITA
    else {
        $_POST = array();
        echo "<script type='text/javascript'>alert('Email e/o Password errati!')</script>";
    }
}
?>

<!-- FORM PER INSERIMENTO DATI LOGIN -->
<div class="container" >
    <div >
        <h1 class="text-center">Accedi</h1>
        <form action=<?php echo "'login.php?option=$option&id=$id'";?> method="POST">
            <div class="form-group">
              <label>Email:</label>
              <input type="email" value="" name="email" class="form-control"></input>
            </div>
            <div class="form-group">
              <label>Password:</label>
              <input type="password" name="password" value="" class="form-control"></input>
            </div>
              <div>
                <button class="btn btn-primary" type="submit" class="success button expanded">Login</button>
              </div>
            </div>
        </form>
    </div>
</div>
