CREATE OR REPLACE FUNCTION check_insegnamento(idIns integer)
RETURNS boolean AS $$
DECLARE
    ref varchar;
BEGIN 
    SELECT responsabile INTO ref
    FROM insegnamento 
    WHERE id = idIns;

    IF ref = null THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
    
END;
$$ LANGUAGE plpgsql;


SELECT check_insegnamento(10);
