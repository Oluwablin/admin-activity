## Activity 

## Project Description

This aplication is about RESTful APIs for an Admin Panel to manage usere activities.

This includes the following:
### Admin View
• Add an activity
• Edit an activity
• Delete an activity
• List all activities

### User Panel
• User Registration
• User Login

## Project Setup

### Cloning the GitHub Repository

Clone the repository to your local machine by running the terminal command below.

```bash
git clone https://github.com/Oluwablin/admin-activity
```

### Setup Database

Create a MySQL database and note down the required connection parameters. (DB Host, Username, Password, Name)

### Install Composer Dependencies

Navigate to the project root directory via terminal and run the following command.

```bash
composer install
```

### Create a copy of your .env file

Run the following command

```bash
cp .env.example .env
```

This should create an exact copy of the .env.example file. Name the newly created file .env and update it with your local environment variables (database connection info and others).

### Generate an app encryption key

```bash
php artisan key:generate
```

### Migrate the database

```bash
php artisan migrate
```

### Run the database seeds

```bash
php artisan db:seed
```

## Postman Collection