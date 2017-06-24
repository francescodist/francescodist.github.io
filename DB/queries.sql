INSERT INTO `Gruppo_Applicativo` (`id_gruppo_applicativo`, `nome`) VALUES ('1', 'Admin'), ('2', 'Cliente');
INSERT INTO `Utente` (`id_utente`, `email`, `password`, `id_gruppo_applicativo`, `id_carta`) VALUES (NULL, 'prova@example.com', 'prova', '2', NULL), (NULL, 'admin@example.com', 'admin', '1', NULL);
ALTER TABLE `Utente` ADD UNIQUE(`email`);
