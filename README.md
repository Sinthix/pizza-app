# Pizza APP

This is a web application built using **Laravel** (backend) and **Vue.js** (frontend). Below are the steps to set up and run the project locally.

## Prerequisites

Before you begin, ensure you have the following installed:

-   **PHP** (version 8.0 or higher)
-   **Composer** (for PHP dependency management)
-   **Node.js** (for frontend dependencies)
-   **NPM** (Node Package Manager)
-   **MySQL** (or another database you use)
-   **Git** (to clone the repository)

## Setup Instructions

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository

```bash
git clone https://github.com/Sinthix/pizza-app

```

### 2. Install Backend Dependencies

Navigate to the project directory:

cd pizza-app

Install the PHP dependencies using Composer:

composer install

### 3. Set Up Environment File

Copy the .env.example file to create your own .env file:

cp .env.example .env

Update your .env file with your database credentials and any other necessary environment variables.

### 4. Generate Application Key

Generate the application key:

php artisan key:generate

### 5. Run Database Migrations & Seed Data

Run the database migrations to create the necessary tables:

php artisan migrate

(Optional) If you need sample data, run the database seeders:

php artisan db:seed

### 6. Install Frontend Dependencies

Navigate to the frontend folder:

cd frontend

Install the frontend dependencies using npm:

npm install

### 7. Run Frontend Development Server

After the dependencies are installed, run the development server:

npm run dev

This will compile your frontend assets and start a development server for the frontend.

### 8. Serve the Laravel Application

Go back to the main project folder and start the Laravel server:

cd ..
php artisan serve

### 9. Register user

Go to the browser and navigate to /register if not already then and create a user

Then go to login and use your created credentials

Have fun!
