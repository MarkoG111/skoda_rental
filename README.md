# 🚗 Škoda Rent-a-Car Management System

A full-stack web application for managing car rentals, built with a custom PHP MVC framework, focusing on clean architecture, modular design, and real-world business logic.

This system enables users to browse and book vehicles, while administrators manage fleet operations, reservations, and platform content through a dynamic dashboard.

🔗 **Live Demo:** [skoda-rental.infinityfree.me](https://skoda-rental.infinityfree.me/) <br/>
📄 **Documentation (PDF):** [Dokument.pdf](https://github.com/MarkoG111/skoda_rental/blob/master/Dokument.pdf) <br/>
🗄️ **Database Schema:** [skoda_rent.sql](https://github.com/MarkoG111/skoda_rental/blob/master/skoda_rent.sql)

---

## 📑 Table of Contents

- [Demo Credentials](#-demo-credentials)
- [Key Features](#-key-features)
- [Architecture](#-architecture)
- [Request Flow](#-request-flow)
- [MVC Breakdown](#-mvc-breakdown)
- [OOP Principles](#-oop-principles)
- [Design Patterns](#-design-patterns)
- [Tech Stack](#-tech-stack)
- [Core Modules](#-core-modules)
- [Security & Validation](#%EF%B8%8F-security--validation)
- [Installation](#%EF%B8%8F-installation)
- [Project Highlights](#-project-highlights)

---

## 🔐 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | testadmin@gmail.com | Gacanovic121 |
| User | user@gmail.com | user123 |

---

## ✨ Key Features

### 👤 Users
- Advanced filtering (price, fuel type, transmission, category)
- Keyword-based search with AJAX updates
- Booking system with date validation and availability checks
- Reservation tracking (Pending, Approved, Canceled)
- Review system restricted to previously rented vehicles
- Vehicle galleries with auto-generated thumbnails

### 🧑‍💼 Administrator
- Full CRUD for cars, specifications, and images
- Reservation approval and conflict handling
- Review moderation system
- Activity tracking (visitors and active users)
- Excel export functionality
- AJAX-based dashboard without page reloads

---

## 🧠 Architecture

The application is built using a custom MVC architecture, designed to separate responsibilities, reduce coupling, and make the system easier to extend and maintain.

> Instead of relying on frameworks like Laravel, the architecture is implemented manually to demonstrate understanding of core backend concepts.

---

## 🔁 Request Flow

1. All incoming requests are routed through a **Front Controller** (`index.php`)
2. Routing is handled via query parameters (`$_GET['page']`)
3. The appropriate **Controller** is instantiated
4. The controller processes input and calls the **Model**
5. The model interacts with the database via **PDO**
6. The response is returned:
   - HTML via **View** rendering
   - JSON for **AJAX** requests

---

## 🧩 MVC Breakdown

### 📦 Model - Data Layer

Responsible for all data-related logic and database communication.

- Uses PDO with prepared statements
- Handles complex queries (JOINs, filtering, pagination)
- Encapsulates business rules (e.g., booking availability)

> **Example:** Car model handles filtering, search, and retrieval of related data (images, features, pricing)

### 🎨 View - Presentation Layer

Responsible for rendering UI.

- PHP templates (e.g., `carDetails.php`)
- Minimal logic inside views
- Receives structured data from controllers
- Works with AJAX for partial updates

### 🧠 Controller - Application Logic

Acts as the intermediary between user input and system behavior.

- Handles HTTP requests (GET, POST, AJAX)
- Validates input
- Calls appropriate model methods
- Returns views or JSON responses

---

## 🧬 OOP Principles

### Encapsulation
Each domain concept is represented as a class (e.g., `Car`, `Booking`, `Review`, `Image`).
- Internal state is protected via private properties
- Access is controlled via public methods

### Inheritance
Controllers extend a shared `BaseController`.
- Reuses logic for rendering views
- Standardized response handling
- Reduces duplication

### Dependency Injection
Database connection is injected into models.
- Improves modularity
- Enables easier testing
- Reduces tight coupling between components

---

## 🧠 Design Patterns

### Front Controller
All requests pass through a single entry point (`index.php`), centralizing routing and control flow.

### Singleton (Database)
Database connection is implemented as a Singleton.
- Ensures only one connection instance
- Reduces unnecessary resource usage

### Layered Architecture
Clear separation between:
- **Presentation** (View)
- **Logic** (Controller)
- **Data** (Model)

### Centralized Logging
Custom logging system:
- `logError()` → tracks system errors
- `logAccess()` → tracks user activity

> Adds observability often missing in smaller projects.

---

## 🧱 Tech Stack

| Layer | Technologies |
|-------|-------------|
| Backend | PHP 8 (OOP, MVC), PDO |
| Frontend | JavaScript (ES6), jQuery, AJAX, Bootstrap |
| Database | MySQL |
| Utilities | GD Library, Excel export, File logging |

---

## 🧩 Core Modules

### 🚘 Car Module
- Filtering, search, pagination
- Dynamic loading via AJAX
- Detailed car pages

### 📦 Booking Module
- Reservation requests
- Date validation
- Conflict prevention
- Status lifecycle management

### 💬 Review Module
- Review allowed only after rental
- Admin approval system
- AJAX updates

### 🖼️ Image Module
- Multi-image upload
- Thumbnail generation
- Image management on edit

---

## 🛡️ Security & Validation

- PDO prepared statements → SQL injection protection
- Server-side validation on all forms
- Client-side validation (regex)
- Session-based authentication
- Role separation (admin / user)
- Logging (errors + access)

> ⚠️ **Note:** Password hashing currently uses MD5 and should be replaced with `password_hash()` for production use.

---

## ⚙️ Installation

**1. Clone the repository**
```bash
git clone https://github.com/MarkoG111/skoda_rental.git
```

**2. Import the database**
```bash
# Import skoda_rent.sql into your MySQL server
```

**3. Configure database connection**
```php
define("SERVER",   "localhost");
define("DATABASE", "skoda_rent");
define("USERNAME", "root");
define("PASSWORD", "");
```

**4. Run the application**
```
http://localhost/skoda_rental
```

---

## 🎯 Project Highlights

- ⚡ Custom-built MVC framework, no external backend frameworks
- 📅 Real-world booking logic with validation and conflict handling
- 🔄 AJAX-driven UI for improved UX
- 🏗️ Clean separation of concerns
- 📋 Logging and monitoring system

> This project is intended as a portfolio-grade system demonstrating understanding of backend architecture, ability to design scalable systems from scratch, handling of real-world edge cases, and full-stack development skills.
