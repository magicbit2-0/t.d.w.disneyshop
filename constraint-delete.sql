/*ALTER TABLE parola_chiave_regia
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
/*ALTER TABLE backstage_articolo
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