create or replace function get_carriera_valida_archivio(id_studente varchar)
returns table(id_insegnamento integer, nome_insegamento varchar,voto integer) as $$
BEGIN
	return QUERY

	select i.id_insegnamento, i.nome_insegamento,v.voto
	from insegnamento i 
	--todo 
	return;
END;

$$ language plpgsql;