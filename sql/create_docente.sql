CREATE OR REPLACE FUNCTION create_docente(email varchar,pass varchar,nome varchar,cognome varchar,dataDiNascita date, id_insegnamentoP integer)
RETURNS void AS $$
BEGIN
    if check_insegnamento then
        INSERT INTO "docente" ("email", "pass", "nome", "cognome","dataDiNascita")
        VALUES (email, pass, nome, cognome,dataDiNascita);
        UPDATE insegnamento
        set responsabile=email
        wHERE id=id_insegnamentoP;
    else
       RAISE EXCEPTION 'insegnamento ha già un docente come responsabile';
    end if;
    END;
$$ LANGUAGE plpgsql;

SELECT create_docente('test@gino.com','pass','marco','campolongo','2019/04/05', 1);
