# 📌 Job Platform API – Laravel (Hiring Task)

This is a backend system for a job platform where companies can post jobs and job seekers can apply with a payment. It includes **role-based access control** for Admins, Employees (Recruiters), and Job Seekers.  

## 🚀 Tech Stack
- **Language**: PHP  
- **Framework**: Laravel 12  
- **Database**: MySQL  
- **Authentication**: JWT (tymon/jwt-auth)  
- **Payment**: Mock Service (can be replaced with Stripe/SSLCommerz)  

## ⚙️ Setup Instructions

1. Clone repository:
   ```bash
   git clone https://github.com/your-username/job-platform.git
   cd job-platform
   ```
2. Install dependencies
    ```bash
    composer install
    ```
3. Copy .env.example to .env and update:
    ```env
    DB_DATABASE=job_platform
    DB_USERNAME=root
    DB_PASSWORD=
    JWT_SECRET=your_generated_secret
    ```
4. Generate key + JWT secret:
    ```bash
    php artisan key:generate
    php artisan jwt:secret
    ```
5. Run migrations:
    ```bash
    php artisan migrate
    ```
6. Serve app:
    ```bash
    php artisan serve
    ```

***

👤 Roles & Permissions
| Role                     | Permissions                                                               |
| ------------------------ | ------------------------------------------------------------------------- |
| **Admin**                | Manage all users, jobs, and applications. View analytics.                 |
| **Employee (Recruiter)** | Post/edit/delete jobs for their company. View & accept/reject applicants. |
| **Job Seeker**           | View jobs, apply (with CV upload + payment), view own applications.       |

***

🔑 Authentication

- Register → /api/register

- Login → /api/login

- JWT Token is returned on login.

- For protected routes, send token in header:
```makefile
    Authorization: Bearer your_token_here
```

# 📌 API Endpoints

All protected routes require JWT authentication.  
Add header:

Authorization: Bearer your_token_here

## 🔹 Public Routes

| Method | Endpoint        | Description                                                   |
| ------ | --------------- | ------------------------------------------------------------- |
| `POST` | `/api/register` | Register a new user (role: `admin`, `employee`, `job_seeker`) |
| `POST` | `/api/login`    | Login and get JWT token                                       |
| `POST` | `/api/logout`   | Logout current user (requires token)                          |

## 🔹 Common Routes (Any Authenticated User)

| Method | Endpoint | Description            |
| ------ | -------- | ---------------------- |
| `GET`  | `/api/jobs` | List all job listings |

## 🔹 Job Seeker Routes

Require: `role: job_seeker`  

| Method | Endpoint                       | Description                                     |
| ------ | ------------------------------ | ----------------------------------------------- |
| `POST` | `/api/jobs/{jobListingId}/apply` | Apply to a job with CV upload (requires payment) |
| `GET`  | `/api/my-applications`           | View logged-in job seeker’s applications         |

## 🔹 Employee (Recruiter) Routes

Require: `role: employee`  

| Method | Endpoint                                | Description                                  |
| ------ | --------------------------------------- | -------------------------------------------- |
| `POST` | `/api/jobs`                             | Create a new job posting                     |
| `PUT`  | `/api/jobs/{jobListing}`                | Update a job (only if posted by this employee) |
| `DELETE` | `/api/jobs/{jobListing}`              | Delete a job (only if posted by this employee) |
| `GET`  | `/api/jobs/{jobListingId}/applications` | View applications for a specific job          |
| `PUT`  | `/api/applications/{application}/status` | Accept or Reject an application               |

## 🔹 Admin Routes

Require: `role: admin`  

| Method | Endpoint              | Description                                   |
| ------ | --------------------- | --------------------------------------------- |
| `GET`  | `/api/admin/users`    | View all registered users with their companies |
| `GET`  | `/api/admin/jobs`     | View all job listings                          |
| `GET`  | `/api/admin/applications` | View all job applications                     |
| `GET`    | `/api/admin/users`      | View all users          |
| `POST`   | `/api/admin/users`      | Create a new user       |
| `PUT`    | `/api/admin/users/{id}` | Update an existing user |
| `DELETE` | `/api/admin/users/{id}` | Delete a user           |
| `PUT`    | `/api/admin/users/{id}/reset-password` | Reset a user’s password |
| `GET`    | `/api/admin/jobs`      | View all job listings          |
| `POST`   | `/api/admin/jobs`      | Create a job listing           |
| `PUT`    | `/api/admin/jobs/{id}` | Update an existing job listing |
| `DELETE` | `/api/admin/jobs/{id}` | Delete a job listing           |


---

📎 File Upload

- Job seekers must upload CV as PDF/DOC/DOCX.

- Max size: 5MB.

- Files stored in storage/app/cvs/.

💳 Payment Flow

- Job seekers must pay 100 Taka before applying.

- Currently using a mock payment service:

Always marks payment as “paid” if request is valid.

- After successful payment:

- Application is saved with payment_status=paid.

- Invoice is created with id, user, amount, time.

🧪 Postman Collection

A Postman collection with all endpoints is included in the repo under:

```bash
    /postman/JobPlatform.postman_collection.json
```

📎 Postman Documentation

[Postman Documentation Link](https://documenter.getpostman.com/view/14128827/2sB3Hrkx6L)

***

📊 Deliverables

✅ Public GitHub Repository

✅ Clean code + migrations

✅ README with setup + endpoints

✅ Postman Documentation


👨‍💻 Author

Basudev Goswami <br>
Submission for Fire AI Full Stack Development Hiring Task



