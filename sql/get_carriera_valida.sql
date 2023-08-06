CREATE OR REPLACE FUNCTION get_carriera_valida(id_studenteP varchar)
RETURNS TABLE (id_insegnamento integer, nome_insegnamento varchar, voto numeric,data_sostenimento date ) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", s.voto::numeric,s.data::date
    FROM insegnamento i 
    INNER JOIN sostiene s ON i.id = s.id_corso
    WHERE s.id_studente = id_studenteP
        AND s.data = (
            SELECT MAX(data)
            FROM sostiene
            WHERE sostiene.id_corso = s.id_corso AND sostiene.id_studente = s.id_studente
        )
        AND s.voto >= 18
        AND s.voto IS NOT NULL;
    RETURN;
END;
$$ LANGUAGE plpgsql;


SELECT * FROM get_carriera_valida('123456');

