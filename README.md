# birdvision-cms
bird vision cms interview assignment

# CMS Installation Guide

## Laravel 10 with PostgreSQL 16

### 1. Clone the Repository
Clone the public repository:

```bash
git clone https://github.com/brajdhan/birdvision-cms.git
cd birdvision-cms
```

---

### 2. Install Dependencies

- **Composer**: Install PHP dependencies.
  ```bash
  composer install
  ```
- **Node.js**: Install JavaScript dependencies.
  ```bash
  npm install
  ```

---

### 3. Configure the Database

1. **Create a PostgreSQL database**.
2. **Update the `.env` file**:
   - Copy the example `.env` file:
     ```bash
     cp .env.example .env
     ```
   - Generate the application key:
     ```bash
     php artisan key:generate
     ```
   - Set your database configuration in `.env`:
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=your_database_name
     DB_USERNAME=postgres
     DB_PASSWORD=your_password
     ```

---

### 4. Configure Other Environment Variables

- **Queue Configuration**: Choose one:
  ```env
  QUEUE_CONNECTION=database
  # OR
  QUEUE_CONNECTION=sync
  ```
- **Email Notifications**: Set up SMTP mailer:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=465
  MAIL_USERNAME=your_email@gmail.com
  MAIL_PASSWORD=your_email_password
  MAIL_ENCRYPTION=ssl
  MAIL_FROM_ADDRESS=your_email@gmail.com
  MAIL_FROM_NAME="${APP_NAME}"
  ```
- **Scout Driver**: Set the search driver for filters:
  ```env
  SCOUT_DRIVER=database
  ```

---

### 5. Migrate and Seed the Database
Run the following command to set up the database schema and seed initial data:
```bash
php artisan migrate --seed
```

---

### 6. Run the Project

- Start the development server:
  ```bash
  php artisan serve
  npm run dev
  ```
- If using a database queue connection, start the queue worker:
  ```bash
  php artisan queue:work
  ```

---

### 7. Login Credentials

#### Admin User:
- **Email**: `admin@bird.com`
- **Password**: `password`

#### Sales Manager User:
- **Email**: `salemanager@bird.com`
- **Password**: `password`

---

## API Endpoints

1. **Login**: Authentication API.
2. **Get Customers List**: Fetch all customers.
3. **Get Sales List**: Fetch all sales, including customer details.
4. **Logout**: End the current session.

---

