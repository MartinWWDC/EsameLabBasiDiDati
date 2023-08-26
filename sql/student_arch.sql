


CREATE OR REPLACE FUNCTION calcola_periodo_inattivita(studente_id varchar)
RETURNS INTERVAL AS
$$
DECLARE
    data_sostenimento TIMESTAMP;
    is_laureato BOOLEAN;
BEGIN
    SELECT check_laurea(studente_id) into is_laureato;
    IF is_laureato THEN
        RETURN NULL;
    END IF; 
    -- Ottieni la data di sostenimento dell'esame più antico per lo studente
    SELECT g.data_sostenimento INTO data_sostenimento
    FROM get_carriera(studente_id) g
    ORDER BY g.data_sostenimento ASC
    LIMIT 1;

    IF data_sostenimento IS NULL THEN
        RETURN NULL;
    END IF;
    

    RETURN CURRENT_TIMESTAMP - data_sostenimento;
END;
$$
LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION archivia_studente_tr()
RETURNS TRIGGER AS
$$
DECLARE
    periodo_inattivita INTERVAL;
    record_voto RECORD;
    voto_id INTEGER;
BEGIN
    periodo_inattivita := calcola_periodo_inattivita(OLD.matricola);
    
    INSERT INTO studente_arc VALUES (OLD.matricola, OLD.email,OLD.pass, OLD.nome, OLD.cognome,OLD.cfu, periodo_inattivita,OLD."idLaurea", OLD."dataN");

    FOR record_voto IN SELECT * FROM get_carriera(OLD.matricola)
    LOOP
        IF record_voto.voto IS NOT NULL THEN
            INSERT INTO voti_arc (id,voto,"dataEsame",studente)
            VALUES (DEFAULT, record_voto.voto, record_voto.data_sostenimento, OLD.matricola) RETURNING id INTO voto_id;
            INSERT INTO insegnamento_arc(id_voto,id_insegnamento) VALUES (voto_id,record_voto.id_insegnamento);
            
        END IF;
        DELETE FROM Sostiene WHERE id_studente=OLD.matricola;
    END LOOP;
    
    RETURN OLD;

END;
$$
LANGUAGE plpgsql;


CREATE TRIGGER before_delete_studenti
BEFORE DELETE ON "Studente"
FOR EACH ROW
EXECUTE FUNCTION archivia_studente_tr();


DELETE from "Studente" where matricola='123456'
