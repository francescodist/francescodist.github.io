                    LISTA QUERIES

-------------- ADMIN -------------------------------

gestione-categorie.php

//INSERIMENTO CATEGORIA
INSERT INTO Categoria (id_categoria, nome)
VALUES                (NULL, '$nome')

//ELIMINAZIONE CATEGORIA
DELETE FROM Categoria
WHERE Categoria.id_categoria = $id

//TUTTE LE CATEGORIE
SELECT *
FROM Categoria

/////////////////////////////////////////////////

gestione-marche.php

//INSERIMENTO MARCA
INSERT INTO Marca (id_marca, nome)
VALUES            (NULL, '$nome')

//ELIMINAZIONE MARCA
DELETE FROM Marca
WHERE Marca.id_marca = $id

//TUTTE LE MARCHE
SELECT *
FROM Marca

///////////////////////////////////////////////////

gestione-scarpe.php

//INSERIMENTO SCARPA
INSERT INTO Scarpa (id_scarpa, codice, nome, prezzo, sconto, id_marca, foto, descrizione)
VALUES             (NULL, '$codice','$nome','$prezzo', '$sconto', '$marca','$foto', '$descrizione')

//INSERIMENTO CATEGORIA PER SCARPA
INSERT INTO Scarpa_Categoria (id_scarpa, id_categoria)
VALUES                       ('$id_scarpa', '$categoria')

//ESCLUSIONE/INCLUSIONE SCARPA IN CATALOGO
UPDATE Scarpa
SET attivo=$attivo
WHERE Scarpa.id_scarpa = $id

//RICERCA SCARPA PER CODICE
SELECT *
FROM Scarpa
WHERE Scarpa.codice
LIKE '%$codice%'

//TUTTE LE scarpe
SELECT *
FROM Scarpa

//SELEZIONE NOME MARCA A PARTIRE DA ID_MARCA
SELECT nome
FROM Marca
WHERE id_marca=$value

//SELEZIONE CATEGORIA A PARTIRE DA ID_SCARPA
SELECT nome
FROM Scarpa_Categoria
JOIN Categoria
ON Scarpa_Categoria.id_categoria = Categoria.id_categoria
WHERE id_scarpa = $scarpa[id_scarpa]

///////////////////////////////////////////////////////////

gestione-utenti.php

//ATTIVA/DISATTIVA UTENTE
UPDATE Utente
SET attivo = $attivo
WHERE id_utente=$id_utente

//RICERCA UTENTE PER EMAIL
SELECT *
FROM Utente
WHERE id_gruppo_applicativo = 2
AND email LIKE '%$nome%'

//SELEZIONE TUTTI UTENTI LIMITATA AI CLIENTI
SELECT *
FROM Utente
WHERE id_gruppo_applicativo = 2

/////////////////////////////////////////////////////////

inserimento-scarpe.php

//RIMOZIONE VECCHIE QUANTITA SCARPE DA STOCK
DELETE FROM Stock_Scarpe
WHERE id_scarpa = $id_scarpa

//INSERIMENTO QUANTITA SCARPE IN STOCK
INSERT INTO Stock_Scarpe (quantita, id_taglia, id_scarpa)
VALUES                   ('$_POST[num1]','1','$id_scarpa')

//SELEZIONA TUTTE LE TAGLIE
SELECT *
FROM Taglia

//SELEZIONE QUANTITA PER ID_SCARPA E ID_TAGLIA
SELECT quantita
FROM Stock_Scarpe
JOIN Scarpa ON Scarpa.id_scarpa = Stock_Scarpe.id_scarpa
WHERE id_taglia = $taglie[id_taglia]
AND Stock_Scarpe.id_scarpa = $id_scarpa

///////////////////////////////////////////////////////////

modifica-scarpe.php

//AGGIORNAMENTO VALORI SCARPA
UPDATE Scarpa
SET id_scarpa = '$id_scarpa',
    codice = '$codice',
    nome = '$nome',
    prezzo = '$prezzo',
    sconto = '$sconto',
    id_marca = '$marca',
    foto = '$foto',
    descrizione = '$descrizione'
WHERE id_scarpa = $id_scarpa

//ELIMINAZIONE CATEGORIE SCARPA
DELETE FROM Scarpa_Categoria
WHERE id_scarpa = $id_scarpa

//INSERIMENTO CATEGORIE SCARPA
INSERT INTO Scarpa_Categoria (id_scarpa, id_categoria)
VALUES                       ('$id_scarpa', '$value')

//SELEZIONE SCARPA PER ID
SELECT *
FROM Scarpa
WHERE id_scarpa = $id_scarpa

//SELEZIONE DI TUTTE LE marche
SELECT *
FROM Marca

//SELEZIONE CATEGORIE COLLEGATE A UNA SPECIFICA SCARPA
SELECT Categoria.id_categoria, nome
FROM Scarpa_Categoria
JOIN Categoria ON Scarpa_Categoria.id_categoria = Categoria.id_categoria
WHERE id_scarpa = $scarpa[id_scarpa]

//SELEZIONE CATEGORIE NON COLLEGATE A UNA SPECIFICA SCARPA
SELECT id_categoria, nome
FROM Categoria
WHERE id_categoria
NOT IN (SELECT id_categoria
       FROM Scarpa_Categoria
       WHERE id_scarpa =$scarpa[id_scarpa])

----------- CLIENTE ------------------------------------

carta-add.php

//SELEZIONE DI CARTA CON SPECIFICO ID
SELECT *
FROM Carta_Di_Credito
WHERE id_carta = $id

//INSERIMENTO CARTA
INSERT INTO Carta_Di_Credito (id_carta, id_utente, numero_carta, scadenza)
VALUES                       (NULL, '$id_utente', '$numero', '$scadenza')

//MODIFICA CARTA CON SPECIFICO ID
UPDATE Carta_Di_Credito
SET numero_carta = $numero,
    scadenza = $scadenza
WHERE id_carta=$_GET[id]

/////////////////////////////////////////////////////////////////

carta-delete.php

//ELIMINAZIONE CARTA PER ID
DELETE FROM Carta_Di_Credito
WHERE id_carta = $id_carta

////////////////////////////////////////////////////////////////

indirizzo-add.php

//SELEZIONE DI INDIRIZZO CON SPECIFICO ID
SELECT * FROM Indirizzo
WHERE id_indirizzo = $id

//INSERIMENTO INDIRIZZO
INSERT INTO Indirizzo (id_indirizzo, id_utente, nome, citta, via, CAP, altro)
VALUES                (NULL, '$id_utente', '$nome', '$citta', '$via', '$cap', '$altro')

//MODIFICA INDIRIZZO CON SPECIFICO ID
UPDATE Indirizzo
SET nome = '$nome',
    citta = '$citta',
    via = '$via',
    CAP = '$cap',
    altro = '$altro'
WHERE id_indirizzo = $_GET[id]

///////////////////////////////////////////////////////////////

indirizzo-delete.php

//ELIMINAZIONE INDIRIZZO CON SPECIFICO ID
DELETE FROM Indirizzo
WHERE id_indirizzo = $id_indirizzo

///////////////////////////////////////////////////////////////

ordini.php

//SELEZIONE DI TUTTI I DATI NECESSARI PER VISTA ACQUISTI EFFETTUATI
SELECT Acquisto.id_acquisto, Acquisto.id_utente,
       Acquisto.data, Acquisto.id_indirizzo,
       Acquisto.totale, Dettagli_Acquisto.id_scarpa,
       Dettagli_Acquisto.id_taglia, Dettagli_Acquisto.quantita,
       Indirizzo.nome AS 'indirizzo_nome',
       Indirizzo.via, Indirizzo.CAP, Indirizzo.citta,
       Scarpa.nome AS 'scarpa_nome',
       Dettagli_Acquisto.prezzo, Scarpa.foto, Scarpa.id_marca,
       Marca.nome AS 'marca_nome',
       Taglia.taglia_eu, Taglia.taglia_uk_m, Taglia.taglia_uk_f,
       Taglia.taglia_us_m, Taglia.taglia_us_f

FROM Acquisto

JOIN Dettagli_Acquisto
ON Acquisto.id_acquisto = Dettagli_Acquisto.id_acquisto

JOIN Indirizzo
ON Acquisto.id_indirizzo = Indirizzo.id_indirizzo

JOIN Scarpa
ON Dettagli_Acquisto.id_scarpa =  Scarpa.id_scarpa

JOIN Marca
ON Scarpa.id_marca = Marca.id_marca

JOIN Taglia
ON Dettagli_Acquisto.id_taglia = Taglia.id_taglia
WHERE Acquisto.id_utente = ".$id_utente." ORDER BY Acquisto.data DESC

////////////////////////////////////////////////////////////////////////

profilo-elimina.php

//SETTA UTENTE SPECIFICO COME INATTIVO
UPDATE Utente
SET attivo = '0'
WHERE id_utente = $id_utente

////////////////////////////////////////////////////////////////////////

profilo-modifica.php

//MODIFICA EMAIL PER ID UTENTE
UPDATE Utente
SET email = '$email'
WHERE id_utente = $_SESSION[id_utente]

//SELEZIONE PASSWORD DI SPECIFICO UTENTE
SELECT password
FROM Utente
WHERE id_utente=$_SESSION[id_utente]

//AGGIORNAMENTO PASSWORD PER SPECIFICO UTENTE
UPDATE Utente
SET password = '$new_password'
WHERE id_utente = $_SESSION[id_utente]

//////////////////////////////////////////////////////////////////

profilo.php

//SELEZIONE INDIRIZZI DI SPECIFICO UTENTE
SELECT *
FROM Indirizzo
WHERE id_utente=$_SESSION[id_utente]

//SELEZIONE CARTE DI CREDITO DI SPECIFICO UTENTE
SELECT *
FROM Carta_Di_Credito
WHERE id_utente=$_SESSION[id_utente]

//////////////////////////////////////////////////////////////////

wishlist-add.php

//INSERIMENTO IN WISHLIST DI UTENTE
INSERT INTO Wishlist (id_utente, id_scarpa)
VALUES ('$id_utente','$id_scarpa')

///////////////////////////////////////////////////////////////////

wishlist-delete.php

//ELIMINAZIONE ELEMENTO DA WISHLIST UTENTE
DELETE FROM Wishlist
WHERE id_utente = $_SESSION[id_utente]
AND id_scarpa = $_GET[id]

//////////////////////////////////////////////////////////////////

wishlist.php

//SELEZIONE ELEMENTI WISHLIST DI SPECIFICO UTENTE
SELECT *
FROM Wishlist
JOIN Scarpa
ON Wishlist.id_scarpa = Scarpa.id_scarpa
WHERE id_utente = $_SESSION[id_utente]
AND attivo = '1'

------------------- SHOP -----------------------------------------

acquisto.php

//SELEZIONE INDIRIZZI DI SPECIFICO UTENTE
SELECT *
FROM Indirizzo
WHERE id_utente=$_SESSION[id_utente]

//SELEZIONE CARTE DI CREDITO DI SPECIFICO UTENTE
SELECT *
FROM Carta_Di_Credito
WHERE id_utente=$_SESSION[id_utente]

//////////////////////////////////////////////////////////////////////

carrello-add.php

//SELEZIONE DI UNA SCARPA PER ID
SELECT *
FROM Scarpa
WHERE id_scarpa = $id_scarpa

///////////////////////////////////////////////////////////////////////

carrello.php

//SELEZIONE Q.TA DI UN ARTICOLO IN STOCK
SELECT quantita
FROM Stock_Scarpe
WHERE id_scarpa = $articolo[id_scarpa]
AND id_taglia = $articolo[taglia]

//SELEZIONE TAGLIA PER ID taglia
SELECT *
FROM Taglia
WHERE id_taglia = $articolo[taglia]

///////////////////////////////////////////////////////////////////////

catalogo.php

//RICERCA SCARPE (ATTIVE) PER NOME O MARCA
SELECT id_scarpa, Scarpa.nome, prezzo, sconto, foto, Marca.nome AS 'marca'
FROM Scarpa
JOIN Marca
ON Scarpa.id_marca = Marca.id_marca
WHERE attivo='1'
AND (Scarpa.nome LIKE '%$fastFilter%'
     OR Marca.nome LIKE '%$fastFilter%')
ORDER BY id_scarpa

//SELEZIONA TUTTE SCARPE (ATTIVE) COMPRESE DI MARCA
SELECT id_scarpa, Scarpa.nome, prezzo, sconto, foto, Marca.nome AS 'marca'
FROM Scarpa
JOIN Marca
ON Scarpa.id_marca = Marca.id_marca
WHERE attivo='1'
ORDER BY id_scarpa

//SELEZIONA TUTTE LE CATEGORIE
SELECT *
FROM Categoria

//SELEZIONA GLI ID DI TUTTE LE CATEGORIE DI UNA SPECIFICA Scarpa
SELECT id_categoria
FROM Scarpa_Categoria
WHERE id_scarpa=$scarpa[id_scarpa

///////////////////////////////////////////////////////////////////////

pagamento.php

//INSERIMENTO IN DB DI ACQUISTO COMPLESSIVO
INSERT INTO Acquisto (id_acquisto, data, totale, id_indirizzo, id_utente)
VALUES               (NULL, '$data', '$totale', '$indirizzo', '$id_utente')

//INSERIMENTO DI ARTICOLO RELATIVO AD Acquisto
INSERT INTO Dettagli_Acquisto (id_acquisto, id_scarpa, id_taglia, quantita, prezzo)
VALUES                        ('$id_acquisto', '$articolo[id_scarpa]', '$articolo[taglia]',
                               '$articolo[quantita]', '$articolo[prezzo]')

//////////////////////////////////////////////////////////////////////

scarpa.php

//SELEZIONA SPECIFICA SCARPA
SELECT *
FROM Scarpa
WHERE id_scarpa = $id_scarpa

//SELEZIONA TAGLIE DISPONIBILI IN STOCK DI SPECIFICA SCARPA ORDINATE PER TAGLIA
SELECT *
FROM Stock_Scarpe
JOIN Taglia
ON Stock_Scarpe.id_taglia = Taglia.id_taglia
WHERE id_scarpa = $id_scarpa
AND Stock_Scarpe.quantita > 0
ORDER BY taglia_eu

-------------------------------------------------------------------------------

index.php

//SELEZIONA LE 4 SCARPE MAGGIORMENTE SCONTATE
SELECT id_scarpa, Scarpa.nome AS 'nome',
       prezzo, sconto, foto, Marca.nome AS 'marca'
FROM Scarpa
JOIN Marca
ON Scarpa.id_marca = Marca.id_marca
WHERE sconto > 0
AND attivo = '1'
ORDER BY sconto ASC
LIMIT 4

//SELEZIONA LE 4 SCARPE CON IL MAGGIOR NUMERO DI VENDITE TOTALI
SELECT Scarpa.id_scarpa, Scarpa.nome AS 'nome',
       prezzo, sconto, foto, Marca.nome AS 'marca'
FROM Scarpa
JOIN (SELECT id_scarpa, SUM(quantita) AS tot
      FROM Dettagli_Acquisto
      GROUP BY id_scarpa) AS qtaToT
ON Scarpa.id_scarpa = qtaTot.id_scarpa
JOIN Marca
ON Scarpa.id_marca = Marca.id_marca
WHERE attivo ='1'
ORDER BY tot ASC LIMIT 4

///////////////////////////////////////////////////////////////////

login.php

//SELEZIONA UTENTE CON EMAIL E PASSWORD SPECIFICHE ATTIVO
SELECT *
FROM Utente
WHERE email = '$email'
AND password = '$password'
AND attivo = '1'

////////////////////////////////////////////////////////////////////

signup.php

INSERT INTO Utente (id_utente, email, password, id_gruppo_applicativo)
VALUES             (NULL,'$email','$password','$gruppo_applicativo');
