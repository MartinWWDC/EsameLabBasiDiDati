# to do

- [x] installa mark text su ubuntu
- [x] add cfu to insegnamento 
- [x] update  db with domains
- [x] fix  insegnamento globale e non più 
- [x] fix di tutti i create con le transaction
- [x] fix create insengnamento 
- [x] archivio
- [x] demo web
- [x] update
- [x] studente inattivo
- [x] finalizza interfaccia 
- [x] gestione erorri 
- [x] fix date create appello  
- [x] fix docente data di nascita timestamp  
- [x] fix percorsi assoluti con percorsi relativi
- [ ] (optional) refactor email generation function 
- [x] (optional) studente data di nascita
- [x] remove update appello with transaction
- [x] implement propedeuticità
- [x] fix style
- [x] sostituisci cellulare con data di nascità in Studente e termina il creaStudente.php
- [x] remove responsabile from insengamento
- [x] FIX ARCHIVIO

# Note

doecente di default per segnalare il mancato assegnamento di un insegnamento è  'null'  

Propedeuticità:

- id_insegnamento: insegnamento normale
- id_insegnamento_propedeutico: insegnamento che bisogna aver conseguito per poter iscriversi all'insegnamento 'insegnamento normale'

## Note Installazione

import db:

t@t-Surface-Pro:~/Downloads$ psql -U postgres test < dump.sql

# Road Map

- [x] Fix sql

- [x] setup ambiente 

- [x] create domanins

- [x] popolare db

- [x] sviluppo trigger

- [x] sviluppo funzioni

- [x] sviluppo interfaccia

- [x] check export db

- [x] convert create function into trigger before insert

- [x] refactoring nomi  

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
  
  - [x] finito 

* sposta Studente in archivio
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

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

* Controllo sovrapposizione esami Calendario 
  
  Controlla che non avvengano due appelli nello stesso giorni di insegnamenti appartenenti allo stesso corso di laurea e dello stesso anno 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

* controllo anno previsto di un insegnamento  sia coerente con  il corso di laurea 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito
- checkInsegnamentoDocente
  
  questo trigger si occupa di controllare che un docente quando viene creato non  venga associato ad un insengamento con già un docente  associato 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- checkDocenteInsegnamento
  
  sfruttando la transaction in create docente si occupa di controllare che abbia sempre un docente abbia sempre un insegnamento associato
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- check_docente
  controlla quando un insengnante viene inserito che abbia associato  un insegnamento
  
  # Lista Metodi

- produzione carriera completa di uno studente
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- Produzione della carriera valida di uno studente
  
  - dato l'id dello  studente come parametro realizzare una funzione  che restituisca tutti gli insengamenti dove risulta che lo studente abbia sostenuto un appello e  il voto preso durante l'ultima volta che ha sostenuto l'esame sia maggiore o uguale di 18
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- Produzione delle informazioni su un corso di laurea
  
  restituisce  tutti gli insegnamenti associati 

- - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- check laurea
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- Add voto 
  
  Dato un appelo e uno studente  viene aggiunto  il voto e aggiornato  richiamando l'apposita funzione  trigger che ogni volta che viene  aggiunto un  esame 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- update cfue
  
  dato l'id di uno studente  controlla le materie da lui passate e aggiorna i cfu 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

- produzione carriera studenti inattivi 
  
  dato l'id di uno studente inattivo restituisce la sua carriera 
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] finito

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
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] add transaction
  
  - [x] finito

- creaInsengamento  **Deprecato**
  
  tutti gli insegnamenti vengono creati con associati un docente null
  
  - [x] da implementare
  
  - [x] da popolare
  
  - [x] da testare 
  
  - [x] add transaction 
  
  - [x] finito

- aggiornaResponsabil **Deprecato**
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

- CreateStudente **Deprecato**
  
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

- Inserimento nuovo docente implica  che il docente sia z
