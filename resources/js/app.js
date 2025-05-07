import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import { initCategoryChart, initTrendChart, initComparisonChart, initSavingsProgress } from './charts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts; // Make ApexCharts globally available
Alpine.start();

// Initialize charts if we're on the dashboard
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('category-chart')) {
        initCategoryChart('category-chart');
    }
    if (document.getElementById('trend-chart')) {
        initTrendChart('trend-chart');
    }
    if (document.getElementById('comparison-chart')) {
        initComparisonChart('comparison-chart');
    }
    if (document.getElementById('savings-progress')) {
        initSavingsProgress('savings-progress');
    }
});
