CREATE OR REPLACE FUNCTION docente_insegnamento()
RETURNS trigger AS $$
DECLARE
    counter INTEGER;
BEGIN
    SELECT count(*) INTO counter
    FROM insegnamento
    WHERE responsabile = NEW.responsabile;

    IF counter >= 3 THEN
        RAISE EXCEPTION 'Limite massimo raggiunto';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER docente_insegnamento_tr
BEFORE UPDATE or INSERT ON insegnamento
FOR EACH ROW
EXECUTE FUNCTION docente_insegnamento();
