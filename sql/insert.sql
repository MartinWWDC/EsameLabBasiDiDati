--DEPRECATI
INSERT INTO "corsoDiLaurea" ("id", "nome", "durata", "anno")
VALUES (0,'informatica', 3, '2022');
INSERT INTO "corsoDiLaurea" ("id", "nome", "durata", "anno")
VALUES (1,'informatica musicale', 3, '2022');
INSERT INTO "corsoDiLaurea" ("id", "nome", "durata", "anno")
VALUES (2,'chimica', 3, '2022');

INSERT INTO "docente" ("email", "pass", "nome", "cognome")
VALUES ('docente@example.com', 'password', 'mario', 'rossi');
INSERT INTO "docente" ("email", "pass", "nome", "cognome")
VALUES ('docentemusicale@example.com', 'password', 'mario', 'rossi');



INSERT INTO "Studente" ("matricola", "email", "pass", "nome", "cognome", "cfu", "cellulare", "idLaurea")
VALUES ('123456', 'studente@example.com', 'miao', 'miao', 'CognomeStudente', 0, '1234567890', 1);


INSERT INTO "insegnamento" ("nomeInsegnamento", "annoConsigliato", "corsoDiAppartenenza", "responsabile")
VALUES ('miaologia', 1, 1, 'docente@example.com');
INSERT INTO "insegnamento" ("nomeInsegnamento", "annoConsigliato", "corsoDiAppartenenza", "responsabile")
VALUES ('simologia', 1, 1, 'docente@example.com');

INSERT INTO "appello" ("dataA", "luogo", "corso")
VALUES ('2023-05-30 10:00:00', 'Aula 101', 1);
INSERT INTO "appello" ("dataA", "luogo", "corso")
VALUES ('2023-05-20 10:00:00', 'Aula 101', 2);
INSERT INTO "appello" ("dataA", "luogo", "corso")
VALUES ('2023-05-29 10:00:00', 'Aula 101', 2);

INSERT INTO "sostiene" ("id_corso", "data", "id_studente", "voto")
VALUES (1, '2023-05-30 10:00:00', '123456', 18);
INSERT INTO "sostiene" ("id_corso", "data", "id_studente", "voto")
VALUES (1, '2023-05-20 10:00:00', '123456', 30);
iNSERT INTO "sostiene" ("id_corso", "data", "id_studente", "voto")
VALUES (1, '2023-05-29 10:00:00', '123456', 10);
