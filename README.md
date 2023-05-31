# to do

- [x] installa mark text su ubuntu
- [x] add cfu to insegnamento 
- [x] update  db with domains
- [ ] fix  insegnamento globale e non più 

# 

# Road Map

- [x] Fix sql

- [x] setup ambiente 

- [x] create domanins

- [ ] 

- [ ] popolare db

- [ ] sviluppo trigger

- [ ] sviluppo funzioni

- [ ] sviluppo interfaccia

- [ ] fix nome colonne

- [ ] check export db

# Lista Presupposti

* Uno studente in archivo non può essere recuperato in quanto i motivi per cui si trova in archivio sono o perchè è laureato o perchè ha rinunciato agli studi 

# Lista Trigger

* check_max_Insengamento
  
  * Controllo di non avere un insegnate responsabile di più di 3 insegnamenti
  
  * Controllo almeno di un insegnamento  di cui è responsabile 
  
  * dato il database di prima crea un trigger  dove ti assicurati che ogni volta che viene  aggiunto un insegamento dove nella chiave esterna fa riferimento ad un professore assicurati che quel docente non abbia già più di 3 insegnamenti associati
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [ ] finito 

* sposta Studente in archivio 
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

* ControlloPropeedeuticità 
  
  * controllo che uno studente sia stato prommosso per gli esami propedeutica
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

* Controllo Iscrizione Esame corso di laurea
  
  * Quando uno studente decide di iscriversi ad un appello controlliamo  che l'insegnamento a cui fa riferimento il suddetto appello  faccia parte degli esami inerenti alla laurea a cui lo studente è iscritto inoltre dopo aver controllato che  l'insegnamento sia valido ci assicuriamo  che non sia presente mai presente nella colonna id_insegnamento  all'interno della tabella propedeuticità.  se dovesse essere presente allora controlleremo se all'interno della tabella sostiene vi sia una riga che faccia riferimento allo studente e al corso con id uguale ad id_insegamento_propedeutico presente all'interno della tabella propedeuticità e inoltre il voto nella tabella sostiene dovrà essere maggiore o uguale a 18
  
  * dipedenze:
    
    * get_carriera 
    
    * get propedeuticità 
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

* Controllo sovrapposizione esami Calendario (on going)
  
  Controlla che non avvengano due appelli nello stesso giorni di insegnamenti appartenenti allo stesso corso di laurea e dello stesso anno 
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

* controllo anno previsto di un insegnamento  sia coerente con  il corso di laurea 
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

# Lista Metodi

- produzione carriera completa di uno studente
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- Produzione della carriera valida di uno studente
  
  - dato l'id dello  studente come parametro realizzare una funzione  che restituisca tutti gli insengamenti dove risulta che lo studente abbia sostenuto un appello e  il voto preso durante l'ultima volta che ha sostenuto l'esame sia maggiore o uguale di 18
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- Produzione delle informazioni su un corso di laurea

- - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- check laurea
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- calcolo cfu
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- produzione carriera studenti inattivi
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- get_propedeuticità
  
  funzione che restituisce le propedeuticità di un esame 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- check_prodeteuticità
  
  dato in input uno studente e l'id di un corso controlla se lo studente può o meno iscriversei al quel corso  grazie alle sue prodeteuticità 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- create_docente(email varchar,pass varchar,nome varchar,cognome varchar,idIns integer)
  
  crea un docente e gli  associa direttamente un insegnamento (unico modo per creare un docente)

- nuovo_anno_accademico (deprecata)
  
  dato in input l'id di un corso di laurea si  occupa di creare un corso di laurea per l'anno successivo clonando e aggiornando tutti gli insegnamenti
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

# Domini

* voto
  
  * crea un dominio chiamato voto che è un integere che può avere un valore da 1 a 30

* anno di insegnamento

* ragione presenza in archvio

# Insert Test

## Random Insert

- Corso di laurea 
  
  ```sql
  INSERT INTO "corsoDiLaurea" ("id", "nome", "durata", "anno")
  VALUES ('informatica', 3, '2022');
  ```

# Domande

- [x] controllo validità docente e corso

# Note:

- cancellazione docente non necessaria

- Inserimento nuovo docente implica  che il docente sia 
