
CREATE OR REPLACE FUNCTION create_insegnamento(nome varchar,annoConsigliato integer,corsoDiAppartenenza integer)
RETURNS void AS $$
BEGIN
    INSERT INTO "insegnamento" ("nomeInsegnamento", "annoConsigliato", "corsoDiAppartenenza", "responsabile")
    VALUES (nome, annoConsigliato, corsoDiAppartenenza, 'null');
    END;
$$ LANGUAGE plpgsql;

SELECT create_insegnamento('null',3,1);
