# PMPML Online Bus Pass System - Setup Instructions

Welcome to the PMPML Online Bus Pass System! This is a complete PHP and MySQL web application designed for students and regular passengers.

## Prerequisites

1.  **XAMPP** (or any LAMP/WAMP server) installed.
2.  Basic knowledge of running a local server.

## Installation Steps

1.  **Move to XAMPP htdocs:**
    If you haven't already, move this entire project folder (`PMPML Online bus Pass`) into your XAMPP `htdocs` directory:
    `C:\xampp\htdocs\pmpml`

2.  **Database Setup:**
    *   Open your XAMPP Control Panel and start **Apache** and **MySQL**.
    *   Open your browser and navigate to `http://localhost/phpmyadmin/`.
    *   You don't need to manually create the database; the SQL script does it for you.
    *   Go to the **Import** tab in phpMyAdmin.
    *   Choose the file located at `database/pmpml_bus_pass.sql` inside this project folder.
    *   Click **Import** (or **Go**).
    *   This will create the `pmpml_bus_pass` database along with all the required tables and sample data.

3.  **Run the Project:**
    *   Open your browser and navigate to `http://localhost/pmpml/` (adjust the URL if you named the folder differently inside `htdocs`).
    *   The website should now be live!

## Features Included

*   **Responsive Homepage:** Information about PMPML, bus routes, gallery, and helpline.
*   **Student Flow:**
    *   Registration with age validation (15-25 years).
    *   Login and Dashboard.
    *   Bus pass application with file uploads (Bonafide, Aadhaar, Photo, Light Bill, Fees Receipt).
    *   Dynamic fee calculation based on duration (1, 3, 6, 12 months).
    *   Printable Application Receipt.
*   **Passenger Flow:**
    *   Registration with age validation (26-60 years).
    *   Login and Dashboard.
    *   Bus pass application with file uploads (Aadhaar, Photo).
    *   Printable Application Receipt.
*   **Database:** Fully structured relational MySQL schema.
*   **Security:** Password hashing, prepared statements for SQL injection prevention.

## Admin Features

Currently, the statuses are updated manually in the database. To approve a pass:
1. Open `phpmyadmin`.
2. Go to `pmpml_bus_pass` -> `student_applications` or `passenger_applications`.
3. Edit an application and change its `status` column from `Pending` to `Approved` or `Under Review`.
4. The user will see this updated status in their dashboard.

## File Uploads Note
All uploaded documents and photos are saved locally in the `uploads/students/` and `uploads/passengers/` directories. Ensure these directories have write permissions if hosted on a live Linux server.
