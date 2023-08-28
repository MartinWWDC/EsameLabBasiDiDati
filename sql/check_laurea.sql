CREATE OR REPLACE FUNCTION check_laurea(id_studenteP varchar)
RETURNS boolean AS $$
DECLARE
    tabella1 text[];
    tabella2 text[];
    idLaureaV INTEGER;
BEGIN 
    SELECT array_agg(nome_insegnamento) FROM get_carriera_valida(id_studenteP)
    INTO tabella1;
    
    SELECT "idLaurea" INTO idLaureaV
    FROM "Studente"
    WHERE matricola = id_studenteP;

    SELECT array_agg(nome_insegnamento) FROM get_lista_insegnamenti(idLaureaV)
    INTO tabella2;

    IF tabella1 = tabella2 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;
$$ LANGUAGE plpgsql;


SELECT check_laurea('123456');
