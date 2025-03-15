# Tenant Management System

A Laravel Blade-based Tenant Management System for landlords to manage their sites, rooms, tenants, and invoices. This system also includes role-based access control for landlords and tenants.

## Features
- Role-based access control for landlords and tenants.
- Manage sites, rooms, and tenants.
- Generate and print invoices in PDF format.
- Dashboard for viewing invoices and related data.

---

## Database Schema

```mermaid
erDiagram
    %% Core entities in a triangular arrangement
    USERS ||--o{ SITES : "owns"
    SITES ||--o{ ROOMS : "contains"
    
    %% User relationships - grouped on left side
    USERS ||--o{ LEASE_AGREEMENTS : "signs"
    USERS ||--o{ ACCOMMODATION_APPLICATIONS : "submits"
    
    %% Site relationships - grouped on right side
    SITES ||--o{ ACCOMMODATION_APPLICATIONS : "receives"
    SITES }|--o{ SERVICE_PROVIDER_SITE : "employs"
    
    %% Room relationships - grouped on bottom
    ROOMS ||--o{ LEASE_AGREEMENTS : "covered by"
    ROOMS ||--o{ INVOICES : "billed for"
    
    %% Ticket relationships - separate section
    USERS ||--o{ TICKETS : "creates/responds"
    ROOMS ||--o{ TICKETS : "has issues"
    SITES ||--o{ TICKETS : "location of"
    
    %% Invoice relationships
    USERS ||--o{ INVOICES : "pays"
    SITES ||--o{ INVOICES : "bills for"
    
    %% Provider relationship
    USERS }|--o{ SERVICE_PROVIDER_SITE : "works at"
    
    USERS {
        bigint id PK
        varchar name
        varchar last_name
        varchar email
        varchar password
        varchar id_number
        varchar phone
        timestamp email_verified_at
        varchar remember_token
        timestamp created_at
        timestamp updated_at
    }
    
    SITES {
        bigint id PK
        varchar name
        text description
        bigint landlord_id FK
        varchar address_line1
        varchar address_line2
        varchar city
        varchar postal_code
        timestamp created_at
        timestamp updated_at
    }
    
    ROOMS {
        bigint id PK
        varchar name
        text description
        bigint site_id FK
        decimal cost
        bigint tenant_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    TICKETS {
        bigint id PK
        text details
        bigint provider_id FK
        text response
        bigint tenant_id FK
        varchar status
        bigint room_id FK
        bigint site_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    LEASE_AGREEMENTS {
        bigint id PK
        bigint room_id FK
        bigint tenant_id FK
        date start_date
        date end_date
        boolean is_terminated
        datetime termination_date
        timestamp created_at
        timestamp updated_at
    }
    
    INVOICES {
        bigint id PK
        bigint tenant_id FK
        bigint room_id FK
        bigint site_id FK
        date issue_date
        date due_date
        decimal amount
        decimal paid_amount
        varchar status
        decimal water_charge
        decimal electricity_charge
        decimal other_charges
        text description
        timestamp created_at
        timestamp updated_at
    }
    
    ACCOMMODATION_APPLICATIONS {
        bigint id PK
        bigint tenant_id FK
        bigint site_id FK
        varchar status
        text termination_reason
        text rejection_reason
        datetime termination_date
        datetime rejection_date
        boolean previously_terminated
        boolean previously_rejected
        timestamp created_at
        timestamp updated_at
    }
    
    SERVICE_PROVIDER_SITE {
        bigint service_provider_id FK
        bigint site_id FK
        timestamp created_at
        timestamp updated_at
    }
```

## Prerequisites
Ensure the following tools are installed:
- PHP 8.2 or later
- Composer
- MySQL or any supported database
- Node.js and npm (for frontend assets)
- A web server like Apache or Nginx

---

## Setup Instructions

### Step 1: Clone the Repository
```bash
git clone https://github.com/Tshabalala-Thabo/TenantManagementSystem.git
cd TenantManagementSystem
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Configure Environment Variables
Create a `.env` file by copying the example file:
```bash
cp .env.example .env
```

Open the `.env` file and configure the following:
- **Database Configuration:**
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  ```
- **Mail Configuration (optional):**
  If email notifications are required:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.example.com
  MAIL_PORT=587
  MAIL_USERNAME=your_email
  MAIL_PASSWORD=your_password
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS=noreply@example.com
  MAIL_FROM_NAME="Tenant Management System"
  ```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Run Database Migrations and Seeders
```bash
php artisan migrate --seed
```
This will create the necessary database tables and seed roles (landlord and tenant) into the database.

### Step 6: Link Storage
```bash
php artisan storage:link
```

### Step 7: Compile Frontend Assets
```bash
npm run dev
```

---

## Running the Application
### Development Server
Start the Laravel development server:
```bash
php artisan serve
```

Visit the application at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---


## PDF Invoice Generation
This application uses the `barryvdh/laravel-dompdf` package for PDF generation. Ensure the package is correctly installed:
```bash
composer require barryvdh/laravel-dompdf
```
To generate and view invoices in PDF format, navigate to the Invoices section and click "Print Invoice."

---

