<!-- TEMPLATE BOOTSTRAP PER NAVBAR -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header ">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://localhost/JustShoes/index.php">Just Shoes</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="cliente"><a href="http://localhost/JustShoes/shop/catalogo.php">Catalogo <span class="sr-only">(current)</span></a></li>
      </ul>
      <?php
        if($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] === "localhost/JustShoes/shop/catalogo.php"){
          echo '<form id="ricerca" class="navbar-form navbar-left cliente" action="catalogo.php" method="POST">'.
        '<div class="form-group">'.
          '<input type="text" class="form-control" placeholder="Ricerca Rapida" name="ricercaRapida">'.
        '</div>'.
        '<button type="submit" class="btn btn-default">Cerca</button>'.
      '</form>';
        }
        ?>
      <ul class="nav navbar-nav navbar-right">
      <li class="cliente"><a href="http://localhost/JustShoes/shop/carrello.php">Carrello (<?php echo count($_SESSION["carrello"])?>)</a></li>
      <li class="dropdown">
        <a id="admin-panel" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Amministrazione<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li ><a href="http://localhost/JustShoes/admin/gestione-categorie.php" >Categorie</a></li>
          <li ><a href="http://localhost/JustShoes/admin/gestione-marche.php">Marche</a></li>
          <li ><a href="http://localhost/JustShoes/admin/gestione-scarpe.php">Scarpe</a></li>
          <li ><a href="http://localhost/JustShoes/admin/gestione-utenti.php">Utenti</a></li>
        </ul>
      </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="profilo" class="cliente"><a href="http://localhost/JustShoes/cliente/profilo.php" >Profilo</a></li>
            <li id="ordini" class="cliente"><a href="http://localhost/JustShoes/cliente/ordini.php" >Ordini</a></li>

            <li id="accedi"><a href="http://localhost/JustShoes/login.php?option=default&id=0" >Accedi</a></li>
            <li id="esci"><a href="http://localhost/JustShoes/logout.php">Esci</a></li>
            <li id="registrati"><a href="http://localhost/JustShoes/signup.php">Crea Account</a></li>
          </ul>
        </li>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

  <?php

    //MOSTRO/NASCONDO ALCUNI ELEMENTI DELLA NAVBAR A SECONDA DELLO STATO DI LOGIN
    //E DEL GRUPPO APPLICATIVO DELL'UTENTE LOGGATO
    if(isset($_SESSION['admin']) && $_SESSION['admin']==true){
      echo '<script type="text/javascript">$("#admin-panel").show();$(".cliente").hide();$("#profilo").hide();$("#ordini").hide();</script>';
    }
    else{
      echo '<script type="text/javascript">$("#admin-panel").hide();$(".cliente").show();$("#profilo").show();$("#ordini").show()</script>';
    }

    if(isset($_SESSION['logged']) && $_SESSION['logged']==true){
      echo '<script type="text/javascript">'.'$("#esci").show();$("#accedi").hide();$("#registrati").hide();</script>';
    }
    else{
      echo '<script type="text/javascript">'.'$("#esci").hide();$("#accedi").show();$("#registrati").show();$("#profilo").hide();$("#ordini").hide();</script>';
    }
  ?>
