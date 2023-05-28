CREATE OR REPLACE  FUNCTION check_esami()
returns trigger as $$
declare
	idLaurea INTEGER;
begin 
	select idLaurea into idLaurea
	from Studente
	where matricola=NEW.id_studente;

	if not exists (
	select 1  
	from insegamento 
	where id=new.id_corso and corsoDiAppartenenza=idLaurea
	) then 
		raise exception 'insegamento non associato al corso di laurea che si frequenta'
	end if;

	return NEW;


$$ language plpgsql

create trigger check_esami_tr
	before insert in sostiene
	for each row 
	execute FUNCTION check_esami();