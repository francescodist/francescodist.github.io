<?php
	include_once("./config.php");
	include_once("./header.php");


	if(isset($_SESSION['admin']) && $_SESSION['admin']==true){
		header ("Location: http://localhost/JustShoes/admin/gestione-scarpe.php");
		EXIT;
	}


	$sqlScontate = "SELECT id_scarpa, Scarpa.nome AS 'nome',
												 prezzo, sconto, foto, Marca.nome AS 'marca'
									FROM Scarpa
									JOIN Marca
									ON Scarpa.id_marca = Marca.id_marca
									WHERE sconto > 0
									AND attivo = '1'
									ORDER BY sconto ASC
									LIMIT 4";

	$sqlTopSeller = "SELECT Scarpa.id_scarpa, Scarpa.nome AS 'nome',
													prezzo, sconto, foto, Marca.nome AS 'marca'
									 FROM Scarpa
									 JOIN (SELECT id_scarpa, SUM(quantita) AS tot
									 			 FROM Dettagli_Acquisto
												 GROUP BY id_scarpa) AS qtaToT
									 ON Scarpa.id_scarpa = qtaTot.id_scarpa
									 JOIN Marca
									 ON Scarpa.id_marca = Marca.id_marca
									 WHERE attivo ='1'
									 ORDER BY tot ASC LIMIT 4";


	$scontate = $mysqli->query($sqlScontate);

	$topSeller = $mysqli->query($sqlTopSeller);

//A SEGUIRE LE 2 VISTE PER LE 2 RISPETTIVE QUERY
	echo "<div class='container-fluid'>";
	echo "<h1>Le nostre promozioni</h1>";
	echo "<div class='row container-fluid' style = 'width: 100%; margin: 0; padding: 20px; margin-top: 60px;'>";

  if($scontate){

    while($scontata = $scontate->fetch_array(MYSQLI_ASSOC)){

    echo "<div class='col-md-3 col-sm-6 thumb' style='cursor: pointer;'
        onclick='acquistaScarpa($scontata[id_scarpa])'>";

    echo    "<div class='thumbnail thumb-scarpa'>
                <img src='http://localhost/JustShoes/img/scarpe/$scontata[foto]' class='thumb-pic'>
                <div class='caption'>
                  <h4>$scontata[marca]</h4><h3 style ='margin-top:0'>$scontata[nome]</h3>
                  <h4 style='text-align : right'>";

                  if($scontata['sconto'] > 0){

                    echo "<span style = 'font-size: 14px;'><del>$scontata[prezzo] €
                     </del> </span>".
                    ($scontata['prezzo'] - ($scontata['prezzo']/100 * $scontata['sconto']))
                     ."€ </h4>";
                  }
                  else{
                    echo "$scontata[prezzo] €</h4>";
                  }

     echo             "<p>
                      <a href='http://localhost/JustShoes/cliente/wishlist-add.php?option=index&id=$scontata[id_scarpa]' class='btn btn-default btn-block' role='button'>Aggiungi a Wishlist</a>
                      <a href='http://localhost/JustShoes/shop/scarpa.php?id=$scontata[id_scarpa]' class='btn btn-primary btn-block' role='button'>Acquista</a>
                  </p>
                </div>
              </div>
            </div>";
    }
  }

  echo "</div>";
  echo "</div>";

  	echo "<div class='container-fluid'>";
  	echo "<h1>Le nostre Top Seller</h1>";
	echo "<div class='row container-fluid' style='width: 100%; margin: 0; padding: 20px; margin-top: 60px;'>";

  if($topSeller){

    while($top = $topSeller->fetch_array(MYSQLI_ASSOC)){

    echo "<div class='col-md-3 col-sm-6 thumb' style='cursor: pointer;'
        onclick='acquistaScarpa($top[id_scarpa])'>";

    echo    "<div class='thumbnail thumb-scarpa'>
                <img src='http://localhost/JustShoes/img/scarpe/$top[foto]' alt='prova'>
                <div class='caption'>
                  <h4>$top[marca]</h4><h3 style ='margin-top:0'>$top[nome]</h3>
                  <h4 style='text-align : right'>";

                  if($top['sconto'] > 0){

                    echo "<span style='font-size: 14px;'><del>$top[prezzo] €
                     </del> </span>"
                    .($top['prezzo'] - ($top['prezzo']/100 * $top['sconto'])).

                    " € </h4>";
                  }
                  else{
                    echo $top['prezzo']. "€</h4>";
                  }

     echo             "<p>
                      <a href='http://localhost/JustShoes/cliente/wishlist-add.php?option=index&id=$top[id_scarpa]' class='btn btn-default btn-block' role='button'>Aggiungi a Wishlist</a>
                      <a href='http://localhost/JustShoes/shop/scarpa.php?id=$top[id_scarpa]' class='btn btn-primary btn-block' role='button'>Acquista</a>
                  </p>
                </div>
              </div>
            </div>";
    }

  }

  echo "</div>";
  echo "</div>";



	//SCRIPT PER WISHLIST COME IN catalogo.php
	if(isset($_SESSION["logged"]) && $_SESSION["logged"] == true){
		include_once("./cliente/wishlist.php");

		if(isset($_GET["wladd"]) && $_GET["wladd"] == 1){
			echo "<script type='text/javascript'>alert('Aggiunto alla Wishlist!'); window.open('http://localhost/JustShoes/index.php','_self');</script>";
		}
		elseif (isset($_GET["wladd"])) {
			echo "<script type='text/javascript'>alert('Elemento già presente nella Wishlist!'); window.open('http://localhost/JustShoes/index.php','_self')</script>";
		}

	}

?>

<script type="text/javascript">
	acquistaScarpa = function(id){
		window.open("http://localhost/JustShoes/shop/scarpa.php?id="+id,"_self")
	}
</script>
