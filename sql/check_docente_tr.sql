CREATE OR REPLACE FUNCTION check_docente()
RETURNS trigger AS $$
DECLARE
    counter INTEGER;
BEGIN 
    SELECT COUNT(responsabile) INTO counter
    FROM insegnamento
    WHERE responsabile = NEW.email;

    IF counter = 0 THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'docente non associato a nessun insegnamento'; 
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_docente_insert_tr
BEFORE INSERT ON docente
FOR EACH ROW 
EXECUTE FUNCTION check_docente();

CREATE TRIGGER check_docente_update_tr
BEFORE UPDATE ON docente
FOR EACH ROW 
EXECUTE FUNCTION check_docente();
