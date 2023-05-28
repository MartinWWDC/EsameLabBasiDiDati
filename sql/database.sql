CREATE TABLE "segreteria" (
  "email" VARCHAR(255) PRIMARY KEY,
  "password" VARCHAR(255) NOT NULL
);

CREATE TABLE "docente" (
  "email" VARCHAR(255) PRIMARY KEY,
  "pass" VARCHAR(255) NOT NULL,
  "nome" VARCHAR(255) NOT NULL,
  "cognome" VARCHAR(255) NOT NULL
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
  "corsoDiAppartenenza" INTEGER NOT NULL REFERENCES "corsoDiLaurea" ("id"),
  "responsabile" VARCHAR(255) NOT NULL REFERENCES "docente" ("email")
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
  "cellulare" varchar(255) UNIQUE NOT NULL,
  "idLaurea" INTEGER REFERENCES "corsoDiLaurea" ("id")
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
  "email" varchar(255) NOT NULL,
  "nome" varchar(255) NOT NULL,
  "cognome" varchar(255) NOT NULL,
  "cellulare" varchar(255) UNIQUE NOT NULL,
  "perdiodoInattivita" timestamp NOT NULL,
  "idLaurea" INTEGER REFERENCES "corsoDiLaurea" ("id")
);

CREATE TABLE "voti_arc" (
  "id" SERIAL  PRIMARY KEY,
  "voto" INTEGER NOT NULL,
  "dataEsame" date,
  "studente" varchar(6) REFERENCES "studente_arc" ("matricola")
);

CREATE TABLE "insegnamento_arc" (
  "id_voto" INTEGER REFERENCES "voti_arc" ("id"),
  "id_insegnamento" integer REFERENCES "insegnamento" ("id"),
  PRIMARY KEY ("id_voto", "id_insegnamento")
);


ALTER TABLE "insegnamento"
ALTER COLUMN "cfu" SET DATA TYPE integer,
ALTER COLUMN "cfu" SET NOT NULL;
