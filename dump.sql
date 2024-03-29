--
-- PostgreSQL database dump
--

-- Dumped from database version 12.16 (Ubuntu 12.16-0ubuntu0.20.04.1)
-- Dumped by pg_dump version 12.16 (Ubuntu 12.16-0ubuntu0.20.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: esami; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA esami;


ALTER SCHEMA esami OWNER TO postgres;

--
-- Name: annodiinsengnamento; Type: DOMAIN; Schema: esami; Owner: postgres
--

CREATE DOMAIN esami.annodiinsengnamento AS integer
	CONSTRAINT valid_annodiinsengnamento CHECK (((VALUE >= 1) AND (VALUE <= 3)));


ALTER DOMAIN esami.annodiinsengnamento OWNER TO postgres;

--
-- Name: annodiinsengnamentomag; Type: DOMAIN; Schema: esami; Owner: postgres
--

CREATE DOMAIN esami.annodiinsengnamentomag AS integer
	CONSTRAINT valid_annodiinsengnamento CHECK (((VALUE >= 1) AND (VALUE <= 2)));


ALTER DOMAIN esami.annodiinsengnamentomag OWNER TO postgres;

--
-- Name: voto; Type: DOMAIN; Schema: esami; Owner: postgres
--

CREATE DOMAIN esami.voto AS integer
	CONSTRAINT valid_voto CHECK (((VALUE >= 1) AND (VALUE <= 30)));


ALTER DOMAIN esami.voto OWNER TO postgres;

--
-- Name: add_voto(integer, character varying, integer, timestamp without time zone); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.add_voto(votop integer, id_studentep character varying, id_corsop integer, "dataP" timestamp without time zone) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
	UPDATE sostiene 
	SET voto = votoP
	WHERE id_studente = id_studenteP AND id_corso = id_corsoP AND "data" = "dataP";
	PERFORM * FROM update_cfu(id_studenteP);

END;
$$;


ALTER FUNCTION esami.add_voto(votop integer, id_studentep character varying, id_corsop integer, "dataP" timestamp without time zone) OWNER TO postgres;

--
-- Name: archivia_studente_tr(); Type: FUNCTION; Schema: esami; Owner: username
--

CREATE FUNCTION esami.archivia_studente_tr() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    periodo_inattivita INTERVAL;
    record_voto RECORD;
    voto_id INTEGER;
BEGIN
    periodo_inattivita := calcola_periodo_inattivita(OLD.matricola);
    
    INSERT INTO studente_arc VALUES (OLD.matricola, OLD.email,OLD.pass, OLD.nome, OLD.cognome,OLD.cfu, periodo_inattivita,OLD."idLaurea",OLD."dataN");

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
$$;


ALTER FUNCTION esami.archivia_studente_tr() OWNER TO username;

--
-- Name: calcola_periodo_inattivita(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.calcola_periodo_inattivita(studente_id character varying) RETURNS interval
    LANGUAGE plpgsql
    AS $$
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
$$;


ALTER FUNCTION esami.calcola_periodo_inattivita(studente_id character varying) OWNER TO postgres;

--
-- Name: check_docente(); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_docente() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
    counter INTEGER;
BEGIN 
    SELECT COUNT(responsabile) INTO counter
    FROM insegnamento
    WHERE responsabile = NEW.email;

    IF counter > 0 THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'docente non associato a nessun insegnamento'; 
    END IF;
END;
$$;


ALTER FUNCTION esami.check_docente() OWNER TO postgres;

--
-- Name: check_duplicate_appello(); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_duplicate_appello() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    appello_count INTEGER;
    anno_consigliato INTEGER;
    id_laurea INTEGER;
BEGIN
    SELECT "annoConsigliato", "corsoDiAppartenenza"
    INTO anno_consigliato, id_laurea
    FROM insegnamento
    WHERE id = NEW.corso;

    SELECT COUNT(*) INTO appello_count
    FROM appello
    INNER JOIN insegnamento ON appello.corso = insegnamento.id
    WHERE appello."dataA"::date = NEW."dataA"::date
    AND insegnamento."annoConsigliato" = anno_consigliato
    AND insegnamento."corsoDiAppartenenza" = id_laurea;

    IF appello_count > 0 THEN
        RAISE EXCEPTION 'Esiste già un appello per lo stesso giorno con insegnamento dell''anno consigliato';
    END IF;

    RETURN NEW;
END;
$$;


ALTER FUNCTION esami.check_duplicate_appello() OWNER TO postgres;

--
-- Name: check_esami(); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_esami() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    idLaurea INTEGER;
BEGIN 
    SELECT "idLaurea" INTO idLaurea
    FROM "Studente"
    WHERE matricola = NEW.id_studente;

    IF NOT EXISTS (
        SELECT 1  
        FROM insegnamento 
        WHERE id = NEW.id_corso AND "corsoDiAppartenenza" = idLaurea
    ) THEN 
        RAISE EXCEPTION 'insegnamento non associato al corso di laurea che si frequenta';
    END IF;

    IF NOT check_propedeuticita(NEW.id_studente, NEW.id_corso) THEN
        RAISE EXCEPTION 'propedeuticità non rispettate';
    END IF;

    RETURN NEW;
END;
$$;


ALTER FUNCTION esami.check_esami() OWNER TO postgres;

--
-- Name: check_insegnamento(integer); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_insegnamento(idins integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    ref varchar;
BEGIN 
    SELECT responsabile INTO ref
    FROM insegnamento 
    WHERE id = idIns;

    IF ref IS NULL THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
    
END;
$$;


ALTER FUNCTION esami.check_insegnamento(idins integer) OWNER TO postgres;

--
-- Name: check_laurea(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_laurea(id_studentep character varying) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    tabella1 text[];
    tabella2 text[];
    idLaureaV INTEGER;
BEGIN 
    SELECT array_agg(nome_insegnamento) FROM get_carriera_valida(id_studenteP)
    INTO tabella1;
    
    SELECT "idLaurea" INTO idLaureaV
    FROM "Studente"
    WHERE matricola = id_studenteP;

    SELECT array_agg(nome_insegnamento) FROM get_lista_insegnamenti(idLaureaV)
    INTO tabella2;

    IF tabella1 = tabella2 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END;
$$;


ALTER FUNCTION esami.check_laurea(id_studentep character varying) OWNER TO postgres;

--
-- Name: check_propedeuticita(character varying, integer); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.check_propedeuticita(id_studentep character varying, id_insegnamentop integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
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
$$;


ALTER FUNCTION esami.check_propedeuticita(id_studentep character varying, id_insegnamentop integer) OWNER TO postgres;

--
-- Name: create_docente(character varying, character varying, character varying, character varying, date, integer); Type: FUNCTION; Schema: esami; Owner: leone
--

CREATE FUNCTION esami.create_docente(email character varying, pass character varying, nome character varying, cognome character varying, datadinascita date, id_insegnamentop integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF check_insegnamento(id_insegnamentoP) THEN
        BEGIN
        -- Inizia la transazione
        UPDATE insegnamento
        SET responsabile = email
        WHERE id = id_insegnamentoP;
        -- Inserimento del nuovo docente
        INSERT INTO "docente" ("email", "pass", "nome", "cognome", "dataN")
        VALUES (email, pass, nome, cognome, dataDiNascita);
        
        -- Aggiornamento del responsabile nell'insegnamento
      
      
        
       END;
        
    ELSE
        -- Solleva un'eccezione se l'insegnamento ha già un docente come responsabile
        RAISE EXCEPTION 'L''insegnamento ha già un docente come responsabile';
    END IF;
    
END;
$$;


ALTER FUNCTION esami.create_docente(email character varying, pass character varying, nome character varying, cognome character varying, datadinascita date, id_insegnamentop integer) OWNER TO leone;

--
-- Name: create_insegnamento(character varying, integer, integer); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.create_insegnamento(nome character varying, annoconsigliato integer, corsodiappartenenza integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO "insegnamento" ("nomeInsegnamento", "annoConsigliato", "corsoDiAppartenenza", "responsabile")
    VALUES (nome, annoConsigliato, corsoDiAppartenenza, null);
    END;
$$;


ALTER FUNCTION esami.create_insegnamento(nome character varying, annoconsigliato integer, corsodiappartenenza integer) OWNER TO postgres;

--
-- Name: docente_insegnamento(); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.docente_insegnamento() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    counter INTEGER;
BEGIN
    SELECT count(*) INTO counter
    FROM insegnamento
    WHERE responsabile = NEW.responsabile;

    IF counter >= 3 THEN
        RAISE EXCEPTION 'Limite massimo raggiunto';
    END IF;

    RETURN NEW;
END;
$$;


ALTER FUNCTION esami.docente_insegnamento() OWNER TO postgres;

--
-- Name: get_carriera(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.get_carriera(id_studentep character varying) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying, voto numeric, data_sostenimento date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", s.voto::numeric,s.data::date
    FROM insegnamento i 
    INNER JOIN sostiene s ON i.id = s.id_corso
    WHERE s.id_studente = id_studenteP
    AND s.voto is NOT NULL
    order by s.data;
END;
$$;


ALTER FUNCTION esami.get_carriera(id_studentep character varying) OWNER TO postgres;

--
-- Name: get_carriera_archivio(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.get_carriera_archivio(id_studente character varying) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying, voto esami.voto, datac date)
    LANGUAGE plpgsql
    AS $$
BEGIN
	RETURN QUERY
	SELECT i.id, i."nomeInsegnamento", v.voto,v."dataEsame"
	FROM insegnamento i
	JOIN insegnamento_arc i_arc ON i.id = i_arc.id_insegnamento
	JOIN voti_arc v ON i_arc.id_voto=v.id
	WHERE v.studente = id_studente;
END;
$$;


ALTER FUNCTION esami.get_carriera_archivio(id_studente character varying) OWNER TO postgres;

--
-- Name: get_carriera_valida(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.get_carriera_valida(id_studentep character varying) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying, voto numeric, data_sostenimento date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", s.voto::numeric,s.data::date
    FROM insegnamento i 
    INNER JOIN sostiene s ON i.id = s.id_corso
    WHERE s.id_studente = id_studenteP
        AND s.data = (
            SELECT MAX(data)
            FROM sostiene
            WHERE sostiene.id_corso = s.id_corso AND sostiene.id_studente = s.id_studente
        )
        AND s.voto >= 18
        AND s.voto IS NOT NULL;
    RETURN;
END;
$$;


ALTER FUNCTION esami.get_carriera_valida(id_studentep character varying) OWNER TO postgres;

--
-- Name: get_carriera_valida_archivio(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.get_carriera_valida_archivio(id_studente character varying) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying, voto esami.voto, datac date)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", v.voto, v."dataEsame"
    FROM insegnamento i
    JOIN insegnamento_arc i_arc ON i.id = i_arc.id_insegnamento
    JOIN voti_arc v ON i_arc.id_voto = v.id
    WHERE v.studente = id_studente
    AND (i.id, v."dataEsame") IN (
        SELECT i_arc.id_insegnamento, MAX(v."dataEsame")
        FROM insegnamento_arc i_arc
        JOIN voti_arc v ON i_arc.id_voto = v.id
        WHERE v.studente = id_studente
        GROUP BY i_arc.id_insegnamento
    );
END;
$$;


ALTER FUNCTION esami.get_carriera_valida_archivio(id_studente character varying) OWNER TO postgres;

--
-- Name: get_lista_insegnamenti(integer); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.get_lista_insegnamenti(id_laurea integer) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying, annoconsigliato numeric)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento", i."annoConsigliato"::numeric
    FROM insegnamento i 
    WHERE i."corsoDiAppartenenza" = id_laurea;
END;
$$;


ALTER FUNCTION esami.get_lista_insegnamenti(id_laurea integer) OWNER TO postgres;

--
-- Name: get_propedeuticità(integer); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami."get_propedeuticità"(id_insegnamentop integer) RETURNS TABLE(id_insegnamento integer, nome_insegnamento character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY
    SELECT i.id, i."nomeInsegnamento"
    FROM insegnamento i
    inner join propedeuticita p on p.id_insegnamento_propedeutico=i.id
    where p.id_insegnamento=id_insegnamentoP;
    RETURN;
END;
$$;


ALTER FUNCTION esami."get_propedeuticità"(id_insegnamentop integer) OWNER TO postgres;

--
-- Name: update_cfu(character varying); Type: FUNCTION; Schema: esami; Owner: postgres
--

CREATE FUNCTION esami.update_cfu(id_studente character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    cfuV integer;
BEGIN
    SELECT COALESCE(sum(i.cfu), 0) INTO cfuV
    FROM get_carriera_valida(id_studente) c 
    INNER JOIN insegnamento i ON i.id = c.id_insegnamento;

    UPDATE "Studente" 
    SET cfu = cfuV
    WHERE "Studente".matricola = id_studente;

END;
$$;


ALTER FUNCTION esami.update_cfu(id_studente character varying) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: Studente; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami."Studente" (
    matricola character varying(6) NOT NULL,
    email character varying(255) NOT NULL,
    pass character varying(255) NOT NULL,
    nome character varying(255) NOT NULL,
    cognome character varying(255) NOT NULL,
    cfu integer DEFAULT 0,
    "idLaurea" integer,
    "dataN" date
);


ALTER TABLE esami."Studente" OWNER TO postgres;

--
-- Name: appello; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.appello (
    "dataA" timestamp without time zone NOT NULL,
    luogo character varying(255),
    corso integer NOT NULL
);


ALTER TABLE esami.appello OWNER TO postgres;

--
-- Name: corsoDiLaurea; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami."corsoDiLaurea" (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    durata integer NOT NULL,
    anno character varying(255) NOT NULL,
    "desc" text
);


ALTER TABLE esami."corsoDiLaurea" OWNER TO postgres;

--
-- Name: corsoDiLaurea_id_seq; Type: SEQUENCE; Schema: esami; Owner: postgres
--

CREATE SEQUENCE esami."corsoDiLaurea_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE esami."corsoDiLaurea_id_seq" OWNER TO postgres;

--
-- Name: corsoDiLaurea_id_seq; Type: SEQUENCE OWNED BY; Schema: esami; Owner: postgres
--

ALTER SEQUENCE esami."corsoDiLaurea_id_seq" OWNED BY esami."corsoDiLaurea".id;


--
-- Name: docente; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.docente (
    email character varying(255) NOT NULL,
    pass character varying(255) NOT NULL,
    nome character varying(255) NOT NULL,
    cognome character varying(255) NOT NULL,
    "dataN" date
);


ALTER TABLE esami.docente OWNER TO postgres;

--
-- Name: idlaureav; Type: TABLE; Schema: esami; Owner: leone
--

CREATE TABLE esami.idlaureav (
    "idLaurea" integer
);


ALTER TABLE esami.idlaureav OWNER TO leone;

--
-- Name: insegnamento; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.insegnamento (
    id integer NOT NULL,
    "nomeInsegnamento" character varying(255),
    "annoConsigliato" integer NOT NULL,
    cfu integer,
    "corsoDiAppartenenza" integer NOT NULL,
    responsabile character varying(255),
    "desc" text
);


ALTER TABLE esami.insegnamento OWNER TO postgres;

--
-- Name: insegnamento_id_seq; Type: SEQUENCE; Schema: esami; Owner: postgres
--

CREATE SEQUENCE esami.insegnamento_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE esami.insegnamento_id_seq OWNER TO postgres;

--
-- Name: insegnamento_id_seq; Type: SEQUENCE OWNED BY; Schema: esami; Owner: postgres
--

ALTER SEQUENCE esami.insegnamento_id_seq OWNED BY esami.insegnamento.id;


--
-- Name: propedeuticita; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.propedeuticita (
    id_insegnamento integer NOT NULL,
    id_insegnamento_propedeutico integer NOT NULL
);


ALTER TABLE esami.propedeuticita OWNER TO postgres;

--
-- Name: segreteria; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.segreteria (
    email character varying(255) NOT NULL,
    pass character varying(255) NOT NULL,
    "root " boolean
);


ALTER TABLE esami.segreteria OWNER TO postgres;

--
-- Name: sostiene; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.sostiene (
    id_corso integer NOT NULL,
    data timestamp without time zone NOT NULL,
    id_studente character varying(6) NOT NULL,
    voto esami.voto
);


ALTER TABLE esami.sostiene OWNER TO postgres;

--
-- Name: studente_arc; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.studente_arc (
    matricola character varying(6) NOT NULL,
    email character varying(255) NOT NULL,
    pass character varying(255) NOT NULL,
    nome character varying(255) NOT NULL,
    cognome character varying(255) NOT NULL,
    cfu integer DEFAULT 0,
    "periodoInattivita" interval,
    "idLaurea" integer,
    "dataN" date
);


ALTER TABLE esami.studente_arc OWNER TO postgres;

--
-- Name: voti_arc; Type: TABLE; Schema: esami; Owner: postgres
--

CREATE TABLE esami.voti_arc (
    id integer NOT NULL,
    voto esami.voto NOT NULL,
    "dataEsame" date,
    studente character varying(6)
);


ALTER TABLE esami.voti_arc OWNER TO postgres;

--
-- Name: voti_arc_id_seq; Type: SEQUENCE; Schema: esami; Owner: postgres
--

CREATE SEQUENCE esami.voti_arc_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE esami.voti_arc_id_seq OWNER TO postgres;

--
-- Name: voti_arc_id_seq; Type: SEQUENCE OWNED BY; Schema: esami; Owner: postgres
--

ALTER SEQUENCE esami.voti_arc_id_seq OWNED BY esami.voti_arc.id;


--
-- Name: g; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.g (
    pri numeric NOT NULL,
    t timestamp without time zone
);


ALTER TABLE public.g OWNER TO postgres;

--
-- Name: corsoDiLaurea id; Type: DEFAULT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami."corsoDiLaurea" ALTER COLUMN id SET DEFAULT nextval('esami."corsoDiLaurea_id_seq"'::regclass);


--
-- Name: insegnamento id; Type: DEFAULT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.insegnamento ALTER COLUMN id SET DEFAULT nextval('esami.insegnamento_id_seq'::regclass);


--
-- Name: voti_arc id; Type: DEFAULT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.voti_arc ALTER COLUMN id SET DEFAULT nextval('esami.voti_arc_id_seq'::regclass);


--
-- Data for Name: Studente; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami."Studente" (matricola, email, pass, nome, cognome, cfu, "idLaurea", "dataN") FROM stdin;
ma697	marco.antonio@studente.com	a	marco	antonio	0	6	2023-07-31
Mt882	Marco.tuttologo@studente.com	a	Marco	tuttologo	100	7	2023-07-12
\.


--
-- Data for Name: appello; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.appello ("dataA", luogo, corso) FROM stdin;
2023-08-29 00:19:00	Celoria 333\n	10
2023-09-03 00:00:00	Celoria 302	9
2023-09-11 14:54:00	Celoria 302\n	9
2023-09-09 09:09:00	Aula 7\n	11
2023-08-29 03:01:00	Aula 7	11
2023-08-30 08:08:00	Aula 7	11
\.


--
-- Data for Name: corsoDiLaurea; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami."corsoDiLaurea" (id, nome, durata, anno, "desc") FROM stdin;
6	Informatica	3	2023	corso di informatica
7	Laurea Brevissima	3	2023	laurea con solo un insegnamento 
\.


--
-- Data for Name: docente; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.docente (email, pass, nome, cognome, "dataN") FROM stdin;
Sebastiano.Vigna540@docente.com	a	Sebastiano	Vigna	1988-01-13
Cecilia.Cavaterra176@docente.com	a	Cecilia	Cavaterra	2023-08-10
\.


--
-- Data for Name: idlaureav; Type: TABLE DATA; Schema: esami; Owner: leone
--

COPY esami.idlaureav ("idLaurea") FROM stdin;
6
\.


--
-- Data for Name: insegnamento; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.insegnamento (id, "nomeInsegnamento", "annoConsigliato", cfu, "corsoDiAppartenenza", responsabile, "desc") FROM stdin;
9	Programmazione I	1	12	6	Sebastiano.Vigna540@docente.com	\N
8	Matermatica Del Continuo	1	12	6	Cecilia.Cavaterra176@docente.com	\N
10	Programmazione II	2	6	6	Sebastiano.Vigna540@docente.com	\N
11	Tuttologgia	1	100	7	Sebastiano.Vigna540@docente.com	\N
\.


--
-- Data for Name: propedeuticita; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.propedeuticita (id_insegnamento, id_insegnamento_propedeutico) FROM stdin;
10	9
\.


--
-- Data for Name: segreteria; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.segreteria (email, pass, "root ") FROM stdin;
root@segreteria.com	a	t
root100@segreteria.com	a	f
root15@segreteria.com	a	f
root49@segreteria.com	a	f
root27@segreteria.com	a	f
root84@segreteria.com	a	f
root38@segreteria.com	a	f
root35@segreteria.com	a	f
root60@segreteria.com	a	f
root23@segreteria.com	a	f
root18@segreteria.com	a	f
root24@segreteria.com	a	f
root42@segreteria.com	a	f
\.


--
-- Data for Name: sostiene; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.sostiene (id_corso, data, id_studente, voto) FROM stdin;
9	2023-09-03 00:00:00	ma697	26
10	2023-08-29 00:19:00	ma697	\N
9	2023-09-11 14:54:00	ma697	12
11	2023-08-29 03:01:00	Mt882	25
11	2023-08-30 08:08:00	Mt882	12
11	2023-09-09 09:09:00	Mt882	30
\.


--
-- Data for Name: studente_arc; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.studente_arc (matricola, email, pass, nome, cognome, cfu, "periodoInattivita", "idLaurea", "dataN") FROM stdin;
\.


--
-- Data for Name: voti_arc; Type: TABLE DATA; Schema: esami; Owner: postgres
--

COPY esami.voti_arc (id, voto, "dataEsame", studente) FROM stdin;
\.


--
-- Data for Name: g; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.g (pri, t) FROM stdin;
\.


--
-- Name: corsoDiLaurea_id_seq; Type: SEQUENCE SET; Schema: esami; Owner: postgres
--

SELECT pg_catalog.setval('esami."corsoDiLaurea_id_seq"', 7, true);


--
-- Name: insegnamento_id_seq; Type: SEQUENCE SET; Schema: esami; Owner: postgres
--

SELECT pg_catalog.setval('esami.insegnamento_id_seq', 11, true);


--
-- Name: voti_arc_id_seq; Type: SEQUENCE SET; Schema: esami; Owner: postgres
--

SELECT pg_catalog.setval('esami.voti_arc_id_seq', 17, true);


--
-- Name: Studente Studente_email_key; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami."Studente"
    ADD CONSTRAINT "Studente_email_key" UNIQUE (email);


--
-- Name: Studente Studente_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami."Studente"
    ADD CONSTRAINT "Studente_pkey" PRIMARY KEY (matricola);


--
-- Name: appello appello_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.appello
    ADD CONSTRAINT appello_pkey PRIMARY KEY ("dataA", corso);


--
-- Name: corsoDiLaurea corsoDiLaurea_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami."corsoDiLaurea"
    ADD CONSTRAINT "corsoDiLaurea_pkey" PRIMARY KEY (id);


--
-- Name: docente docente_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.docente
    ADD CONSTRAINT docente_pkey PRIMARY KEY (email);


--
-- Name: insegnamento insegnamento_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.insegnamento
    ADD CONSTRAINT insegnamento_pkey PRIMARY KEY (id);


--
-- Name: propedeuticita propedeuticita_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.propedeuticita
    ADD CONSTRAINT propedeuticita_pkey PRIMARY KEY (id_insegnamento, id_insegnamento_propedeutico);


--
-- Name: segreteria segreteria_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.segreteria
    ADD CONSTRAINT segreteria_pkey PRIMARY KEY (email);


--
-- Name: sostiene sostiene_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.sostiene
    ADD CONSTRAINT sostiene_pkey PRIMARY KEY (id_corso, data, id_studente);


--
-- Name: studente_arc studente_arc_email_key; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.studente_arc
    ADD CONSTRAINT studente_arc_email_key UNIQUE (email);


--
-- Name: studente_arc studente_arc_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.studente_arc
    ADD CONSTRAINT studente_arc_pkey PRIMARY KEY (matricola);


--
-- Name: voti_arc voti_arc_pkey; Type: CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.voti_arc
    ADD CONSTRAINT voti_arc_pkey PRIMARY KEY (id);


--
-- Name: g g_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.g
    ADD CONSTRAINT g_pkey PRIMARY KEY (pri);


--
-- Name: Studente before_delete_studenti; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER before_delete_studenti BEFORE DELETE ON esami."Studente" FOR EACH ROW EXECUTE FUNCTION esami.archivia_studente_tr();


--
-- Name: docente check_docente_insert_tr; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER check_docente_insert_tr BEFORE INSERT ON esami.docente FOR EACH ROW EXECUTE FUNCTION esami.check_docente();


--
-- Name: appello check_duplicate_appello_tr; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER check_duplicate_appello_tr BEFORE INSERT ON esami.appello FOR EACH ROW EXECUTE FUNCTION esami.check_duplicate_appello();


--
-- Name: appello check_duplicate_appello_tr_up; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER check_duplicate_appello_tr_up BEFORE UPDATE ON esami.appello FOR EACH ROW EXECUTE FUNCTION esami.check_duplicate_appello();


--
-- Name: sostiene check_esami_tr; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER check_esami_tr BEFORE INSERT ON esami.sostiene FOR EACH ROW EXECUTE FUNCTION esami.check_esami();


--
-- Name: insegnamento docente_insegnamento_tr; Type: TRIGGER; Schema: esami; Owner: postgres
--

CREATE TRIGGER docente_insegnamento_tr BEFORE INSERT OR UPDATE ON esami.insegnamento FOR EACH ROW EXECUTE FUNCTION esami.docente_insegnamento();


--
-- Name: Studente Studente_idLaurea_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami."Studente"
    ADD CONSTRAINT "Studente_idLaurea_fkey" FOREIGN KEY ("idLaurea") REFERENCES esami."corsoDiLaurea"(id);


--
-- Name: appello appello_corso_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.appello
    ADD CONSTRAINT appello_corso_fkey FOREIGN KEY (corso) REFERENCES esami.insegnamento(id);


--
-- Name: insegnamento insegnamento_corsoDiAppartenenza_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.insegnamento
    ADD CONSTRAINT "insegnamento_corsoDiAppartenenza_fkey" FOREIGN KEY ("corsoDiAppartenenza") REFERENCES esami."corsoDiLaurea"(id);


--
-- Name: insegnamento insegnamento_responsabile_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.insegnamento
    ADD CONSTRAINT insegnamento_responsabile_fkey FOREIGN KEY (responsabile) REFERENCES esami.docente(email) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: propedeuticita propedeuticita_id_insegnamento_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.propedeuticita
    ADD CONSTRAINT propedeuticita_id_insegnamento_fkey FOREIGN KEY (id_insegnamento) REFERENCES esami.insegnamento(id);


--
-- Name: propedeuticita propedeuticita_id_insegnamento_propedeutico_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.propedeuticita
    ADD CONSTRAINT propedeuticita_id_insegnamento_propedeutico_fkey FOREIGN KEY (id_insegnamento_propedeutico) REFERENCES esami.insegnamento(id);


--
-- Name: sostiene sostiene_id_corso_data_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.sostiene
    ADD CONSTRAINT sostiene_id_corso_data_fkey FOREIGN KEY (id_corso, data) REFERENCES esami.appello(corso, "dataA");


--
-- Name: sostiene sostiene_id_studente_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.sostiene
    ADD CONSTRAINT sostiene_id_studente_fkey FOREIGN KEY (id_studente) REFERENCES esami."Studente"(matricola);


--
-- Name: studente_arc studente_arc_idLaurea_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.studente_arc
    ADD CONSTRAINT "studente_arc_idLaurea_fkey" FOREIGN KEY ("idLaurea") REFERENCES esami."corsoDiLaurea"(id);


--
-- Name: voti_arc voti_arc_studente_fkey; Type: FK CONSTRAINT; Schema: esami; Owner: postgres
--

ALTER TABLE ONLY esami.voti_arc
    ADD CONSTRAINT voti_arc_studente_fkey FOREIGN KEY (studente) REFERENCES esami.studente_arc(matricola);


--
-- PostgreSQL database dump complete
--
