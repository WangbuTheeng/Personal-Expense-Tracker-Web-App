# Personal Expense Tracker - Task List

## 🛠️ Module: Setup & Authentication

- [x] Install Laravel
- [x] Setup Laravel Breeze for auth
- [x] Migrate users table
- [x] Test login/register flow
- [x] Create basic layout with sidebar/navbar

## 🧾 Module: Expense Management

- [x] Create Expense model + migration
- [x] Build ExpenseController with CRUD
- [x] Create Blade views for index/create/edit/show
- [x] Add category dropdown in form
- [x] Show total expenses on dashboard
- [x] Validate inputs

## 🗂️ Module: Categories

- [x] Create Category model + migration
- [x] Allow user to create/edit/delete categories
- [x] Assign icons and colors to categories
- [x] Use categories in expense form
- [x] Filter expenses by category

## 📉 Module: Budget Goals

- [x] Create Budget model + migration
- [x] Add budget creation form
- [x] Calculate percentage used vs budget
- [x] Display progress bar
- [x] Show warning if over budget

## 🏆 Module: Savings Goals

- [x] Create SavingsGoal model + migration
- [x] Build CRUD for savings goals
- [x] Calculate progress
- [x] Predict goal completion date
- [x] Mark goal as completed

## 🔁 Module: Recurring Expenses

- [x] Add 'recurring' field to Expense model
- [x] Create command to generate recurring entries
- [x] Schedule daily task (`expenses:generate`)
- [x] Allow skipping of individual entries

## 📊 Module: Dashboard & Charts (SPRINT 3)

- [x] Create dashboard view
- [x] Install and configure chart library
  - [x] Add Chart.js via npm (`npm install chart.js`) or CDN
  - [x] Alternative: Add ApexCharts (`npm install apexcharts`)
  - [x] Create chart initialization in JavaScript files
- [x] Implement expense breakdown by category chart
  - [x] Create pie/donut chart for category distribution
  - [x] Add tooltips showing category percentages
  - [x] Enable legend interaction for filtering
- [x] Implement expense trend chart
  - [x] Create line chart showing daily/weekly/monthly expenses
  - [x] Add ability to switch between time periods
  - [x] Implement data aggregation for different time frames
- [x] Create current vs. previous month comparison chart
  - [x] Add bar chart comparing current vs. previous month expenses
  - [x] Break down by category or overall total
  - [x] Calculate and show percentage change
- [x] Build savings progress visualization
  - [x] Add progress bars for savings goals
  - [x] Create projections based on current savings rate

## 🌙 Module: Dark Mode (SPRINT 3)

- [x] Add dark mode toggle component
  - [x] Create Alpine.js component or use Laravel Livewire
  - [x] Add toggle button in navbar
  - [x] Implement smooth transition effects
- [x] Configure Tailwind dark mode variant
  - [x] Update tailwind.config.js to use 'class' strategy
  - [x] Apply dark mode classes to all components
- [x] Store user preference 
  - [x] Save dark mode preference in localStorage
  - [x] Add preference to user settings (optional DB storage)
- [x] Create dark mode color palette
  - [x] Define dark theme variables/classes
  - [x] Ensure sufficient contrast for all UI elements
  - [x] Test dark mode with all components

## 📁 Module: Export Reports

- [x] Install `maatwebsite/excel`
- [x] Create export class for expenses
- [x] Add export button in dashboard/expenses
- [x] Optional: Install `barryvdh/laravel-dompdf`
- [x] Add PDF download option

## 🔔 Module: Notifications / Reminders

- [x] Create notification system for budget limits
- [x] Implement reminders for upcoming expenses
- [x] Add notification when savings goal is achieved
- [x] Design notification inbox UI
- [x] Setup scheduled notifications

## 🧩 Module: User Profile & Settings

- [x] Create profile/settings page
- [x] Allow name/email/password change
- [x] Set default currency
- [x] Choose date format
- [x] Manage recurring entries
- [x] Import/export settings (optional)

## 📡 Module: Offline Support

- [ ] Store new expenses in localStorage if offline
- [ ] Detect online status
- [ ] Sync data when back online
- [ ] Show sync status messages
- [ ] Make app installable via PWA

## 🚀 Module: Deployment

- [ ] Prepare .env for production
- [ ] Push code to GitHub
- [ ] Deploy to Render/DigitalOcean
- [ ] Test live version
- [ ] Backup database regularly

## 📋 SPRINT 3: Visualization & UI Enhancements - Implementation Plan

### 1. Dashboard Charts Implementation

**Priority:** High
**Estimated time:** 3-4 days

- [x] **Configure Chart Library**
  - [x] Run: `npm install chart.js` (or `npm install apexcharts`)
  - [x] Create chart configuration file in resources/js
  - [x] Import in app.js and configure with basic options

- [x] **Expense Distribution Chart**
  - [x] Create ExpenseStatisticsController with categoryDistribution method
  - [x] Implement API endpoint for fetching category distribution data
  - [x] Build pie/donut chart for category breakdown
  - [x] Add interactive elements (tooltips, legend filtering)

- [x] **Expense Trends Chart**
  - [x] Add methods to ExpenseStatisticsController for time series data
  - [x] Implement endpoint for daily/weekly/monthly aggregate data
  - [x] Create line chart with customizable time range
  - [x] Add interactive date range selector

- [x] **Comparison Chart**
  - [x] Add method for period comparison (current vs previous month)
  - [x] Implement bar chart showing the comparison
  - [x] Add percentage indicators for changes

- [x] **Savings Progress Visualization**
  - [x] Link savings goals to dashboard
  - [x] Create progress bars with projections
  - [x] Add visual indicators for target dates

### 2. Dark Mode Implementation

**Priority:** Medium
**Estimated time:** 2-3 days

- [x] **Configure Tailwind CSS**
  - [x] Update tailwind.config.js for dark mode class strategy
  - [x] Define dark mode color palette variables

- [x] **Create Dark Mode Toggle**
  - [x] Build Alpine.js component for theme switching
  - [x] Add toggle button to navigation bar
  - [x] Implement smooth transition effects

- [x] **Apply Dark Mode Styling**
  - [x] Update all components with dark mode variants
  - [x] Ensure charts have dark mode themes
  - [x] Test all UI components in both modes

- [x] **Persist User Preference**
  - [x] Save theme preference in localStorage
  - [x] Detect system preference as fallback
  - [x] Add to user settings (optional)

### 3. Testing & Optimization

**Priority:** Medium
**Estimated time:** 1-2 days

- [x] **Performance Testing**
  - [x] Test chart rendering performance
  - [x] Optimize large dataset handling
  - [x] Implement lazy loading where appropriate

- [x] **Cross-Browser Testing**
  - [x] Verify charts work in all modern browsers
  - [x] Test dark mode in different browsers
  - [x] Check responsive behavior

- [x] **Accessibility Check**
  - [x] Ensure dark mode meets WCAG contrast guidelines
  - [x] Add appropriate ARIA attributes to charts
  - [x] Test with screen readers