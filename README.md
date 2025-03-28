# Edex API

Edex API is a Laravel-based RESTful API for an online learning platform. It allows users with different roles (Admin, Mentor, Student) to manage courses, categories, subcategories, tags, videos, enrollments, badges, roles, and payments. The API is versioned (v1 and v3) and uses Laravel Sanctum for authentication.

## Table of Contents

- [Project Overview](#project-overview)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Environment Configuration (.env)](#environment-configuration-env)
- [Database Setup](#database-setup)
- [Seeder Users](#seeder-users)
- [API Routes](#api-routes)
  - [Unauthenticated Endpoints](#unauthenticated-endpoints)
  - [Admin Endpoints](#admin-endpoints)
  - [Mentor Endpoints](#mentor-endpoints)
  - [Student Endpoints](#student-endpoints)
  - [Authenticated (Any Role) Endpoints](#authenticated-any-role-endpoints)
- [Testing in Postman](#testing-in-postman)
- [License](#license)

## Project Overview

Edex API provides a platform for:
- Admins to manage categories, subcategories, tags, roles, badges, and users.
- Mentors to create, update, and delete courses and videos.
- Students to enroll in courses, update progress, and make payments.

The API is structured with two versions:
- v1: Core functionality (courses, categories, enrollments, etc.).
- v3: Additional features (badges, student progress, payments).

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL or another supported database
- Laravel 10.x
- Postman (for testing API endpoints)

## Installation

1. Clone the Repository:

```bash
git clone https://github.com/rayan4-dot/Rest_api-
cd Rest_api-
```

2. Install Dependencies:

```bash
composer install
```

3. Copy the .env File:

```bash
cp .env.example .env
```

4. Generate Application Key:

```bash
php artisan key:generate
```

5. Set Up the Database:
   - Create a MySQL database named `edex`.
   - Update the `.env` file with your database credentials (see below).

6. Run Migrations and Seeders:

```bash
php artisan migrate --seed
```

7. Start the Development Server:

```bash
php artisan serve
```

The API will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Environment Configuration (.env)

Below is an example `.env` configuration for the Edex API:

```env
APP_NAME=Edex
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edex
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

SANCTUM_STATEFUL_DOMAINS=localhost:8000
```

- `APP_URL`: Set to your local server URL ([http://127.0.0.1:8000](http://127.0.0.1:8000)).
- `DB_DATABASE`: Set to `edex` (or your database name).
- `DB_USERNAME` and `DB_PASSWORD`: Update with your MySQL credentials.
- `SANCTUM_STATEFUL_DOMAINS`: Ensures Sanctum works for local development.

## Database Setup

1. Create the Database:

```sql
CREATE DATABASE edex;
```

2. Run Migrations:

The migrations create tables for users, roles, categories, sub_categories, tags, courses, videos, enrollments, badges, etc.

```bash
php artisan migrate
```

3. Seed the Database:

The seeder creates initial users with roles for testing.

```bash
php artisan db:seed
```

## Seeder Users

The database seeder creates three users with different roles for testing:

| Role   | Email              | Password     | Description                         |
|--------|--------------------|--------------|-------------------------------------|
| Admin  | admin@example.com  | password123  | Can manage categories, tags, etc.   |
| Mentor | mentor@example.com | password123  | Can create and manage courses.      |
| Student| student@example.com| password123  | Can enroll in courses and pay.      |

To log in as any of these users, use the `/api/v1/login` endpoint with the email and password.

## API Routes

The API routes are defined in `routes/api.php` and are versioned (v1 and v3). Below are the POST, PUT, and DELETE endpoints, organized by role in a logical workflow.

### Unauthenticated Endpoints

These endpoints do not require authentication.

| Role | URL                                  | Method | Headers                         | Body (JSON)                                                                                   | Description                  |
|------|--------------------------------------|--------|---------------------------------|------------------------------------------------------------------------------------------------|------------------------------|
| None | http://127.0.0.1:8000/api/v1/register| POST   | Content-Type: application/json  | {"name": "John Doe", "email": "john@example.com", "password": "password123", "password_confirmation": "password123"} | Registers a new user.        |
| None | http://127.0.0.1:8000/api/v1/login   | POST   | Content-Type: application/json  | {"email": "admin@example.com", "password": "password123"}                                      | Logs in a user and returns a token. |

### Admin Endpoints

Admins manage the platform’s structure (categories, subcategories, tags, roles, badges, users).

| Role | URL                                              | Method | Headers                                                | Body (JSON)                                                                                     | Description                  |
|------|--------------------------------------------------|--------|--------------------------------------------------------|-------------------------------------------------------------------------------------------------|------------------------------|
| Admin| http://127.0.0.1:8000/api/v1/roles               | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"name": "mentor"}                                                                              | Creates a new role ("mentor").|
| Admin| http://127.0.0.1:8000/api/v1/categories          | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Programming"}                                                                         | Creates a new category (ID 1).|
| Admin| http://127.0.0.1:8000/api/v1/subcategories       | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Python Basics", "category_id": 1}                                                     | Creates a subcategory (ID 1). |
| Admin| http://127.0.0.1:8000/api/v1/tags                | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Python"}                                                                              | Creates a new tag (ID 1).     |
| Admin| http://127.0.0.1:8000/api/v3/badges              | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Beginner Badge", "description": "Awarded for completing your first course"}           | Creates a badge (ID 1).       |
| Admin| http://127.0.0.1:8000/api/v3/students/1/award-badges | POST   | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Awards badges to student (ID 1).|
| Admin| http://127.0.0.1:8000/api/v1/categories/1        | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Updated Programming"}                                                                 | Updates the category (ID 1).  |
| Admin| http://127.0.0.1:8000/api/v1/subcategories/1     | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Updated Python Basics", "category_id": 1}                                             | Updates the subcategory (ID 1).|
| Admin| http://127.0.0.1:8000/api/v1/tags/1              | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Updated Python"}                                                                      | Updates the tag (ID 1).       |
| Admin| http://127.0.0.1:8000/api/v1/roles/1             | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "updated-mentor"}                                                                      | Updates the role (ID 1).      |
| Admin| http://127.0.0.1:8000/api/v3/badges/1            | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Updated Beginner Badge", "description": "Updated description"}                        | Updates the badge (ID 1).     |
| Admin| http://127.0.0.1:8000/api/v1/categories/1        | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the category (ID 1).  |
| Admin| http://127.0.0.1:8000/api/v1/subcategories/1     | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the subcategory (ID 1).|
| Admin| http://127.0.0.1:8000/api/v1/tags/1              | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the tag (ID 1).       |
| Admin| http://127.0.0.1:8000/api/v1/roles/1             | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the role (ID 1).      |
| Admin| http://127.0.0.1:8000/api/v3/badges/1            | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the badge (ID 1).     |
| Admin| http://127.0.0.1:8000/api/v1/users/1             | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the user (ID 1).      |

### Mentor Endpoints

Mentors create and manage courses and videos.

| Role  | URL                                              | Method | Headers                                                | Body (JSON)                                                                                     | Description                  |
|-------|--------------------------------------------------|--------|--------------------------------------------------------|-------------------------------------------------------------------------------------------------|------------------------------|
| Mentor| http://127.0.0.1:8000/api/v1/courses             | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"title": "Introduction to Python", "description": "Learn Python basics", "status": "open", "category_id": 1, "price": 29.99} | Creates a course (ID 1).     |
| Mentor| http://127.0.0.1:8000/api/v1/courses/1/videos    | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"title": "Python Variables", "url": "https://example.com/video.mp4", "description": "Learn about variables in Python."} | Adds a video (ID 1) to course (ID 1).|
| Mentor| http://127.0.0.1:8000/api/v1/courses/1           | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"title": "Updated Introduction to Python", "description": "Updated Python basics course", "status": "in_progress", "category_id": 1, "subcategory_id": 1, "price": 39.99} | Updates the course (ID 1).   |
| Mentor| http://127.0.0.1:8000/api/v1/courses/1/videos/1  | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"title": "Updated Python Variables", "url": "https://example.com/updated-video.mp4", "description": "Updated video on variables in Python."} | Updates the video (ID 1).    |
| Mentor| http://127.0.0.1:8000/api/v1/courses/1/videos/1  | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the video (ID 1).    |
| Mentor| http://127.0.0.1:8000/api/v1/courses/1           | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Deletes the course (ID 1).   |

### Student Endpoints

Students enroll in courses, update progress, and make payments.

| Role   | URL                                              | Method | Headers                                                | Body (JSON)                                                                                     | Description                  |
|--------|--------------------------------------------------|--------|--------------------------------------------------------|-------------------------------------------------------------------------------------------------|------------------------------|
| Student| http://127.0.0.1:8000/api/v1/courses/1/enroll    | POST   | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Enrolls in the course (ID 1).|
| Student| http://127.0.0.1:8000/api/v1/enrollments/1/progress | POST   | Content-Type: application/json, Authorization: Bearer your-token | {"progress": 50}                                                                                | Updates enrollment progress (ID 1). |
| Student| http://127.0.0.1:8000/api/v1/enrollments/1       | DELETE | Content-Type: application/json, Authorization: Bearer your-token | None                                                                                            | Unenrolls from the course (ID 1).|

### Authenticated (Any Role) Endpoints

These endpoints are available to any authenticated user.

| Role | URL                                  | Method | Headers                         | Body (JSON)                                        | Description                  |
|------|--------------------------------------|--------|---------------------------------|----------------------------------------------------|------------------------------|
| Any  | http://127.0.0.1:8000/api/v1/users/1 | PUT    | Content-Type: application/json, Authorization: Bearer your-token | {"name": "Updated Name", "email": "updated@example.com"} | Updates the user (ID 1).     |
| Any  | http://127.0.0.1:8000/api/v1/logout  | POST   | Content-Type: application/json, Authorization: Bearer your-token | None                                               | Logs out the user.           |

## Testing in Postman

1. Get a Token:
   - Log in as a user to get a Sanctum token:

```json
POST http://127.0.0.1:8000/api/v1/login
Headers: Content-Type: application/json
Body: {
    "email": "admin@example.com",
    "password": "password123"
}
```

   - Copy the token from the response (e.g., "token": "1|your-sanctum-token").

2. Test an Endpoint:
   - Example: Create a category as an Admin:

```json
POST http://127.0.0.1:8000/api/v1/categories
Headers: 
    Content-Type: application/json
    Authorization: Bearer your-token
Body: {
    "name": "Programming"
}
```

3. Role-Specific Testing:
   - Use the appropriate user for each role:
     - Admin: admin@example.com
     - Mentor: mentor@example.com
     - Student: student@example.com

## License

This project is licensed under the MIT License.
