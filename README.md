# 📦 Inventory Management System (Core PHP)

A web-based Inventory Management System built using **Core PHP** and **MySQL**, designed to help small to mid-sized businesses manage products, stock levels, and users with ease. The system features a modular structure, role-based access, and real-time stock tracking.

---

## 🚀 Features (Implemented)

### 🔐 Authentication & Role-Based Access
- Secure login/logout system
- Two user roles: **Manager** and **Staff**
- Restricted access to modules based on roles

### 📦 Product Management
- Add, edit, and delete products
- Assign categories and brands
- Set quantity, purchase price, and selling price

### 📥 Stock Management
- Manage stock **In** and **Out**
- Real-time stock updates

### 📊 Dashboard
- Summary cards showing:
  - Total Products
  - Total Stock Quantity
- Quick view tables

### 👥 User Management
- View and manage users

### 🏷️ Category & Brand Management
- Create and manage product categories (e.g., Electronics, Furniture)
- Create and manage product brands

## 🛠️ Technologies Used
- **PHP** (Core, Procedural)
- **MySQL** (Relational Database)
- **HTML5, CSS3, Bootstrap** (Frontend)
  

---

## 🧩 Project Structure

inventory-management-system/
│
├── config/ # DB configuration
├── includes/ # Header, footer, and helper functions
├── modules/
│ ├── auth/ # Login/Logout
│ ├── dashboard/ # Admin dashboard
│ ├── products/ # Product CRUD operations
│ ├── stock/ # Stock In/Out
│ ├── users/ # Manage user accounts
│ ├── category/ # Category management
│ └── brand/ # Brand management
├── assets/ # CSS, JS, images
├── index.php # Entry point (dashboard)
└── README.md # Project description

