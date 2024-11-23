# Documentazione Savona Triathlon - Test

## **Guida all'Installazione**

### **1. Clonazione del Repository**

Eseguire il seguente comando per clonare il repository:

```bash
git clone https://github.com/als698/savona-triathlon.git
```

---

### **2. Installazione delle Dipendenze**

Utilizzare Composer per installare tutte le dipendenze necessarie:

```bash
composer install
```

---

### **3. Configurazione del File `.env`**

Modificare il file `.env` per configurare le impostazioni dell'applicazione. Un esempio di configurazione minima:

```env
APP_URL=http://localhost:8000
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
```

---

### **4. Inizializzazione del Database**

Eseguire il seguente script per configurare il database:

```bash
php database/init.php
```

---

### **5. Creazione di un Utente Amministratore**

Eseguire lo script per creare un account amministratore:

```bash
php scripts/create_admin.php
```

Accedere al pannello amministrativo utilizzando le seguenti credenziali predefinite:

- **Email**: `test@test.com`
- **Password**: `test2024`

---

## **Documentazione API**

### **Tabella degli Endpoint**

| **Metodo** | **Endpoint**              | **Descrizione**                                        |
| ---------- | ------------------------- | ------------------------------------------------------ |
| GET        | `/`                       | Visualizza la homepage.                                |
| GET        | `/form`                   | Mostra il modulo di registrazione.                     |
| POST       | `/form`                   | Invia i dati di registrazione.                         |
| GET        | `/payment/{id}/{token}`   | Mostra la pagina di pagamento.                         |
| POST       | `/payment/create-session` | Crea una sessione di pagamento su Stripe.              |
| GET        | `/payment/success`        | Conferma il completamento del pagamento.               |
| GET        | `/payment/cancel`         | Visualizza il messaggio di annullamento del pagamento. |
| GET        | `/admin/login`            | Mostra la pagina di login per gli amministratori.      |
| POST       | `/admin/login`            | Esegue l'autenticazione dell'amministratore.           |
| GET        | `/admin/registrations`    | Mostra la lista delle iscrizioni.                      |
| GET        | `/admin/logout`           | Esegue il logout.                                      |

---

## **Strumenti e Sicurezza**

### **Formattazione del Codice**

Per formattare il codice secondo gli standard di Laravel Pint:

```bash
composer format
```

---

### **Misure di Sicurezza Implementate**

- **Protezione CSRF** su tutti i form.
- **Validazione degli input** per prevenire dati non validi o malevoli.
- **Gestione sicura delle sessioni** per proteggere le informazioni degli utenti.
- **Sanitizzazione dei dati** prima del loro utilizzo.

---

## **Requisiti di Sistema**

Per eseguire l'applicazione, assicurarsi che il sistema soddisfi i seguenti requisiti:

- **PHP**: Versione >= 7.4
- **Database**: SQLite3
- **Gestore di dipendenze**: Composer
- **Estensioni PHP necessarie**:
  - PDO SQLite
  - JSON
  - mbstring
  - curl

---
