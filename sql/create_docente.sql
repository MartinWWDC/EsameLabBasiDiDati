CREATE OR REPLACE FUNCTION create_docente(email varchar, pass varchar, nome varchar, cognome varchar, dataDiNascita date, id_insegnamentoP integer)
RETURNS void AS $$
BEGIN
    IF check_insegnamento(id_insegnamentoP) THEN
        BEGIN
        -- Inizia la transazione
        
        -- Inserimento del nuovo docente
        INSERT INTO "docente" ("email", "pass", "nome", "cognome", "dataDiNascita")
        VALUES (email, pass, nome, cognome, dataDiNascita);
        
        -- Aggiornamento del responsabile nell'insegnamento
        UPDATE insegnamento
        SET responsabile = email
        WHERE id = id_insegnamentoP;
        
       END;
        
    ELSE
        -- Solleva un'eccezione se l'insegnamento ha già un docente come responsabile
        RAISE EXCEPTION 'L''insegnamento ha già un docente come responsabile';
    END IF;
    
END;
$$ LANGUAGE plpgsql;

