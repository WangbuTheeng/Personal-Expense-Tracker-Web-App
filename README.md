# Personal Expense Tracker

A web application for tracking personal expenses with budgeting and categorization features built with Laravel and Tailwind CSS.

## Features

- **User Authentication**: Secure login and registration
- **Expense Management**: Track, categorize, and manage your expenses
- **Categories**: Create custom categories with colors and icons
- **Budget Goals**: Set and monitor budget goals with progress tracking
- **Currency Support**: Uses Nepali Rupees (NRs) for all monetary values
- **Dark/Light Mode**: Toggle between dark and light mode

## Modules Completed

- [x] Setup & Authentication Module
- [x] Expense Management Module
- [x] Categories Module
- [x] Budget Goals Module

## Setup Instructions

### Requirements

- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & NPM

### Installation

1. Clone the repository:
```bash
git clone https://github.com/WangbuTheeng/Personal-Expense-Tracker-Web-App.git
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create .env file and generate app key:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Compile assets:
```bash
npm run dev
```

8. Start the development server:
```bash
php artisan serve
```

9. Visit `http://localhost:8000` in your browser.

## Screenshots

*Coming soon*

## Technologies Used

- **Laravel**: Backend PHP framework
- **Tailwind CSS**: Frontend styling
- **Alpine.js**: JavaScript functionality
- **MySQL**: Database

## License

MIT
