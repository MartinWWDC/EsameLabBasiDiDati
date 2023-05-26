CREATE TABLE segreteria (
    email VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255)
);

CREATE TABLE docente (
    email VARCHAR(255) PRIMARY KEY,
    pass VARCHAR(255),
    nome VARCHAR(255),
    cognome VARCHAR(255)
);



CREATE TABLE corsoDiLaurea (
    id INTEGER PRIMARY KEY,
    nome varchar(255),
    anno varchar(255)
 );

CREATE TABLE insegnamento (
    id INTEGER PRIMARY KEY,
    nome_insegnamento varchar(255),
    cfu INTEGER,
    corsoDiAppartenenza INTEGER references corsoDiLaurea(id),
    responsabile VARCHAR(255) REFERENCES docente(email)
);

CREATE TABLE propedeuticita (
    id_insegnamento INTEGER,
    id_insegnamento_propedeutico INTEGER,
    PRIMARY KEY (id_insegnamento, id_insegnamento_propedeutico),
    FOREIGN KEY (id_insegnamento) REFERENCES insegnamento(id),
    FOREIGN KEY (id_insegnamento_propedeutico) REFERENCES insegnamento(id)
);

CREATE TABLE Studente (
    matricola varchar(6) PRIMARY KEY,
    email varchar(255),
    pass varchar(255),
    nome varchar(255),
    cognome varchar(255),
    cellulare varchar(255),
    idLaurea INTEGER references corsoDiLaurea(id)
    );
    
CREATE TABLE appello (
    id INTEGER PRIMARY KEY,
    dataA timestamp,
    luogo varchar(255),
    corsodilaurea integer REFERENCES corsoDiLaurea(id)
);

CREATE TABLE sostiene (
    id_appello INTEGER,
    id_studente varchar(6),
    voto integer,
    PRIMARY KEY (id_appello, id_studente),
    FOREIGN KEY (id_appello) REFERENCES appello(id),
    FOREIGN KEY (id_studente) REFERENCES Studente(matricola)
);
CREATE TABLE studente_arc (
    matricola varchar(6) PRIMARY KEY,
    email varchar(255),
    nome varchar(255),
    cognome varchar(255),
    cellulare varchar(255),
    idLaurea INTEGER references corsoDiLaurea(id)
    );

CREATE TABLE voti_arc (
    id INTEGER primary key,
    voto INTEGER not null,
    dataEsame date,
    studente varchar(6) references studente_arc(matricola)
);
CREATE TABLE insegnamento_arc (
    id_voto INTEGER,
    id_insegnamento integer,
    PRIMARY KEY (id_voto, id_insegnamento),
    FOREIGN KEY (id_voto) REFERENCES Voti_arch(id),
    FOREIGN KEY (id_insegnamento) REFERENCES insegnamento(id)
);
