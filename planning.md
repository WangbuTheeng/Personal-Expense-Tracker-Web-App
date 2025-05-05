# Personal Expense & Savings Tracker - Project Planning Document

## 🎯 Project Overview

A personal finance web application built with Laravel that allows users to track daily expenses, manage savings, set budget goals, visualize spending trends, and receive motivational prompts — all while supporting offline usage and automatic syncing when online.

---

## 🧱 Core Features

| Feature | Description |
|--------|-------------|
| 💰 Expense Tracking | Add, edit, delete daily expenses with category support |
| 🏦 Savings Goals | Track savings toward specific goals (e.g., Vacation, Emergency Fund) |
| 📊 Monthly Budgets | Set limits per category and get alerts when nearing/exceeding |
| 🔁 Recurring Expenses | Auto-generate predictable expenses (daily/weekly/monthly/yearly) |
| 🎨 Custom Categories | Create custom categories with icons/colors |
| 📈 Spending Trends | Visualize monthly comparisons using charts |
| 📁 Export Reports | Download CSV or PDF reports |
| 🌙 Dark Mode | Toggle between light/dark themes |
| 🔔 Notifications | Daily reminders and monthly summaries |
| 🧾 User Settings | Customize currency, date format, theme preference |

---

## ⚙️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 10+, PHP 8.2+ |
| Auth | Laravel Breeze |
| Database | MySQL / SQLite |
| Frontend | Blade + Tailwind CSS / Bootstrap |
| Charts | Chart.js or ApexCharts |
| Offline Logic | JavaScript + localStorage / IndexedDB |
| PWA Support | Service Worker + manifest.json |
| Deployment | Render.com, DigitalOcean, or Vercel + Laravel Vapor |

---

## 📆 Development Roadmap

### Sprint 1: Setup & Basic CRUD
- Laravel setup
- Authentication
- Expense CRUD
- Category management

### Sprint 2: Advanced Finance Features
- Budget Goals
- Savings Goals
- Recurring Expenses
- Offline support with auto-sync

### Sprint 3: Visualization & UI Enhancements
- Dashboard with charts
- Spending trend analysis
- Dark mode toggle

### Sprint 4: Reporting & Notifications
- Export to CSV/PDF
- Notification system
- Browser push notifications (PWA)

### Sprint 5: Final Polish
- User settings page
- Testing
- Deployment