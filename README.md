# 🚗 Škoda Rental

Škoda Rental is a full-stack PHP application for online car rentals.
Built using **OOP PHP**, **MVC architecture**, and **AJAX communication**, the application allows users to browse cars, make reservations, and leave reviews, while administrators manage all content and bookings through a separate panel.

🔗 Live demo: https://skoda-rental.infinityfree.me/

- 📘 Project Documentation (PDF): https://github.com/MarkoG111/skoda_rental/blob/master/Dokument.pdf
- 🗄️ Database SQL File: https://github.com/MarkoG111/skoda_rental/blob/master/skoda_rent.sql

👨‍💻 Admin login: <br/>
Email: testadmin@gmail.com <br/>
Password: Gacanovic121

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)	
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)	
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)	
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com/)
[![jQuery](https://img.shields.io/badge/jQuery-AJAX-blue.svg?style=for-the-badge&logo=jquery)](https://jquery.com/)
[![MVC](https://img.shields.io/badge/Architecture-MVC-success.svg?style=for-the-badge&logo=codeigniter)]()

🎯 Designed as a real-world educational project, focusing on clean architecture, multi-layered design, and secure SQL operations.

---


## ✨ Features

### 👥 Users
- Registration and login with server-side and client-side validation 
- Browsing cars with filtering by price, category, fuel type, and transmission  
- Sorting and searching by keywords  
- Car reservation with availability checking  
- Viewing and canceling own reservations  
- Viewing review history and adding new reviews (only for rented vehicles)  

### 🧑‍💼 Administrator
- CRUD operations for cars, images, and specifications  
- Managing user reservations (confirmation/cancellation)  
- Review management (approving, deleting, hiding)  
- Viewing visit and activity statistics  
- Exporting vehicle data to Excel (.xlsx) 
- AJAX-based management without page reloads

---


## 🧱 Technologies

| Layer | Technologies |
|------|--------------|
| **Frontend** | HTML5, CSS3, Bootstrap, jQuery, AJAX |
| **Backend** | PHP 8+ (OOP, MVC, PDO), JSON |
| **Database** | MySQL (phpMyAdmin) |
| **Additional** | PHPMailer, File Logging, Image Resize (GD Library), Excel export |
| **Development Environment** | Visual Studio Code, XAMPP |

---
## 🧠 System Architecture

The application uses the **MVC (Model–View–Controller)** pattern, separating application logic into three layers:
┌───────────────────────────────────────────────────────────────┐

│ View (UI) │ <br/>
│ HTML + Bootstrap + jQuery + AJAX │ <br/>
│ Displays data to the user and passes actions to the Controller │
└───────────────────────────────────────────────────────────────┘
<br/>
│
<br/>
▼
<br/>
┌───────────────────────────────────────────────────────────────┐
 
│ Controller (Logic) │ <br/>
│ Processes user requests, validation, calls the Model, │ <br/>
│ and passes results to the View layer │
└───────────────────────────────────────────────────────────────┘
<br/>
│
<br/>
▼
<br/>
┌───────────────────────────────────────────────────────────────┐

│ Model (Data) │ <br/>
│ Communicates with the database via PDO connection │ <br/>
│ CRUD operations, SQL queries, data transformation │
└───────────────────────────────────────────────────────────────┘

- **Front Controller** (`index.php`) recognizes requests via $_GET['page'] and forwards them to the appropriate controller.
- **Autoloading** is implemented in setup.php, eliminating manual require calls.
- **Logging erros and access** is handled through logError() and logAccess() functions. 
- **Validation and image processing** are centralized (resize + thumbnail creation).

---


## 🧩 Main Models

### 🚘 Car Model
- Adding, updating, deleting cars
- Dynamic filtering by category, fuel, transmission, and price
- Pagination and search with AJAX
- Displaying vehicle details (images, equipment, reviews)

### 📦 Booking Model
- Sending reservation requests
- Date validation (future dates only)
- Checking availability for the same car
- Reservation statuses: pending, confirmed, canceled
- Reservation cancellation (user/admin)

### 💬 Review Model
- Users can leave reviews only for rented vehicles
- Administrators approve or reject reviews
- CRUD functionality with dynamic refresh (AJAX)

### 🖼️ Image Model
- Uploading multiple images for each vehicle
- Automatic generation of thumbnail versions
- Deleting and adding new images during vehicle edits

--- 

## 🛡️ Security and Validation
- Prepared statements (PDO) - protection against SQL injection
- Server-side validation in all forms
- Client-side validation using regex expressions
- Error log files: errors.txt, access.txt
- Access control (admin/user separated by session)
- Session management via session_start() and writeUserInFile() functions

---

## 🧰 Installation and Configuration
1. Clone the repository:  
   ```bash
   git clone https://github.com/skoda_rental.git
2. Create a MySQL database and import database.sql
3. In app/Config/config.php set your DB credentials:
```php
define("SERVER", "localhost");
define("DATABASE", "skoda_rent");
define("USERNAME", "root");
define("PASSWORD", "");
```

4. Run the project through XAMPP (http://localhost/skoda_rental)
---
