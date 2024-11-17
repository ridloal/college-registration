<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prerequisites

Make sure the following software is installed on your machine:

- **PHP** (>= 8.1 recommended)
- **Composer** (latest version)
- **Node.js** and **npm** (latest LTS version)
- **Database server** (e.g., MySQL, PostgreSQL, etc.)
- **Git** (for cloning the repository)

## How To Install and Run

### 1. Clone the Repository
Clone this repository to your local machine using Git. Replace `<repository_url>` with the actual URL of this repository.

    git clone [repository_url]
    cd [repository_name]


### 2. Install Dependencies
Run the following command to install PHP and Laravel dependencies using Composer:

    composer install

### 3. Install Frontend Dependencies
Install the required Node.js dependencies for Tailwind CSS and Vite:

    npm install

### 4. Set Up the Environment File
Copy the `.env.example` file and rename it to `.env`:

    cp .env.example .env

Then, update the .env file with your local environment settings (e.g., database configuration).

### 5. Generate Application Key
Generate the application key using the Artisan command:

    php artisan key:generate

### 6. Run Database Migrations and Seeders
Run the following commands to create the database structure and seed the initial data:

    php artisan migrate --seed

### 7. Start the Development Server
Run the following commands in separate terminal windows:
 
#### - Start the Laravel development server:
    php artisan serve
#### - Start Vite to compile assets (CSS/JS):
    npm run dev

### 8. Access the Application
Open your browser and visit http://127.0.0.1:8000 to view the application.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).