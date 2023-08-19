CREATE OR REPLACE FUNCTION get_carriera_archivio(id_studente varchar)
RETURNS TABLE(id_insegnamento integer, nome_insegnamento varchar, voto voto, dataC date) AS $$
BEGIN
	RETURN QUERY
	SELECT i.id, i."nomeInsegnamento", v.voto,v."dataEsame"
	FROM insegnamento i
	JOIN insegnamento_arc i_arc ON i.id = i_arc.id_insegnamento
	JOIN voti_arc v ON i_arc.id_voto=v.id
	WHERE v.studente = id_studente;
END;
$$ LANGUAGE plpgsql;