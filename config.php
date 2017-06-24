<!-- LIBRERIE DI SISTEMA NECESSARIE AL FUNZIONAMENTO DEL SITO -->
<script src="http://localhost/JustShoes/lib/jQuery/jquery-3.2.1.js"></script>
<link href="http://localhost/JustShoes/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<script src="http://localhost/JustShoes/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="http://localhost/JustShoes/lib/javascript/paging.js"></script>
<link href="/JustShoes/lib/css/main.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://localhost/JustShoes/lib/javascript/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="http://localhost/JustShoes/lib/css/bootstrap-multiselect.css" type="text/css"/>

<?php
	//INIZIALIZZAZIONE VARIABILI DI SESSIONE PER COMUNICAZIONE CON DB
	$HOST = "localhost";
	$USER = "root";
	$PASS = "root";
	$DB   = "JustShoes";
	$SAFEWORD = "JuS75h03$";

	//CREAZIONE CONNESSIONE CON DB E RIFERIMENTO PER USO DI QUERY MYSQL
	$con = mysql_connect($HOST, $USER, $PASS) or die("Connessione a mysql non riuscita\n");
	$db = mysql_select_db($DB, $con) or die("Impossibile selezionare il database\n");
	$mysqli = new mysqli("localhost", "root", "root", "JustShoes");


	//INIZIO SESSIONE
	session_start();

	//INIZIALIZZO VARIABILE DI SESSIONE ADMIN A FALSE
	if(!isset($_SESSION['admin'])){
		$_SESSION['admin'] = false;
	}

	//INIZIALIZZO VARIABILE DI SESSIONE CARRELLO AD ARRAY VUOTO
	if(!isset($_SESSION['carrello'])){
		$_SESSION['carrello'] = array();
	}
?>
