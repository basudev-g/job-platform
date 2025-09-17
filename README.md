# 📌 Job Platform API – Laravel (Hiring Task)

This is a backend system for a job platform where companies can post jobs and job seekers can apply with a payment. It includes **role-based access control** for Admins, Employees (Recruiters), and Job Seekers.  

---

## 🚀 Tech Stack
- **Language**: PHP  
- **Framework**: Laravel 12  
- **Database**: MySQL  
- **Authentication**: JWT (tymon/jwt-auth)  
- **Payment**: Mock Service (can be replaced with Stripe/SSLCommerz)  

---

## ⚙️ Setup Instructions

1. Clone repository:
   ```bash
   git clone https://github.com/your-username/job-platform.git
   cd job-platform
2. Install dependencies
    ```bash
    composer install
3. Copy .env.example to .env and update:
    ```env
    DB_DATABASE=job_platform
    DB_USERNAME=root
    DB_PASSWORD=
    JWT_SECRET=your_generated_secret
4. Generate key + JWT secret:
    ```bash
    php artisan key:generate
    php artisan jwt:secret
5. Run migrations:
    ```bash
    php artisan migrate
6. Serve app:
    ```bash
    php artisan serve

---

👤 Roles & Permissions
| Role                     | Permissions                                                               |
| ------------------------ | ------------------------------------------------------------------------- |
| **Admin**                | Manage all users, jobs, and applications. View analytics.                 |
| **Employee (Recruiter)** | Post/edit/delete jobs for their company. View & accept/reject applicants. |
| **Job Seeker**           | View jobs, apply (with CV upload + payment), view own applications.       |

---

🔑 Authentication

- Register → /api/register

- Login → /api/login

- JWT Token is returned on login.

- For protected routes, send token in header:
```makefile
    Authorization: Bearer your_token_here

---

📂 API Endpoints
🔹 Public

- POST /api/register → Register user (role required: admin, employee, job_seeker).

- POST /api/login → Login and get JWT token.

🔹 Job Seeker

- GET /api/jobs → List all jobs.

- POST /api/jobs/{id}/apply → Apply with CV upload + payment (100 Taka).

- GET /api/my-applications → View own applications.

🔹 Employee (Recruiter)

- POST /api/jobs → Post new job.

- PUT /api/jobs/{id} → Edit own job.

- DELETE /api/jobs/{id} → Delete own job.

- GET /api/jobs → List jobs (including own).

🔹 Admin

- GET /api/admin/users → View all users.

- GET /api/admin/jobs → View all jobs.

- GET /api/admin/applications → View all applications.

---

📎 File Upload

- Job seekers must upload CV as PDF/DOC/DOCX.

- Max size: 5MB.

- Files stored in storage/app/cvs/.

---

💳 Payment Flow

- Job seekers must pay 100 Taka before applying.

- Currently using a mock payment service:

Always marks payment as “paid” if request is valid.

- After successful payment:

Application is saved with payment_status=paid.

Invoice is created with id, user, amount, time.

---

🧪 Postman Collection

A Postman collection with all endpoints is included in the repo under:

```bash
    /postman/JobPlatform.postman_collection.json

---

📊 Deliverables

✅ Public GitHub Repository

✅ Clean code + migrations

✅ README with setup + endpoints

✅ Postman Documentation

---

👨‍💻 Author

Basudev Goswami
Submission for Fire AI Full Stack Development Hiring Task



