CREATE OR REPLACE FUNCTION get_propedeuticità(id_insegnamentoP integer)
RETURNS TABLE (id_insegnamento integer, nome_insegnamento) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento"
    FROM insegnamento i AND propedeuticita
    where propedeuticita.id_insegnamento=i.id
    RETURN;
END;
$$ LANGUAGE plpgsql;


SELECT * FROM get_propedeuticità('4');

