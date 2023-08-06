

CREATE OR REPLACE FUNCTION update_cfu(id_studente varchar)
RETURNS void AS $$
DECLARE
    cfuV integer;
BEGIN
    SELECT sum(i.cfu) into cfuV
    FROM get_carriera_valida(id_studente) c 
    inner join insegnamento  i on i.id=c.id_insegnamento;

    UPDATE "Studente" 
    SET cfu =cfuV
    wHERE "Studente".matricola = id_studente;

END;
$$ LANGUAGE plpgsql;

SELECT * FROM update_cfu('123456');

