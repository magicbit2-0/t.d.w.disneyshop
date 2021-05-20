/*    ALTER TABLE parola_chiave_regia
drop CONSTRAINT fk_regia_has_parola_chiave_regia1;

ALTER TABLE parola_chiave_regia
ADD CONSTRAINT fk_regia_has_parola_chiave_regia1
    FOREIGN KEY (regia_id)
    REFERENCES regia
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE parola_chiave_regia
drop CONSTRAINT fk_regia_has_parola_chiave_parola_chiave1;

ALTER TABLE parola_chiave_regia
ADD CONSTRAINT fk_regia_has_parola_chiave_parola_chiave1
    FOREIGN KEY (parola_chiave_id)
    REFERENCES parola_chiave
        (id)
    ON DELETE CASCADE;*/
/*	  ALTER TABLE backstage_articolo
drop CONSTRAINT fk_regia_has_articolo_articolo1;

ALTER TABLE backstage_articolo
ADD CONSTRAINT fk_regia_has_articolo_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE backstage_articolo
drop CONSTRAINT fk_regia_has_articolo_regia1;

ALTER TABLE backstage_articolo
ADD CONSTRAINT fk_regia_has_articolo_regia1
    FOREIGN KEY (regia_id)
    REFERENCES regia
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE parola_chiave_notizia
drop CONSTRAINT fk_parola_chiave_has_notizia_notizia1;

ALTER TABLE parola_chiave_notizia
ADD CONSTRAINT fk_parola_chiave_has_notizia_notizia1
    FOREIGN KEY (notizia_id)
    REFERENCES notizia
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE parola_chiave_notizia
drop CONSTRAINT fk_parola_chiave_has_notizia_parola_chiave1;

ALTER TABLE parola_chiave_notizia
ADD CONSTRAINT fk_parola_chiave_has_notizia_parola_chiave1
    FOREIGN KEY (parola_chiave_id)
    REFERENCES parola_chiave
        (id)
    ON DELETE CASCADE;*/    
/*	  ALTER TABLE parola_chiave_personaggio
drop CONSTRAINT fk_personaggio_has_parola_chiave_parola_chiave1;

ALTER TABLE parola_chiave_personaggio
ADD CONSTRAINT fk_personaggio_has_parola_chiave_parola_chiave1
    FOREIGN KEY (parola_chiave_id)
    REFERENCES parola_chiave
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE parola_chiave_personaggio
drop CONSTRAINT fk_personaggio_has_parola_chiave_personaggio1;

ALTER TABLE parola_chiave_personaggio
ADD CONSTRAINT fk_personaggio_has_parola_chiave_personaggio1
    FOREIGN KEY (personaggio_id)
    REFERENCES personaggio
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE personaggio_articolo
drop CONSTRAINT fk_articolo_has_personaggio_articolo1;

ALTER TABLE personaggio_articolo
ADD CONSTRAINT fk_articolo_has_personaggio_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE personaggio_articolo
drop CONSTRAINT fk_articolo_has_personaggio_personaggio1;

ALTER TABLE personaggio_articolo
ADD CONSTRAINT fk_articolo_has_personaggio_personaggio1
    FOREIGN KEY (personaggio_id)
    REFERENCES personaggio
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE personaggio_attore_correlato
drop CONSTRAINT fk_personaggio_has_regia_personaggio1;

ALTER TABLE personaggio_attore_correlato
ADD CONSTRAINT fk_personaggio_has_regia_personaggio1
    FOREIGN KEY (personaggio_id)
    REFERENCES personaggio
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE personaggio_attore_correlato
drop CONSTRAINT fk_personaggio_has_regia_regia1;

ALTER TABLE personaggio_attore_correlato
ADD CONSTRAINT fk_personaggio_has_regia_regia1
    FOREIGN KEY (regia_id)
    REFERENCES regia
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE personaggio_correlato
drop CONSTRAINT fk_personaggio_has_personaggio_personaggio1;

ALTER TABLE personaggio_correlato
ADD CONSTRAINT fk_personaggio_has_personaggio_personaggio1
    FOREIGN KEY (personaggio_id)
    REFERENCES personaggio
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE personaggio_correlato
drop CONSTRAINT fk_personaggio_has_personaggio_personaggio2;

ALTER TABLE personaggio_correlato
ADD CONSTRAINT fk_personaggio_has_personaggio_personaggio2
    FOREIGN KEY (personaggio_correlato_id)
    REFERENCES personaggio
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE regia_correlato
drop CONSTRAINT fk_regia_has_regia_regia1;

ALTER TABLE regia_correlato
ADD CONSTRAINT fk_regia_has_regia_regia1
    FOREIGN KEY (regia_id)
    REFERENCES regia
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE regia_correlato
drop CONSTRAINT fk_regia_has_regia_regia2;

ALTER TABLE regia_correlato 
ADD CONSTRAINT fk_regia_has_regia_regia2
    FOREIGN KEY (regia_correlato_id)
    REFERENCES regia
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE articolo_correlato
drop CONSTRAINT fk_articolo_has_articolo_articolo1;

ALTER TABLE articolo_correlato
ADD CONSTRAINT fk_articolo_has_articolo_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE articolo_correlato
drop CONSTRAINT fk_articolo_has_articolo_articolo2;

ALTER TABLE articolo_correlato 
ADD CONSTRAINT fk_articolo_has_articolo_articolo2
    FOREIGN KEY (articolo_correlato_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE; */
 /*   ALTER TABLE articolo_ordinato
drop CONSTRAINT fk_articolo_has_ordine_articolo1;

ALTER TABLE articolo_ordinato
ADD CONSTRAINT fk_articolo_has_ordine_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE articolo_ordinato
drop CONSTRAINT fk_articolo_has_ordine_ordine1;

ALTER TABLE articolo_ordinato 
ADD CONSTRAINT fk_articolo_has_ordine_ordine1
    FOREIGN KEY (ordine_id)
    REFERENCES ordine
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE articolo_parola_chiave
drop CONSTRAINT fk_articolo_has_parola_chiave_articolo1;

ALTER TABLE articolo_parola_chiave
ADD CONSTRAINT fk_articolo_has_parola_chiave_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE articolo_parola_chiave
drop CONSTRAINT fk_articolo_has_parola_chiave_parola_chiave1;

ALTER TABLE articolo_parola_chiave 
ADD CONSTRAINT fk_articolo_has_parola_chiave_parola_chiave1
    FOREIGN KEY (parola_chiave_id)
    REFERENCES parola_chiave
        (id)
    ON DELETE CASCADE;*/
 /*   ALTER TABLE articolo_preferito
drop CONSTRAINT fk_articolo_has_utente_articolo1;

ALTER TABLE articolo_preferito
ADD CONSTRAINT fk_articolo_has_utente_articolo1
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE articolo_preferito
drop CONSTRAINT fk_articolo_has_utente_utente1;

ALTER TABLE articolo_preferito 
ADD CONSTRAINT fk_articolo_has_utente_utente1
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE gruppo_utente
drop CONSTRAINT fk_utente_has_gruppo_gruppo1;

ALTER TABLE gruppo_utente
ADD CONSTRAINT fk_utente_has_gruppo_gruppo1
    FOREIGN KEY (gruppo_id)
    REFERENCES gruppo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE gruppo_utente
drop CONSTRAINT fk_utente_has_gruppo_utente;

ALTER TABLE gruppo_utente 
ADD CONSTRAINT fk_utente_has_gruppo_utente
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/
 /*   ALTER TABLE indirizzo_spedizione
drop CONSTRAINT fk_indirizzo_spedizione_utente1;

ALTER TABLE indirizzo_spedizione
ADD CONSTRAINT fk_indirizzo_spedizione_utente1
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE metodo_pagamento
drop CONSTRAINT fk_metodo_pagamento_utente1;

ALTER TABLE metodo_pagamento
ADD CONSTRAINT fk_metodo_pagamento_utente1
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/
 /*   ALTER TABLE utente
drop CONSTRAINT fk_utente_avatar1;

ALTER TABLE utente
ADD CONSTRAINT fk_utente_avatar1
    FOREIGN KEY (avatar_id)
    REFERENCES avatar
        (id)
	ON UPDATE CASCADE;*/
/*   ALTER TABLE recensione
drop CONSTRAINT fk_recensione_articolo;

ALTER TABLE recensione
ADD CONSTRAINT fk_recensione_articolo
    FOREIGN KEY (articolo_id)
    REFERENCES articolo
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE recensione
drop CONSTRAINT fk_recensione_utente;

ALTER TABLE recensione 
ADD CONSTRAINT fk_recensione_utente
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/
/*    ALTER TABLE commento
drop CONSTRAINT fk_commento_notizia1;

ALTER TABLE commento
ADD CONSTRAINT fk_commento_notizia1
    FOREIGN KEY (notizia_id)
    REFERENCES notizia
        (id)
    ON DELETE CASCADE;
    
    ALTER TABLE commento
drop CONSTRAINT fk_commento_utente1;

ALTER TABLE commento 
ADD CONSTRAINT fk_commento_utente1
    FOREIGN KEY (utente_id)
    REFERENCES utente
        (id)
    ON DELETE CASCADE;*/