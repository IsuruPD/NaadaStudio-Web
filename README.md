# Music Studio Reservation System

This project is a **Music Studio Reservation System**, designed to facilitate both **customers** and **staff** of a music studio. Customers can browse, search, filter, and purchase musical instruments online. Additionally, they can make reservations for studio equipment or hire instruments as needed. 

For the studio staff, the system provides a management panel to handle customer reservations, instrument hires, inventory management, staff records, and accounts. It also implements role-based access control, ensuring that different levels of users have appropriate access to the system's features.

## Features

### Customer Features:
- **Studio Reservation**: Book the music studio for sessions based on availability.
- **Browse Instruments**: View a wide range of musical instruments available for purchase or hire.
- **Search and Filter**: Search for specific instruments or filter by category, brand, or price.
- **Instrument Hire**: Hire instruments online for specific periods.
- **Online Purchases**: Purchase instruments and pay securely online.

### Staff Features:
- **Reservation Management**: View and manage placed reservations and hired instruments.
- **Inventory Management**: Add, update, and manage instrument records, track stock levels.
- **Staff Management**: Manage staff details and assign roles.
- **Accounts Management**: Manage billing, invoices, and other financial operations.
- **Role-Based Access Control (RBAC)**: Staff access is managed based on their role, ensuring that only authorized personnel can perform certain actions.

---

## Installation Guide

### Step 1: Setting up a local server
You will need to install a local server environment to run the project. You can use **WAMP** (for Windows) or **XAMPP** (for cross-platform).

1. Download and install [XAMPP](https://www.apachefriends.org/index.html) or [WAMP](http://www.wampserver.com/en/).
2. Once installed, start the Apache and MySQL modules from the control panel.

### Step 2: Clone the GitHub Repository
Clone the repository from GitHub to your local machine.

1. Open your terminal/command prompt and navigate to the folder where your web server stores files
   - For **XAMPP**, this would be `../xampp/htdocs/`
   - For **WAMP**, this would be `../wamp64/www/`

2. Run the commands to clone the repository

### Step 3: Configure the Database
1. Open the MySQL admin panel (eg:- **phpMyAdmin**).
2. Create a new database for the project. You can name it `musicstudio_db`.
3. Import the SQL structure from the `sql/` folder. To do this:
   - Open **phpMyAdmin**.
   - Select the database you created.
   - Click on the **Import** tab and upload the `.sql` file from the `sql/` folder (e.g., `musicstudio.sql`).
   
### Step 4: Configure Database Connection
1. Go to the `includes/` folder in the project directory.
2. Open the `db.php` file.
3. Update the following lines with your database information:
    ```php
    $servername = "localhost";
    $username = "";               // Change if necessary
    $password = "";               // Add your MySQL password
    $dbname = "musicstudio_db";   // Make sure this matches your database name
    ```

### Step 5: Run the Project
1. Open your web browser.
2. Go to `http://localhost/musicstudio/index.php` (or the folder name you assigned).
3. You should now see the landing page for the Music Studio Reservation System!

## Technologies Used
- **Front-End**: HTML, CSS, JavaScript, Bootstrap
- **Back-End**: PHP
- **Database**: MySQL
