CREATE OR REPLACE FUNCTION get_carriera_valida_archivio(id_studente varchar)
RETURNS TABLE(id_insegnamento integer, nome_insegnamento varchar, voto voto, dataC date) AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", v.voto, v."dataEsame"
    FROM insegnamento i
    JOIN insegnamento_arc i_arc ON i.id = i_arc.id_insegnamento
    JOIN voti_arc v ON i_arc.id_voto = v.id
    WHERE v.studente = id_studente
    AND (i.id, v."dataEsame") IN (
        SELECT i_arc.id_insegnamento, MAX(v."dataEsame")
        FROM insegnamento_arc i_arc
        JOIN voti_arc v ON i_arc.id_voto = v.id
        WHERE v.studente = id_studente
        GROUP BY i_arc.id_insegnamento
    );
END;
$$ LANGUAGE plpgsql;


select * from get_carriera_valida_archivio('esem')
