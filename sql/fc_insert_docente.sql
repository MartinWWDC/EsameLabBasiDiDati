CREATE OR REPLACE FUNCTION create_docente(email varchar,pass varchar,nome varchar,cognome varchar,idIns integer)
RETURNS void AS $$
DECLARE
    id integer;
BEGIN
    INSERT INTO "docente" ("email", "pass", "nome", "cognome")
    VALUES (email, pass, nome, cognome);
    
    UPDATE insegnamento
    SET responsabile =email
    wHERE insegnamento.id = idIns;

    
END;
$$ LANGUAGE plpgsql;

select create_docente('email', 'varchar','varchar', 'varchar',6)