# Fake Store Web App Application

This project consists of a Laravel backend and a Vue.js frontend application that shows products from the Fake Store Api.

## Project Structure

```
fakestore-task/         # Laravel backend application root folder
├── frontend/         # Vue.js frontend application
├── database/         # Database migrations and seeders
├── config/           # Configuration files
├── routes/           # API routes
├── app/             # Backend application code
├── tests/           # Test files
└── vendor/          # Composer dependencies
```

## Frontend Structure

```
frontend/
├── src/                    # Source files
│   ├── assets/            # Static assets (images, styles, etc.)
│   ├── components/        # Reusable Vue components
│   ├── helpers/           # Helper functions and utilities
│   ├── router/            # Vue Router configuration
│   ├── stores/            # Pinia store modules
│   ├── views/             # Page components
│   ├── App.vue           # Root Vue component
│   └── main.ts           # Application entry point
├── public/                # Public static files
├── index.html            # HTML entry point
├── package.json          # NPM package configuration
├── tsconfig.json         # TypeScript configuration
├── vite.config.ts        # Vite configuration
└── README.md            # Frontend documentation
```

## Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/Mina-Nabil/fakestore-task.git
   cd fakestore-task
   ```

## Backend Setup

1. Navigate to the project root directory:
   ```bash
   cd fakestore-task
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Create a copy of the environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Configure your database in the `.env` file OR keep using 'sqlite':
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Start the backend server:
   ```bash
   php artisan serve
   ```

The backend API will be available at `http://localhost:8000`

## Frontend Setup

1. Navigate to the frontend directory:
   ```bash
   cd frontend
   ```

2. Install Node.js dependencies:
   ```bash
   npm install
   ```

3. Copy Environment File:
    ```bash
    cp .env.example .env
    ```

4. Start the development server:
   ```bash
   npm run dev
   ```

The frontend will be available at `http://localhost:5173`

## Available Commands

### Add User
To add a new user to the system:
```bash
php artisan app:create-user {username} {password}
```
This command will create a user for products update API.

### Sync Products
To synchronize products with the external Fake Store API:
```bash
php artisan app:sync-products
```
This command will fetch and update products from the external API.

## Development

- Frontend development server supports hot-reloading
- Backend uses Laravel's built-in development server

## Testing

Run backend tests:
```bash
php artisan test
```

Run frontend tests:
```bash
cd frontend
npm run test:unit
```
