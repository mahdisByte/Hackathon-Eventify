## 🔧Project Title

SerVora – A Local Service Booking System with AI Integration

## 🎯 Project Objective

The objective of this project is to develop a **web-based platform** that enables users to easily **find and book trusted local service providers** (e.g., electricians, plumbers, doctors, tutors) based on **location** and **availability**. The system integrates **AI-powered recommendations** to enhance user experience by suggesting the most suitable providers based on user behavior and service context.

---

## 👥 Target Audience

- General public needing home or personal services  
- Freelancers or professionals offering services  
- Local communities and urban households  

---

## 🌟 Core Features

### 🔐 User Registration & Role System
- Sign up as **Customer** or **Service Provider**
- **Admin dashboard** for role-based access and provider approval

### 🔍 Service Browsing and Booking
- Search and filter by **category**, **location**, and **availability**
- Providers can **accept or reject** booking requests

### ✅ Provider Verification
- Providers upload **ID & documents** for manual approval

### 💳 Payment Integration
- **SSLCommerz** integration for secure online payments

### ⭐ Reviews & Ratings
- Customers can **rate and review** services after booking completion  
- Average ratings displayed on service listings  
- Review moderation option for admin to remove inappropriate content  

### 🛠 Admin Panel
- Admin can **manage users, bookings, services, payments**
- Dashboard shows **analytics**: revenue, usage stats, traffic

---

## 🔄 CRUD Operations

- **Create** – Sign up, create bookings, add services  
- **Read** – View user profiles, bookings, services  
- **Update** – Edit profiles, change booking times  
- **Delete** – Cancel appointments or delete accounts  

---

## 📡 API Endpoints

### 🔧 Services

| Method | Endpoint            | Description                       |
|--------|---------------------|-----------------------------------|
| GET    | `/services`         | List all services                 |
| POST   | `/services`         | Add a new service (Admin only)   |
| GET    | `/services/:id`     | View specific service details     |
| PUT    | `/services/:id`     | Update a service                  |
| DELETE | `/services/:id`     | Delete a service                  |

### 👤 Users

| Method | Endpoint            | Description              |
|--------|---------------------|--------------------------|
| POST   | `/users/register`   | User registration        |
| POST   | `/users/login`      | User login               |
| GET    | `/users/:id`        | View user profile        |
| PUT    | `/users/:id`        | Update user profile      |
| DELETE | `/users/:id`        | Delete user account      |

### 📅 Bookings / Appointments

| Method | Endpoint              | Description                       |
|--------|-----------------------|-----------------------------------|
| POST   | `/appointments`       | Create a new booking              |
| GET    | `/appointments`       | List all bookings (admin/user)    |
| GET    | `/appointments/:id`   | View booking details              |
| PUT    | `/appointments/:id`   | Update booking time/details       |
| DELETE | `/appointments/:id`   | Cancel a booking                  |

---

## 🤖 AI Feature – Smart Service Recommendations

**Integrated via Python Flask API + Laravel HTTP Client**

### How It Works:

1. **User sends a request** for a service (e.g., tutor, electrician)
2. Laravel backend forwards data (location, time, history, category) to the Flask-based AI API
3. **AI model** processes:
   - User location
   - Past booking history
   - Provider availability
   - Provider ratings
   - Required subject/specialty
4. The AI returns a **ranked list of best-fit providers**
5. Laravel displays suggestions in the UI (React.js or Blade view)

### Use Case Examples:

- **Biology Tutor:** Recommends top-rated Biology tutors nearby  
- **Child Specialist:** Suggests pediatricians available in user’s area  
- **Frequent Electrician Bookings:** If a user often books electricians on Fridays in Mirpur, the system prioritizes those providers  

> This enhances the platform’s **personalization** and **relevance**, improving user satisfaction.

---

## 🧱 Technology Stack

| Layer        | Tools / Frameworks                            |
|-------------|-----------------------------------------------|
| **Backend** | Laravel 11 (PHP Framework)                    |
| **Frontend**| React.js                  |
| **Database**| MySQL                                         |
| **Auth**    | Laravel Breeze / Jetstream                    |
| **Payments**| SSLCommerz or Stripe                          |
| **AI**      | Python (Flask API) + Laravel HTTP integration |
| **Role Mgmt**| Spatie Laravel-Permission                    |
| **Email/SMS**| Laravel Mail + BulkSMSBD (or similar)        |
| **Location**| Google Maps API (optional)                    |
| **Rendering**| Client-Side Rendering (CSR)                  |

---

## 🎨 UI/UX Design

[🔗 Figma Design](https://www.figma.com/design/wS42dur3gE3PJb6jcNSF9o/Flux---Figma-Build-Tutorial--Starter---Community-?node-id=0-1&t=LNeJsLKocxo8tOv3-0)
