# Job Board Platform

A simple and scalable Job Board web application designed to help users find local job opportunities — especially those jobs that normally don't get posted on big platforms.

## 🚀 Overview

This project is a web-based platform where employers can post job listings and job seekers can browse and apply. It focuses on **local, community-level jobs** such as retail assistants, cleaners, general workers, and entry-level roles.

The system is built using a standard web stack (HTML, CSS, JavaScript, PHP, MySQL) and is structured to be easy to maintain and extend.

---

## ✨ Features

* 📝 **Employer Registration & Login**
* 👤 **Job Seeker Registration & Login**
* 📢 **Post Job Listings** (employers)
* 🔍 **Browse Available Jobs** (job seekers)
* 📄 **View Job Details**
* 📥 **Apply for Jobs** (contact the employer)
* 📂 **User Dashboard** (employers manage posts)
* 🔐 **Session-based Authentication**
* 🎨 **Responsive UI**

---

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP 
* **Database:** MySQL
* **Server:** Local server (PHPStorm built-in server / XAMPP / WAMP)

---

## 📁 Project Structure

```
project-root/
│
├── employer/  
│   ├── add.css
│   ├── add.php
│   ├── dash.css
│   ├── dashboard.php
│   ├── edit.css
│   ├── edit.php 
│
│
├── Register.php
├── Search.php
├── Style.css
├── about.php
├── config.php
├── index.php
├── login.csd
├── login.php
├── logout.php
├── register.csd
└── README.md
```

---

## ⚙️ Installation & Setup

1. **Clone the repository:**

```
git clone <https://github.com/hlayiseko01/Job_Board>
```

2. **Import the database:**

   * Create a database in MySQL
   * Import the `database.sql` file

3. **Update database credentials:**
   Edit `includes/db.php` and update:

```
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "job_oard";
```

4. **Run the project:**

   * Using PHPStorm built-in server
   * Or run:

```
php -S localhost:8000
```

---

## 🧪 How It Works

### Authentication

* Users log in using email + password
* Sessions are used to maintain login state
* Employers get redirected to `employer/dashboard.php`
* Job seekers get redirected to their respective home page

### Posting Jobs

Employers fill out a form with:

* Job title
* Job description
* Location
* Salary (optional)
* Requirements

### Browsing Jobs

Job seekers can:

* View all available jobs
* Filter by location 
* Open job details page

---

## 📄 License

This project is open-source and free to use.

---

## 💬 Contact

Feel free to reach out if you'd like help or want to collaborate!
