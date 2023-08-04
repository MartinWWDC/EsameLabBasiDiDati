CREATE OR REPLACE FUNCTION check_duplicate_appello()
RETURNS TRIGGER AS $$
DECLARE
    appello_count INTEGER;
    anno_consigliato INTEGER;
    id_laurea INTEGER;
BEGIN
    SELECT "annoConsigliato", "corsoDiAppartenenza"
    INTO anno_consigliato, id_laurea
    FROM insegnamento
    WHERE id = NEW.corso;

    SELECT COUNT(*) INTO appello_count
    FROM appello
    INNER JOIN insegnamento ON appello.corso = insegnamento.id
    WHERE appello."dataA"::date = NEW."dataA"::date
    AND insegnamento."annoConsigliato" = anno_consigliato
    AND insegnamento."corsoDiAppartenenza" = id_laurea;

    IF appello_count > 0 THEN
        RAISE EXCEPTION 'Esiste già un appello per lo stesso giorno con insegnamento dell''anno consigliato';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_duplicate_appello_tr
BEFORE INSERT ON appello
FOR EACH ROW
EXECUTE FUNCTION check_duplicate_appello();



INSERT INTO appello ("dataA", "luogo", "corso")
VALUES ('2023-05-30 10:00:00', 'Aula 101', 4);
