CREATE OR REPLACE FUNCTION add_voto(votoP integer, id_studenteP varchar, id_corsoP integer, "dataP" timestamp)
RETURNS void AS $$
BEGIN
	UPDATE sostiene 
	SET voto = votoP
	WHERE id_studente = id_studenteP AND id_corso = id_corsoP AND "data" = "dataP";
	PERFORM * FROM update_cfu(id_studenteP);

END;
$$ LANGUAGE plpgsql;

SELECT add_voto(30, '123456', 1, '2023-05-30 10:00:00');
