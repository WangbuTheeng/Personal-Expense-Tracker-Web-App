import Chart from 'chart.js/auto';

// Common chart configuration
const getChartConfig = () => {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    return {
        color: isDarkMode ? '#E5E7EB' : '#374151',
        borderColor: isDarkMode ? '#8B5CF6' : '#6366F1',
        grid: {
            color: isDarkMode ? '#4B5563' : '#E5E7EB'
        },
        theme: {
            primary: isDarkMode ? '#8B5CF6' : '#4F46E5',
            secondary: isDarkMode ? '#EC4899' : '#8B5CF6',
            success: isDarkMode ? '#10B981' : '#059669',
            info: isDarkMode ? '#38BDF8' : '#0EA5E9',
            warning: isDarkMode ? '#FBBF24' : '#F59E0B',
            danger: isDarkMode ? '#F87171' : '#EF4444',
            gray: isDarkMode ? '#9CA3AF' : '#6B7280',
        }
    };
};

// Update all charts when dark mode changes
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        const isDark = localStorage.getItem('darkMode') === 'true';
        Chart.instances.forEach(chart => {
            const config = getChartConfig();
            
            if (chart.config.type === 'line') {
                chart.options.scales.x.grid.color = config.grid.color;
                chart.options.scales.y.grid.color = config.grid.color;
                chart.options.scales.x.ticks.color = config.color;
                chart.options.scales.y.ticks.color = config.color;
            }
            
            chart.data.datasets.forEach(dataset => {
                if (!dataset._originalBorderColor) {
                    dataset._originalBorderColor = dataset.borderColor;
                }
                dataset.borderColor = isDark ? 
                    adjustColorBrightness(dataset._originalBorderColor, 0.2) : 
                    dataset._originalBorderColor;
            });
            
            chart.update();
        });
    });
});

// Helper function to adjust color brightness
function adjustColorBrightness(color, factor) {
    if (color.startsWith('#')) {
        color = color.substring(1);
    }
    let r = parseInt(color.substr(0,2), 16);
    let g = parseInt(color.substr(2,2), 16);
    let b = parseInt(color.substr(4,2), 16);
    
    r = Math.round(r * factor);
    g = Math.round(g * factor);
    b = Math.round(b * factor);
    
    r = Math.min(255, Math.max(0, r));
    g = Math.min(255, Math.max(0, g));
    b = Math.min(255, Math.max(0, b));
    
    return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
}

// Initialize category distribution chart
function initCategoryChart(elementId) {
    fetch('/api/stats/category-distribution')
        .then(response => response.json())
        .then(data => {
            const config = getChartConfig();
            const defaultColors = [
                config.theme.primary, 
                config.theme.secondary, 
                config.theme.success, 
                config.theme.info, 
                config.theme.warning, 
                config.theme.danger
            ];
            
            new Chart(document.getElementById(elementId), {
                type: 'doughnut',
                data: {
                    labels: data.map(category => category.name),
                    datasets: [{
                        data: data.map(category => category.amount),
                        backgroundColor: data.map((category, index) => 
                            category.color || defaultColors[index % defaultColors.length]
                        ),
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: config.color,
                                font: {
                                    weight: 'bold'
                                }
                            },
                            onClick: (e, legendItem, legend) => {
                                const index = legendItem.index;
                                const ci = legend.chart;
                                if (ci.isDatasetVisible(0)) {
                                    ci.hide(0, index);
                                } else {
                                    ci.show(0, index);
                                }
                            }
                        },
                        tooltip: {
                            titleFont: {
                                weight: 'bold',
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: (context) => {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: NRs ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
}

// Initialize expense trends chart
function initTrendChart(elementId) {
    let chart = null;

    function updateChart(period = 'monthly') {
        // Update the title based on the selected period
        const trendTitle = document.getElementById('trend-title');
        if (trendTitle) {
            switch (period) {
                case 'daily':
                    trendTitle.textContent = 'Daily Expense Trends (Last 30 Days)';
                    break;
                case 'weekly':
                    trendTitle.textContent = 'Weekly Expense Trends (Last 12 Weeks)';
                    break;
                case 'monthly':
                default:
                    trendTitle.textContent = 'Monthly Expense Trends (Last Year)';
                    break;
            }
        }

        fetch(`/api/stats/expense-trends/${period}`)
            .then(response => response.json())
            .then(data => {
                if (chart) chart.destroy();
                
                const config = getChartConfig();
                chart = new Chart(document.getElementById(elementId), {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.date),
                        datasets: [{
                            label: 'Total Expenses',
                            data: data.map(item => item.amount),
                            borderColor: config.theme.danger,
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            borderWidth: 2,
                            tension: 0.2,
                            pointBackgroundColor: config.theme.danger,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => `NRs ${value}`,
                                    color: config.color,
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: config.grid.color
                                }
                            },
                            x: {
                                ticks: {
                                    color: config.color,
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: config.grid.color
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: config.color,
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                titleFont: {
                                    weight: 'bold',
                                    size: 14
                                },
                                bodyFont: {
                                    size: 13
                                }
                            }
                        }
                    }
                });
            });
    }

    // Initialize period selector if it exists
    const selector = document.getElementById('trend-period');
    if (selector) {
        selector.addEventListener('change', (e) => updateChart(e.target.value));
    }

    updateChart();
}

// Initialize month comparison chart
function initComparisonChart(elementId) {
    fetch('/api/stats/month-comparison')
        .then(response => response.json())
        .then(data => {
            const categories = [...new Set([
                ...Object.keys(data.current),
                ...Object.keys(data.previous)
            ])];

            const config = getChartConfig();
            new Chart(document.getElementById(elementId), {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: [
                        {
                            label: 'Current Month',
                            data: categories.map(cat => data.current[cat] || 0),
                            backgroundColor: config.theme.primary,
                            borderColor: config.borderColor,
                            borderWidth: 1
                        },
                        {
                            label: 'Previous Month',
                            data: categories.map(cat => data.previous[cat] || 0),
                            backgroundColor: config.theme.info,
                            borderColor: config.borderColor,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => `NRs ${value}`,
                                color: config.color,
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: config.grid.color
                            }
                        },
                        x: {
                            ticks: {
                                color: config.color,
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: config.grid.color
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: config.color,
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            titleFont: {
                                weight: 'bold',
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });
        });
}

// Initialize savings progress
function initSavingsProgress(elementId) {
    fetch('/api/stats/savings-progress')
        .then(response => response.json())
        .then(data => {
            const config = getChartConfig();
            data.forEach((goal, index) => {
                new Chart(document.getElementById(`${elementId}-${index}`), {
                    type: 'bar',
                    data: {
                        labels: [goal.name],
                        datasets: [{
                            data: [goal.percentage],
                            backgroundColor: goal.percentage >= 100 ? config.theme.success : config.theme.primary,
                            barThickness: 20,
                            borderColor: config.borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        scales: {
                            x: {
                                min: 0,
                                max: 100,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    display: false
                                }
                            },
                            y: {
                                display: false
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                titleFont: {
                                    weight: 'bold',
                                    size: 14
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: () => `${goal.current} / ${goal.target} (${goal.percentage.toFixed(1)}%)`
                                }
                            }
                        }
                    }
                });
            });
        });
}

// Export the initialization functions
export { initCategoryChart, initTrendChart, initComparisonChart, initSavingsProgress };