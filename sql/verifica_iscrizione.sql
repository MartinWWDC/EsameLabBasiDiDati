CREATE OR REPLACE FUNCTION check_propedeuticita(id_studenteP varchar, id_insegnamentoP integer)
RETURNS boolean AS $$
DECLARE
    propedeuticita_count integer;
    b integer;
BEGIN
    SELECT COUNT(*) INTO propedeuticita_count
    FROM get_propedeuticità(id_insegnamentoP);
    select COUNT(*) INTO b
    from get_propedeuticità(id_insegnamentoP) p 
    inner join get_carriera_valida(id_studenteP) c on c.id_insegnamento=p.id_insegnamento; 
    if (propedeuticita_count= b) then
    	return true;
    else
    	return false;
    end if;
  	
END;
$$ LANGUAGE plpgsql;

SELECT * FROM check_propedeuticita('123456',5);
