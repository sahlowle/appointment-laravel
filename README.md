# Appointment Laravel App  - 🏝️



### Installation



```bash
# composer  install command
composer install

# add yor database info in .env file
DB_DATABASE=appointment_db
DB_USERNAME=root
DB_PASSWORD=

# migrate and seed tables
php artisan migrate:fresh --seed

# Run Queue
you can run queue local or in cron job by using command:

php artisan queue:work --stop-when-empty

```

Next, ensure that your application's `APP_URL` and `FRONTEND_URL` environment variables are set to `http://localhost:8000` and `http://localhost:3000`, respectively.

After defining the appropriate environment variables, you may serve the Laravel application using the `serve` Artisan command:

```bash
# Serve the application...
php artisan serve

# Login Credentials...
      Email:  zafer@msaaq.com
      Password:  password

```
