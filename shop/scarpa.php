<?php
  include_once("../config.php");
  include_once("../header.php");
  $id_scarpa = $_GET["id"];
  $scarpa = $mysqli->query("SELECT *
                            FROM Scarpa
                            WHERE id_scarpa = $id_scarpa")->fetch_array(MYSQLI_ASSOC);
  $taglie = $mysqli->query("SELECT *
                            FROM Stock_Scarpe
                            JOIN Taglia
                            ON Stock_Scarpe.id_taglia = Taglia.id_taglia
                            WHERE id_scarpa = $id_scarpa
                            AND Stock_Scarpe.quantita > 0
                            ORDER BY taglia_eu");

?>

<!-- VISTA PER IMMAGINE SCARPA, PANNELLO ACQUISTO E DESCRIZIONE -->
<div class="container">
  <div class="row">
    <img class="col-md-5" src=<?php echo "'http://localhost/JustShoes/img/scarpe/$scarpa[foto]'";?>/>
    <div class="panel panel-primary col-md-6" style="padding: 0">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $scarpa["nome"];?></h3>
      </div>
      <div class="panel-body">
      <?php
      //DIVERSE VISTE PER PREZZO SCONTATO O PIENO
       if($scarpa['sconto'] > 0){

                    echo "<h4><del>$scarpa[prezzo] €
                     </del></h4><h3>"
                    .($scarpa['prezzo'] - ($scarpa['prezzo']/100 * $scarpa['sconto'])).
                    "€ <span style='color: red; font-size: 18px;'>Sconto del $scarpa[sconto]%</span></h3>";
                  }
                  else{
                    echo $scarpa['prezzo']." €";
                  }
        ?>
        <!-- SELECT PER TAGLIA DA ACQUISTARE -->
        <div class="form-group">
          <label for="taglia">Taglia:</label>
          <select class="form-control" id="taglia">
              <?php
                $out_of_stock = true;
                while($taglia = $taglie->fetch_array(MYSQLI_ASSOC)) {
                    if($taglia['quantita']>0){
                      echo "<option value='{$taglia['id_taglia']}'>$taglia[taglia_eu] (eu) - $taglia[taglia_uk_m] (uk m) - $taglia[taglia_uk_f] (uk f) - $taglia[taglia_us_m] (us m) - $taglia[taglia_us_f] (us f) </option>";
                      $out_of_stock = false;
                    }

                }
                if($out_of_stock){
                  echo "<option value='-1'>OUT OF STOCK</option>";
                }
              ?>
            </select>

          </label>
        </div>
        <button class="btn btn-default btn-block" onclick=<?php echo "'addWish($id_scarpa)'";?>>AGGIUNGI ALLA WISHLIST</button>
        <button class="btn btn-primary btn-block" onclick=<?php echo "'addCarrello($id_scarpa)'";?>>AGGIUNGI AL CARRELLO</button>
      </div>
    </div>
  </div>
  <br/>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Descrizione</h3>
    </div>
    <div class="panel-body">
      <?php echo $scarpa["descrizione"]; ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  addWish = function(id){
    window.open("http://localhost/JustShoes/cliente/wishlist-add.php?option=scarpa&id="+id,"_self");
  }

  addCarrello = function(id){
    //INSERISCO IN CARRELLO SOLO SE NON OUT OF STOCK
    let taglia = $("#taglia").val();
    if(taglia != -1){
      window.open("http://localhost/JustShoes/shop/carrello-add.php?id="+id+"&taglia="+taglia,"_self");
    }
    else{
      alert("Spiacenti!\nScarpa OUT OF STOCK!");
    }
  }
</script>

<?php

  //SCRIPT PER WISHLIST COME IN catalogo.php
  if(isset($_SESSION["logged"]) && $_SESSION["logged"] == true){
    include_once("../cliente/wishlist.php");
  }
  if(isset($_GET["wladd"]) && $_GET["wladd"] == 1){
    echo "<script type='text/javascript'>alert('Aggiunto alla Wishlist!'); window.open('http://localhost/JustShoes/shop/scarpa.php?id=$id_scarpa','_self');</script>";
  }
  elseif (isset($_GET["wladd"])) {
    echo "<script type='text/javascript'>alert('Elemento già presente nella Wishlist!'); window.open('http://localhost/JustShoes/shop/scarpa.php?id=$id_scarpa','_self')</script>";
  }
?>
