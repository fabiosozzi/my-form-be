# My Form BE

Un Backend sviluppato in Laravel per gestire le iscrizioni ad un form. 

## Istruzioni

Dopo aver clonato il repository, copiare il file **.env.example** e rinominarlo **.env**.
Cambiare le impostazioni del DB con i dati della propria istanza di MySQL, **l'APP_URL** del sito e la variabile di environment **EXPORT_CSV_RECIPIENT** per impostare il destinatario della mail di esportazione del CSV.
Qualora si volesse cambiare la chiave segreta che permette la comunicazione tra BE e FE, cambiare la variabile di environment **API_SECRET_KEY** sia in FE che in BE.
A questo punto lanciare i comandi bash

```bash
    
    composer install
    npm install

    php artisan key:generate
    php artisan migrate:fresh --seed
    php artisan optimize
```

Per verificare che tutto sia correttamente installato avviare i test con

```bash
    php artisan test
```

Se non ci sono problemi avviare l'ambiente di sviluppo e l'elaborazione della coda con i comandi:

```bash
    npm run dev
    php artisan queue:work
```

Andando all'indirizzo impostato nell'APP_URL (ad esempio http://my-form-be.test) si può accedere con uno dei due utenti di default:

<ins>**Super Admin**</ins> (può modificare e cancellare gli utenti)
username: **super-admin@example.it**
password: **password**

<ins>**Admin**</ins> (può solo visualizzare gli utenti)
username: **admin@example.it**
password: **password**



