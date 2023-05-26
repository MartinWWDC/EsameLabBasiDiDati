# to do

- [ ] installa mark text su ubuntu

# Road Map

- [x] Fix sql

- [x] setup ambiente 

- [ ] popolare db

- [ ] sviluppo trigger

- [ ] sviluppo funzioni

- [ ] sviluppo interfaccia

# Lista Trigger

* check_max_Insengamento
  
  * Controllo di non avere un insegnate responsabile di più di 3 insegnamenti
  
  * Controllo almeno di un insegnamento  di cui è responsabile 
  
  * dato il database di prima crea un trigger  dove ti assicurati che ogni volta che viene  aggiunto un insegamento dove nella chiave esterna fa riferimento ad un professore assicurati che quel docente non abbia già più di 3 insegnamenti associati
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito 

* sposta Studente in archivio 
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

* ControlloPropeedeuticità 
  
  * controllo che uno studente sia stato prommosso per gli esami propedeutica
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

* Controllo Iscrizione Esame corso di laurea
  
  * Quando uno studente decide di iscriversi ad un appello controlliamo  che l'insegnamento a cui fa riferimento il suddetto appello  faccia parte degli esami inerenti alla laurea a cui lo studente è iscritto inoltre dopo aver controllato che  l'insegnamento sia valido ci assicuriamo  che non sia presente mai presente nella colonna id_insegnamento  all'interno della tabella propedeuticità.  se dovesse essere presente allora controlleremo se all'interno della tabella sostiene vi sia una riga che faccia riferimento allo studente e al corso con id uguale ad id_insegamento_propedeutico presente all'interno della tabella propedeuticità e inoltre il voto nella tabella sostiene dovrà essere maggiore o uguale a 18
  - [x] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

* Controllo sovrapposizione esami Calendario
  
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
  
  - [ ] da implementare
  
  - [ ] da popolare
  
  - [ ] da testare 
  
  - [ ] finito

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
