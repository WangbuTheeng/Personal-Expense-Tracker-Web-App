# Personal Expense Tracker - Task List

## 🛠️ Module: Setup & Authentication

- [ ] Install Laravel
- [ ] Setup Laravel Breeze for auth
- [ ] Migrate users table
- [ ] Test login/register flow
- [ ] Create basic layout with sidebar/navbar

## 🧾 Module: Expense Management

- [ ] Create Expense model + migration
- [ ] Build ExpenseController with CRUD
- [ ] Create Blade views for index/create/edit/show
- [ ] Add category dropdown in form
- [ ] Show total expenses on dashboard
- [ ] Validate inputs

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

- [ ] Create SavingsGoal model + migration
- [ ] Build CRUD for savings goals
- [ ] Calculate progress
- [ ] Predict goal completion date
- [ ] Mark goal as completed

## 🔁 Module: Recurring Expenses

- [ ] Add 'recurring' field to Expense model
- [ ] Create command to generate recurring entries
- [ ] Schedule daily task (`expenses:generate`)
- [ ] Allow skipping of individual entries

## 📊 Module: Dashboard & Charts (SPRINT 3)

- [ ] Create dashboard view
- [ ] Install and configure chart library
  - [ ] Add Chart.js via npm (`npm install chart.js`) or CDN
  - [ ] Alternative: Add ApexCharts (`npm install apexcharts`)
  - [ ] Create chart initialization in JavaScript files
- [ ] Implement expense breakdown by category chart
  - [ ] Create pie/donut chart for category distribution
  - [ ] Add tooltips showing category percentages
  - [ ] Enable legend interaction for filtering
- [ ] Implement expense trend chart
  - [ ] Create line chart showing daily/weekly/monthly expenses
  - [ ] Add ability to switch between time periods
  - [ ] Implement data aggregation for different time frames
- [ ] Create current vs. previous month comparison chart
  - [ ] Add bar chart comparing current vs. previous month expenses
  - [ ] Break down by category or overall total
  - [ ] Calculate and show percentage change
- [ ] Build savings progress visualization
  - [ ] Add progress bars for savings goals
  - [ ] Create projections based on current savings rate

## 🌙 Module: Dark Mode (SPRINT 3)

- [ ] Add dark mode toggle component
  - [ ] Create Alpine.js component or use Laravel Livewire
  - [ ] Add toggle button in navbar
  - [ ] Implement smooth transition effects
- [ ] Configure Tailwind dark mode variant
  - [ ] Update tailwind.config.js to use 'class' strategy
  - [ ] Apply dark mode classes to all components
- [ ] Store user preference 
  - [ ] Save dark mode preference in localStorage
  - [ ] Add preference to user settings (optional DB storage)
- [ ] Create dark mode color palette
  - [ ] Define dark theme variables/classes
  - [ ] Ensure sufficient contrast for all UI elements
  - [ ] Test dark mode with all components

## 📁 Module: Export Reports

- [ ] Install `maatwebsite/excel`
- [ ] Create export class for expenses
- [ ] Add export button in dashboard/expenses
- [ ] Optional: Install `barryvdh/laravel-dompdf`
- [ ] Add PDF download option

## 🔔 Module: Notifications / Reminders

- [ ] Create Laravel notification for reminders
- [ ] Send daily reminder email
- [ ] Implement browser push notifications (PWA optional)
- [ ] Add notification bell icon in navbar

## 🧩 Module: User Profile & Settings

- [ ] Create profile/settings page
- [ ] Allow name/email/password change
- [ ] Set default currency
- [ ] Choose date format
- [ ] Manage recurring entries
- [ ] Import/export settings (optional)

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

- [ ] **Configure Chart Library**
  - [ ] Run: `npm install chart.js` (or `npm install apexcharts`)
  - [ ] Create chart configuration file in resources/js
  - [ ] Import in app.js and configure with basic options

- [ ] **Expense Distribution Chart**
  - [ ] Create ExpenseStatisticsController with categoryDistribution method
  - [ ] Implement API endpoint for fetching category distribution data
  - [ ] Build pie/donut chart for category breakdown
  - [ ] Add interactive elements (tooltips, legend filtering)

- [ ] **Expense Trends Chart**
  - [ ] Add methods to ExpenseStatisticsController for time series data
  - [ ] Implement endpoint for daily/weekly/monthly aggregate data
  - [ ] Create line chart with customizable time range
  - [ ] Add interactive date range selector

- [ ] **Comparison Chart**
  - [ ] Add method for period comparison (current vs previous month)
  - [ ] Implement bar chart showing the comparison
  - [ ] Add percentage indicators for changes

- [ ] **Savings Progress Visualization**
  - [ ] Link savings goals to dashboard
  - [ ] Create progress bars with projections
  - [ ] Add visual indicators for target dates

### 2. Dark Mode Implementation

**Priority:** Medium
**Estimated time:** 2-3 days

- [ ] **Configure Tailwind CSS**
  - [ ] Update tailwind.config.js for dark mode class strategy
  - [ ] Define dark mode color palette variables

- [ ] **Create Dark Mode Toggle**
  - [ ] Build Alpine.js component for theme switching
  - [ ] Add toggle button to navigation bar
  - [ ] Implement smooth transition effects

- [ ] **Apply Dark Mode Styling**
  - [ ] Update all components with dark mode variants
  - [ ] Ensure charts have dark mode themes
  - [ ] Test all UI components in both modes

- [ ] **Persist User Preference**
  - [ ] Save theme preference in localStorage
  - [ ] Detect system preference as fallback
  - [ ] Add to user settings (optional)

### 3. Testing & Optimization

**Priority:** Medium
**Estimated time:** 1-2 days

- [ ] **Performance Testing**
  - [ ] Test chart rendering performance
  - [ ] Optimize large dataset handling
  - [ ] Implement lazy loading where appropriate

- [ ] **Cross-Browser Testing**
  - [ ] Verify charts work in all modern browsers
  - [ ] Test dark mode in different browsers
  - [ ] Check responsive behavior

- [ ] **Accessibility Check**
  - [ ] Ensure dark mode meets WCAG contrast guidelines
  - [ ] Add appropriate ARIA attributes to charts
  - [ ] Test with screen readers