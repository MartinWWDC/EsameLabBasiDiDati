-- SQLBook: Code
CREATE DOMAIN voto AS integer
   CONSTRAINT valid_voto CHECK (VALUE >= 1 AND VALUE <= 30);
CREATE DOMAIN annoDiInsengnamento AS integer
   CONSTRAINT valid_annoDiInsengnamento CHECK (VALUE >= 1 AND VALUE <= 3);

CREATE DOMAIN annoDiInsengnamentoMag AS integer
   CONSTRAINT valid_annoDiInsengnamento CHECK (VALUE >= 1 AND VALUE <= 2);
  
CREATE TABLE "segreteria" (
  "email" VARCHAR(255) PRIMARY KEY,
  "pass" VARCHAR(255) NOT NULL
);

CREATE TABLE "docente" (
  "email" VARCHAR(255) PRIMARY KEY,
  "pass" VARCHAR(255) NOT NULL,
  "nome" VARCHAR(255) NOT NULL,
  "cognome" VARCHAR(255) NOT NULL,
   "dataDiNascita" date
);

CREATE TABLE "corsoDiLaurea" (
  "id" SERIAL PRIMARY KEY,
  "nome" varchar(255) NOT NULL,
  "durata" integer NOT NULL,
  "anno" varchar(255) NOT NULL
);

CREATE TABLE "insegnamento" (
  "id" SERIAL  PRIMARY KEY,
  "nomeInsegnamento" varchar(255),
  "annoConsigliato" INTEGER NOT NULL,
  "cfu" integer,
  "corsoDiAppartenenza" INTEGER NOT NULL REFERENCES "corsoDiLaurea" ("id"),
  "responsabile" VARCHAR(255) REFERENCES "docente" ("email")
);

CREATE TABLE "propedeuticita" (
  "id_insegnamento" INTEGER REFERENCES "insegnamento" ("id"),
  "id_insegnamento_propedeutico" INTEGER REFERENCES "insegnamento" ("id"),
  PRIMARY KEY ("id_insegnamento", "id_insegnamento_propedeutico")
);

CREATE TABLE "Studente" (
  "matricola" varchar(6) PRIMARY KEY,
  "email" varchar(255) UNIQUE NOT NULL,
  "pass" varchar(255) NOT NULL,
  "nome" varchar(255) NOT NULL,
  "cognome" varchar(255) NOT NULL,
  "cfu" integer DEFAULT 0,
  "idLaurea" INTEGER REFERENCES "corsoDiLaurea" ("id"),
  "dataN" date NOT NULL
);

CREATE TABLE "appello" (
  "dataA" timestamp,
  "luogo" varchar(255),
  "corso" integer REFERENCES "insegnamento" ("id"),
  PRIMARY KEY ("dataA", "corso")
);

CREATE TABLE "sostiene" (
  "id_corso" integer,
  "data" timestamp,
  "id_studente" varchar(6) REFERENCES "Studente" ("matricola"),
  "voto" integer,
  PRIMARY KEY ("id_corso", "data", "id_studente"),
  FOREIGN KEY ("id_corso", "data") REFERENCES "appello" ("corso", "dataA")
);



CREATE TABLE "studente_arc" (
  "matricola" varchar(6) PRIMARY KEY,
  "email" varchar(255) UNIQUE NOT NULL,
  "pass" varchar(255) NOT NULL,
  "nome" varchar(255) NOT NULL,
  "cognome" varchar(255) NOT NULL,
  "cfu" integer DEFAULT 0,
  "periodoInattivita" interval,
  "idLaurea" INTEGER REFERENCES "corsoDiLaurea" ("id"),
  "dataN" date NOT NULL
);

CREATE TABLE "voti_arc" (
  "id" SERIAL  PRIMARY KEY,
  "voto" voto NOT NULL,
  "dataEsame" date,
  "studente" varchar(6) REFERENCES "studente_arc" ("matricola")
);

CREATE TABLE "insegnamento_arc" (
  "id_voto" INTEGER REFERENCES "voti_arc" ("id"),
  "id_insegnamento" integer REFERENCES "insegnamento" ("id"),
  PRIMARY KEY ("id_voto", "id_insegnamento")
);


ALTER TABLE "voti_arc" ALTER COLUMN "voto" set DATA TYPE voto;
ALTER TABLE "sostiene" ALTER COLUMN "voto" set DATA TYPE voto;
ALTER TABLE "docente"  ADD COLUMN "dataDiNascita" date;
ALTER TABLE "corsoDiLaurea"  ADD COLUMN "desc" text;

ALTER TABLE "insegnamento" ALTER CONSTRAINT "insegnamento_responsabile_fkey" DEFERRABLE INITIALLY DEFERRED;
