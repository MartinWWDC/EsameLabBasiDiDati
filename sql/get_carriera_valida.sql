create or replace function get_carriera_valida(id_studente varchar)
returns table(id_insegnamento integer, nome_insegamento varchar,voto integer) as $$
BEGIN
	return QUERY

	select i.id_insegnamento, i.nome_insegamento,v.voto
	from insegnamento i 
	inner join sostiene s on i.id=s.id_corso
	where s.id_studente=id_studente
	and s.data=(
		select max(data)
		from sostiene
		where id_corso=s.id_corso and id_studente=s.id_studente
		)
	
	and s.voto>=18
	
	and s.voto is not null;
	return;
END;

$$ language plpgsql;