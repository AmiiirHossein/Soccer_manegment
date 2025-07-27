#  Soccer Management System

A Laravel-based Football League Management System for managing fixtures, results, and live standings with real-time updates.

## Features

- Create and manage leagues and teams
- Generate and update match fixtures
- Enter match results
- Automatically update standings based on results
- Real-time updates using WebSocket (coming soon)
- RESTful API for all operations
- Built with clean architecture using Service, Repository, and DTO patterns (in progress)

##  Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **Real-time**: Laravel WebSockets, Redis *(planned)*
- **API Auth**: Laravel Sanctum
- **Frontend**: Blade + TailwindCSS *(optional)*
- **Testing**: PHPUnit, Laravel Feature Tests
- **Architecture**: Service + Repository + DTO (refactoring ongoing)

##  Installation

1. **Clone the repo**

```bash
git clone https://github.com/AmiiirHossein/Soccer_management.git
cd Soccer_management
```

2. **Install dependencies**

```bash
composer install
npm install && npm run dev
```

3. **Set up environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**

Edit your `.env` file:

```
DB_DATABASE=soccer_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Run migrations**

```bash
php artisan migrate --seed
```

6. **Serve the app**

```bash
php artisan serve
```

## 📡API Endpoints

Example endpoints:

| Method | Endpoint                        | Description                    |
|--------|----------------------------------|--------------------------------|
| GET    | `/api/leagues`                  | List all leagues               |
| POST   | `/api/leagues`                  | Create a new league            |
| POST   | `/api/fixtures/{id}/result`     | Submit match result            |
| GET    | `/api/leagues/{id}/standings`   | Get current standings          |

*More routes can be found in `routes/api.php`.*

##  Project Structure

```
app/
├── Models/
├── Services/           # Business logic layer
├── Repositories/       # Data access layer
├── DTOs/               # Data Transfer Objects
├── Http/
│   ├── Controllers/
│   ├── Requests/
routes/
├── api.php
database/
├── migrations/
```

## 🧪 Testing

```bash
php artisan test
```

## 📝 License

This project is open-sourced under the MIT license.
