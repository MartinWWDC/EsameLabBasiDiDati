CREATE OR REPLACE FUNCTION docente_insegnamento()
RETURNS trigger AS $$
DECLARE
    counter  INTEGER;
BEGIN 
    SELECT cout(*) into counter
    from insegnamento
    wHERE responsabile=NEW.responsabile
    if(counter>=3){

    }
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER docente_insegnamento_tr
BEFORE UPDATE ON insegnamento
FOR EACH ROW 
EXECUTE FUNCTION docente_insegnamento();
