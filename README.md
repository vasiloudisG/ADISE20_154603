Table of Contents
=================
   * [Εγκατάσταση](#εγκατάσταση)
      * [Απαιτήσεις](#απαιτήσεις)
      * [Οδηγίες Εγκατάστασης](#οδηγίες-εγκατάστασης)
   * [Περιγραφή API](#περιγραφή-api)
      * [Methods](#methods)
         * [Board](#board)
            * [Ανάγνωση Board](#ανάγνωση-board)
            * [Αρχικοποίηση Board](#αρχικοποίηση-board)
         * [Piece](#piece)
            * [Ανάγνωση Θέσης/Πιονιού](#ανάγνωση-θέσηςπιονιού)
            * [Μεταβολή Θέσης Πιονιού](#μεταβολή-θέσης-πιονιού)
         * [Player](#player)
            * [Ανάγνωση στοιχείων παίκτη](#ανάγνωση-στοιχείων-παίκτη)
            * [Καθορισμός στοιχείων παίκτη](#καθορισμός-στοιχείων-παίκτη)
         * [Status](#status)
            * [Ανάγνωση κατάστασης παιχνιδιού](#ανάγνωση-κατάστασης-παιχνιδιού)
      * [Entities](#entities)
         * [Board](#board-1)
         * [Players](#players)
         * [Game_status](#game_status)


# Demo Page

Μπορείτε να κατεβάσετε τοπικά ή να επισκευτείτε την σελίδα: 
https://users.iee.ihu.gr/~it154603/connect4



# Εγκατάσταση

## Απαιτήσεις

* Apache2
* Mysql Server
* php

## Οδηγίες Εγκατάστασης

 * Κάντε clone το project σε κάποιον φάκελο <br/>
  `$ git clone https://github.com/iee-ihu-gr-course1941/ADISE20_154603.git`

 * Βεβαιωθείτε ότι ο φάκελος είναι προσβάσιμος από τον Apache Server. πιθανόν να χρειαστεί να καθορίσετε τις παρακάτω ρυθμίσεις.

 * Θα πρέπει να δημιουργήσετε στην Mysql την βάση με όνομα 'adise19_chess5' και να φορτώσετε σε αυτήν την βάση τα δεδομένα από το αρχείο DB/schema5.sql

 * Θα πρέπει να φτιάξετε το αρχείο lib/config_local.php το οποίο να περιέχει:
```
    <?php
	$DB_PASS = 'κωδικός';
	$DB_USER = 'όνομα χρήστη';
    ?>
```

# Περιγραφή Παιχνιδιού

ο score4 παίζεται ως εξής: Παίζεται με 2 πάιχτες. Κάθε παίχτης διαλέγει ένα χρώμα και το τοποθετεί στον πίνακα(7 στήλες και 6 γραμμές συνήθως).

Οι κανόνες είναι οι: Σκοπός του παιχνιδιού είναι να σχηματιστεί μια 4αδα από το ίδιο χρώμα σε σειρά είτε κάθετα είτε οριζόντια είτε διαγώνια.

Η βάση μας κρατάει τους εξής πίνακες και στοιχεία: board, game_status, players

Η εφαρμογή απαπτύχθηκε μέχρι το τελικό της σημείο . Δηλαδή το παιχνίδι σταματάει όταν βρεθεί ένας νικητής έχοντας σχηματίσει μια 4άδα είτε οριζόντια είτε κάθετα έιτε διαγώνια.

Έχουν υλοποιηθεί από τα ζητούμενα τα εξής:

Αρχικοποίηση σύνδεσης-authentication (ακόμη και χωρίς password).
Έλεγχος κανόνων παιχνιδιού.
Αναγνώριση σειράς παιξιάς.
Αναγνώριση DeadLock (δεν υπάρχει κίνηση ή τέλος παιχνιδιού).
Υλοποίηση WebAPI.
Το APΙ πρέπει να χρησιμοποιεί json μορφή για τα δεδομένα.
Η κατάσταση του παιχνιδιού αποθηκεύεται πλήρως σε mysql.
Ο πρώτος παίκτης αρχικοποιεί το board και περιμένει αντίπαλο όπου χρειάζεται.
Bonus:

Έλεγχος timeout → ακύρωση παίκτη.
"Γραφική εμφάνιση"(GUI) του board.



# Περιγραφή API

## Methods


### Board
#### Ανάγνωση Board

```
GET /board/
```

Επιστρέφει το [Board](#Board).

#### Αρχικοποίηση Board
```
POST /board/reset
```

Αρχικοποιεί το Board, δηλαδή το παιχνίδι. Γίνονται reset τα πάντα σε σχέση με το παιχνίδι.
Επιστρέφει το [Board](#Board).



### Player

#### Ανάγνωση στοιχείων παίκτη
```
PUT /players/
```

Επιστρέφει τα στοιχεία του παίκτη p ή όλων των παικτών αν παραληφθεί. Το p μπορεί να είναι 'B' ή 'W'.

#### Εισαγωγή στοιχείων παίκτη στον πινακα Players
```
PUT /players/
```

#### Ανάγνωση στοιχείων παίκτη

```
GET /players/
```

Επιστρέφει τα στοιχεία του παίκτη ανάλογα με το χρώμα που στέλνονται στα data.


### Status

#### Ανάγνωση κατάστασης παιχνιδιού
```
GET /status/
```

Επιστρέφει το στοιχείο [Game_status](#Game_status).



## Entities


### Board
---------

Το board είναι ένας πίνακας, ο οποίος στο κάθε στοιχείο έχει τα παρακάτω:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `x`                      | H συντεταγμένη x του τετραγώνου              | 1..6                                |
| `y`                      | H συντεταγμένη y του τετραγώνου              | 1..7                                |
| `piece_color`            | To χρώμα του τετραγώνου                      | 'R','Y'                             |



### Players
---------

O κάθε παίκτης έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `username`               | Όνομα παίκτη                                 | String                              |
| `piece_color`            | To χρώμα που παίζει ο παίκτης                | 'R','Y'                             |
| `token  `                | To κρυφό token του παίκτη. Επιστρέφεται μόνο τη στιγμή της εισόδου του παίκτη στο παιχνίδι | HEX |
| `last_change`            | Η τελευταία ενέργεια του παίκτη			  | timestamp 						 	|

### Game_status
---------

H κατάσταση παιχνιδιού έχει τα παρακάτω στοιχεία:


| Attribute                | Description                                  | Values                              |
| ------------------------ | -------------------------------------------- | ----------------------------------- |
| `game_status  `          | Κατάσταση             | 'not active', 'initialized', 'started', 'ended', 'aborded'     |
| `p_turn`                 | To χρώμα του παίκτη που παίζει        | 'B','W',null                              |
| `result`                 |  To χρώμα του παίκτη που κέρδισε |'B','W',null                              |
| `last_change`            | Τελευταία αλλαγή/ενέργεια στην κατάσταση του παιχνιδιού         | timestamp |
