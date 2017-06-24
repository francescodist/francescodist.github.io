<?php
  include_once("../config.php");
  include_once("../header.php");
  $carrello = $_SESSION["carrello"];

?>

<div class="container">
  <h1 align="center">Carrello</h1>
<?php
  //SE CI SONO ELEMENTI NEL CARRELLO COSTRUISCO LA VISTA
  if(count($carrello) > 0){
    $totale = 0;
    echo "<div class='list-group'>";
    foreach ($carrello as $key => $articolo) {
      //PRENDO LA Q.TA MASSIMA IN STOCK
      $quantita_max = $mysqli->query("SELECT quantita
                                      FROM Stock_Scarpe
                                      WHERE id_scarpa = $articolo[id_scarpa]
                                      AND id_taglia = $articolo[taglia]")
                                      ->fetch_array(MYSQLI_ASSOC)["quantita"];

      //SE LA Q.TA DESIDERATA ECCEDE LA MASSIMA, VIENE LIMITATA ALLA MASSIMA STESSA
      $articolo['quantita'] = $_SESSION["carrello"][$key]["quantita"] =
          $articolo["quantita"] <= $quantita_max ? $articolo["quantita"] : $quantita_max;
      $taglia = $mysqli->query("SELECT *
                                FROM Taglia
                                WHERE id_taglia = $articolo[taglia]")->fetch_array(MYSQLI_ASSOC);


      echo "<li class='list-group-item'>
              <span class='badge' style='margin-top: 1px;'><img style='width: 70px; height: 70px; margin:-10px;' src='http://localhost/JustShoes/img/scarpe/$articolo[foto]'/></span>
              <h4 class='list-group-item-heading'>$articolo[nome] - <span style='font-size: 14px'>Taglia: EU $taglia[taglia_eu] / UK_M $taglia[taglia_uk_m] / UK_F $taglia[taglia_uk_f] / US_M $taglia[taglia_us_m] / US_F $taglia[taglia_us_f]<span></h4>
              <p class='list-group-item-text'>
                Prezzo: <b>$articolo[prezzo] €</b> -
                Quantita: <b>$articolo[quantita]</b>
                <button class='btn btn-default' onclick='addArticolo($articolo[id_scarpa],$articolo[taglia])'>+</button>
                <button class='btn btn-default' onclick='decreaseArticolo($key)'>-</button>
                <button class='btn btn-danger' onclick='deleteArticolo($key)'>Elimina</button>
              </p>";

        if($articolo["quantita"] == $quantita_max){
          echo "<p style='color: red;'> Quantita massima raggiunta!</p>";
        }

           echo "</li>";
            $totale += $articolo["prezzo"]*$articolo["quantita"];

    }
    echo "<a href='http://localhost/JustShoes/shop/acquisto.php' class='list-group-item active'>
            <h4 class='list-group-item-heading'>Procedi all'Acquisto</h4>
            <p class='list-group-item-text'>Totale: $totale €</p>
          </a></div>";
          $_SESSION["totale"] = $totale;
  }
  else {
    echo "<h3 align='center'>Non sono presenti articoli nel carrello!</h3>";
  }
?>
</div>
<script type="text/javascript">
  addArticolo = function(id,taglia){
    window.open("http://localhost/JustShoes/shop/carrello-add.php?id="+id+"&taglia="+taglia,"_self");
  }

  decreaseArticolo = function(key){
    window.open("http://localhost/JustShoes/shop/carrello-decrease.php?key="+key,"_self");
  }
  deleteArticolo = function(key){
    window.open("http://localhost/JustShoes/shop/carrello-delete.php?key="+key,"_self");
  }
</script>
