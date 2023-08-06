CREATE OR REPLACE FUNCTION get_propedeuticità(id_insegnamentoP integer)
RETURNS TABLE (id_insegnamento integer, nome_insegnamento varchar) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento"
    FROM insegnamento i
    inner join propedeuticita p on p.id_insegnamento_propedeutico=i.id
    where p.id_insegnamento=id_insegnamentoP;
    RETURN;
END;
$$ LANGUAGE plpgsql;


SELECT * FROM get_propedeuticità(5);

