CREATE OR REPLACE FUNCTION check_esami()
RETURNS trigger AS $$
DECLARE
    idLaurea INTEGER;
BEGIN 
    SELECT "idLaurea" INTO idLaurea
    FROM "Studente"
    WHERE matricola = NEW.id_studente;

    IF NOT EXISTS (
        SELECT 1  
        FROM insegnamento 
        WHERE id = NEW.id_corso AND "corsoDiAppartenenza" = idLaurea
    ) THEN 
        RAISE EXCEPTION 'insegnamento non associato al corso di laurea che si frequenta';
    END IF;

    IF NOT check_propedeuticita(NEW.id_studente, NEW.id_corso) THEN
        RAISE EXCEPTION 'propedeuticità non rispettate';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE or replace TRIGGER check_esami_tr
BEFORE INSERT ON sostiene
FOR EACH ROW 
EXECUTE FUNCTION check_esami();
INSERT INTO sostiene (id_studente, id_corso , data, voto) VALUES ('111111', 6, '2023-05-31 10:00:00', 28);
