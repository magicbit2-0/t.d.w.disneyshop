INSERT INTO `disneydb`.`utente` (`id`, `username`, `nome`, `cognome`, `data_nascita`, `email`, `paese`, `regione`, `indirizzo`, `password`, `avatar_id`) VALUES ('1', 'enrico00', 'Enrico Simone', 'Adamelli', '16/01/2000', 'enricosimone.adamelli@student.univaq.it', 'Italia', 'Abruzzo', 'Via Sulmona n°3', 'enrico', '1');
INSERT INTO `disneydb`.`utente` (`id`, `username`, `nome`, `cognome`, `data_nascita`, `email`, `paese`, `regione`, `indirizzo`, `password`, `avatar_id`) VALUES ('2', 'martina99', 'Martina', 'Nolletti', '24/05/1999', 'martina.nolletti@student.univaq.it', 'Italia', 'Abruzzo', 'Piazza dei Longobardi n°6', 'martina', '6');
INSERT INTO `disneydb`.`utente` (`id`, `username`, `nome`, `cognome`, `data_nascita`, `email`, `paese`, `regione`, `indirizzo`, `password`, `avatar_id`) VALUES ('3', 'michele99', 'Michele', 'Intrevado', '16/06/1999', 'michele.intrevado@student.univaq.it', 'Italia', 'Abruzzo', 'Via Carlo Montari n°11', 'michele', '8');

INSERT INTO `disneydb`.`gruppo_utente` (`id`, `utente_id`, `gruppo_id`) VALUES ('1', '1', '1');
INSERT INTO `disneydb`.`gruppo_utente` (`id`, `utente_id`, `gruppo_id`) VALUES ('2', '2', '1');
INSERT INTO `disneydb`.`gruppo_utente` (`id`, `utente_id`, `gruppo_id`) VALUES ('3', '3', '2');

INSERT INTO `disneydb`.`gruppo` (`id`, `tipologia utente`) VALUES ('1','cliente');
INSERT INTO `disneydb`.`gruppo` (`id`, `tipologia utente`) VALUES ('1','amministratore');
