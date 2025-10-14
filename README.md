# 🚗 Škoda Rental

**Škoda Rental** je full-stack PHP aplikacija za online iznajmljivanje automobila.  
Izgrađena korišćenjem **OOP PHP-a**, **MVC arhitekture** i **AJAX komunikacije**, aplikacija omogućava korisnicima da pregledaju automobile, rezervišu ih i ostavljaju recenzije, dok administratori upravljaju celokupnim sadržajem i rezervacijama putem odvojenog panela.

🔗 Live demo: https://gacho-dev.rs/skoda-rental

📄 Documentation and Database:
📘 Full Project Documentation (PDF) - https://github.com/MarkoG111/skoda_rental/blob/master/Dokument.pdf
🗄️ Database SQL File - https://github.com/MarkoG111/skoda_rental/blob/master/skoda_rent.sql

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)	
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)	
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)	
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com/)
[![jQuery](https://img.shields.io/badge/jQuery-AJAX-blue.svg?style=for-the-badge&logo=jquery)](https://jquery.com/)
[![MVC](https://img.shields.io/badge/Architecture-MVC-success.svg?style=for-the-badge&logo=codeigniter)]()

🎯 Projektovan kao *real-world edukativni projekat*, s fokusom na čistu arhitekturu, višeslojni dizajn i sigurne SQL operacije.

---


## ✨ Funkcionalnosti

### 👥 Korisnici
- Registracija i prijava sa server-side i client-side validacijom  
- Pregled automobila sa filtriranjem po ceni, kategoriji, gorivu i menjaču  
- Sortiranje i pretraga po ključnim rečima  
- Rezervacija automobila sa proverom dostupnosti  
- Pregled i otkazivanje sopstvenih rezervacija  
- Pregled istorije recenzija i dodavanje novih (samo za iznajmljena vozila)  

### 🧑‍💼 Administrator
- CRUD operacije nad automobilima, slikama i karakteristikama  
- Upravljanje korisničkim rezervacijama (potvrda / otkazivanje)  
- Kontrola recenzija (odobravanje, brisanje, skrivanje)  
- Pregled statistike poseta i aktivnosti  
- Izvoz podataka o vozilima u **Excel (.xlsx)**  
- AJAX upravljanje bez reload-a stranice  

---


## 🧱 Tehnologije

| Sloj | Tehnologije |
|------|--------------|
| **Frontend** | HTML5, CSS3, Bootstrap, jQuery, AJAX |
| **Backend** | PHP 8+ (OOP, MVC, PDO), JSON |
| **Baza podataka** | MySQL (phpMyAdmin) |
| **Dodatno** | PHPMailer, File Logging, Image Resize (GD Library), Excel export |
| **Razvojno okruženje** | Visual Studio Code, XAMPP |

---
## 🧠 Arhitektura sistema

Aplikacija koristi **MVC (Model–View–Controller)** obrazac, razdvajajući logiku aplikacije na tri sloja:
┌───────────────────────────────────────────────────────────────┐

│ View (UI) │ <br/>
│ HTML + Bootstrap + jQuery + AJAX │ <br/>
│ Prikazuje podatke korisniku i prosleđuje akcije Controlleru │
└───────────────────────────────────────────────────────────────┘
<br/>
│
<br/>
▼
<br/>
┌───────────────────────────────────────────────────────────────┐
 
│ Controller (Logika) │ <br/>
│ Obrada korisničkih zahteva, validacija, poziv Modela │ <br/>
│ i prosleđivanje rezultata View sloju │
└───────────────────────────────────────────────────────────────┘
<br/>
│
<br/>
▼
<br/>
┌───────────────────────────────────────────────────────────────┐

│ Model (Podaci) │ <br/>
│ Komunikacija sa bazom putem PDO konekcije │ <br/>
│ CRUD operacije, SQL upiti, transformacija podataka │
└───────────────────────────────────────────────────────────────┘

➡ **Front Controller** (`index.php`) prepoznaje zahtev preko `$_GET['page']` i prosleđuje ga odgovarajućem kontroleru.  
➡ **Autoloading** je implementiran u `setup.php`, bez ručnih `require` poziva.  
➡ **Logovanje grešaka i pristupa** se vrši kroz `logError()` i `logAccess()` funkcije.  
➡ **Validacija i obrada slika** se obavljaju centralizovano (resize + thumbnail kreiranje).

---


## 🧩 Glavni modeli

### 🚘 Car Model
- Unos, ažuriranje, brisanje automobila  
- Dinamičko filtriranje po kategoriji, gorivu, transmisiji i ceni  
- Paginacija i pretraga sa AJAX-om  
- Prikaz detalja o vozilu (slike, oprema, recenzije)

### 📦 Booking Model
- Slanje zahteva za rezervaciju  
- Validacija datuma (budući termini)  
- Provera dostupnosti istog automobila  
- Status rezervacija: *pending*, *confirmed*, *canceled*  
- Otkazivanje rezervacije (user/admin)

### 💬 Review Model
- Korisnici mogu ostaviti recenziju samo za iznajmljena vozila  
- Administrator odobrava ili odbija recenzije  
- CRUD funkcionalnost sa dinamičkim osvježavanjem (AJAX)

### 🖼️ Image Model
- Upload više slika za svako vozilo  
- Automatsko generisanje *thumbnail* verzije  
- Brisanje i dodavanje novih slika tokom izmene vozila  

---

## 🛡️ Bezbednost i validacija
- **Prepared statements (PDO)** — zaštita od SQL injectiona  
- **Server-side validacija** u svim formama  
- **Client-side validacija** pomoću regex izraza  
- **Error log fajlovi**: `errors.txt`, `access.txt`  
- **Kontrola pristupa** (admin/user razdvojeno po sesiji)  
- **Session management** kroz `session_start()` i `writeUserInFile()` funkcije  
---

## 🧰 Instalacija i konfiguracija
1. Kloniraj repozitorijum  
   ```bash
   git clone https://github.com/<username>/skoda-rent.git
2. Kreiraj MySQL bazu i importuj database.sql
3. U app/config/config.php postavi svoje DB kredencijale:
``php
define("SERVER", "localhost");
define("DATABASE", "skoda_rent");
define("USERNAME", "root");
define("PASSWORD", "");
``

4. Pokreni projekat kroz XAMPP (http://localhost/skoda_rental)
5. Uloguj se u admin panel koristeći test nalog:
email: testadmin@gmail.com
password: Gacanovic121
---

## 🖼️ Preview sekcija

