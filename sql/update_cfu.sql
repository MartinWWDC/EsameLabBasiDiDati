CREATE OR REPLACE FUNCTION update_cfu(id_studente varchar)
RETURNS void AS $$
DECLARE
    cfuV integer;
BEGIN
    SELECT COALESCE(sum(i.cfu), 0) INTO cfuV
    FROM get_carriera_valida(id_studente) c 
    INNER JOIN insegnamento i ON i.id = c.id_insegnamento;

    UPDATE "Studente" 
    SET cfu = cfuV
    WHERE "Studente".matricola = id_studente;

END;
$$ LANGUAGE plpgsql;

SELECT * FROM update_cfu('123456');

