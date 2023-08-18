# Laravel Task App API

This is a Task Management System API for [Flutter Task Management App](https://github.com/nekrophantom/flutter-task-app).

## How to Use 

**Step 1:**

Download or clone this repo by using the link below:

```
https://github.com/nekrophantom/laravel-task-app-api.git
```

**Step 2:**

Go to project root and execute the following command in terminal to get the all dependencies: 

```
composer install
```

**Step 3:**

Copy the example env file and make the required configuration changes in the .env file: 

```
cp .env.example .env
```

**Step 4:**

Generate a new application key:

```
php artisan key:generate
```

**Step 5:**

Run the database migrations & seeder (Set the database connection in .env before migrating):

```
php artisan migrate:fresh --seed
```

**Step 6:**

Start the locall development server:

```
php artisan serve
```