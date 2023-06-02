CREATE OR REPLACE FUNCTION get_lista_insegnamenti(id_laurea INTEGER)
RETURNS TABLE (id_insegnamento integer, nome_insegnamento varchar, annoConsigliato numeric) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", i."annoConsigliato"::numeric
    FROM insegnamento i 
    WHERE i."corsoDiAppartenenza" = id_laurea;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_lista_insegnamenti('1');
