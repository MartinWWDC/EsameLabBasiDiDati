CREATE OR REPLACE FUNCTION get_carriera(id_studenteP varchar)
RETURNS TABLE (id_insegnamento integer, nome_insegnamento varchar, voto numeric) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", s.voto::numeric
    FROM insegnamento i 
    INNER JOIN sostiene s ON i.id = s.id_corso
    WHERE s.id_studente = id_studenteP;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_carriera('123456');
