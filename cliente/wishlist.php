<?php
  $wishes = $mysqli->query("SELECT *
                            FROM Wishlist
                            JOIN Scarpa
                            ON Wishlist.id_scarpa = Scarpa.id_scarpa
                            WHERE id_utente = $_SESSION[id_utente]
                            AND attivo = '1'");

if($wish = $wishes->fetch_array(MYSQLI_ASSOC)){
  echo "<div class='wishlist'>
      <div class='wish-label'>WISHLIST</div>";



      do{
        echo "<div class='wish-thumb'>
                <a href='http://localhost/JustShoes/shop/scarpa.php?id=$wish[id_scarpa]'>
                  <img class='wish-img' src='http://localhost/JustShoes/img/scarpe/$wish[foto]'/>
                </a>
                <a href='http://localhost/JustShoes/cliente/wishlist-delete.php?id=$wish[id_scarpa]'>
                  <img class='wish-delete'/ src='http://localhost/JustShoes/img/wish-delete.png'>
                </a>
              </div>";
      }
      while($wish = $wishes->fetch_array(MYSQLI_ASSOC));
        echo "</div>";
    }


?>
