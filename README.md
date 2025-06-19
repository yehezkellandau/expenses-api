# 💸 Laravel Expenses API

A secure and scalable API built with Laravel to manage personal and household expenses.  
Supports multiple users, household grouping, and advanced filtering — ideal for family budgeting or shared financial tracking.

---

## 🚀 Features

- 🔐 **User Authentication** with Laravel Sanctum
- 🏠 **Multi-user Households**: users can create or join households
- 🧾 **Expense Tracking**: record category, amount, date, and payment type
- 📅 **Filtering**: retrieve expenses by month and year
- 🎯 **Authorization**: users can only access expenses from their household
- 🧠 **Simple API-first design** (no views)

---

## 📂 Project Structure

- `routes/api.php` – All API routes (protected by `auth:sanctum`)
- `app/Http/Controllers/` – Contains logic for authentication & expenses
- `app/Models/Expense.php` – Defines expense model and relationships
- `database/migrations/` – Includes user, household, and expense tables


