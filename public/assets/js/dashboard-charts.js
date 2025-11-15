// Display current date
document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
});

// Recent Orders Data (empty by default - can be populated from API/database)
const recentOrders = [];

// Function to get badge class based on status
function getStatusBadgeClass(status) {
    const statusMap = {
        'Completed': 'bg-success',
        'Pending': 'bg-warning',
        'Processing': 'bg-info',
        'Cancelled': 'bg-danger',
        'Shipped': 'bg-secondary'
    };
    return statusMap[status] || 'bg-secondary';
}

// Function to render recent orders
function renderRecentOrders(orders) {
    const tbody = document.querySelector('#recentOrdersTable tbody');
    
    if (!tbody) return;
    
    // Always clear the tbody first
    tbody.innerHTML = '';
    
    // If there are orders, add them
    if (orders.length > 0) {
        tbody.innerHTML = orders.map(order => `
            <tr>
                <td>${order.id}</td>
                <td>${order.customer}</td>
                <td>₱${order.amount.toLocaleString()}</td>
                <td><span class="badge ${getStatusBadgeClass(order.status)}">${order.status}</span></td>
            </tr>
        `).join('');
    }
    // If empty, DataTables will show the emptyTable message automatically
}

// Top Selling Products Data (empty by default - can be populated from API/database)
const topSellingProducts = [];

// Function to render top selling products
function renderTopProducts(products) {
    const container = document.getElementById('topProductsContainer');
    
    if (!container) return;
    
    if (products.length === 0) {
        container.innerHTML = '<p class="text-center text-muted py-4">No products data available</p>';
        return;
    }
    
    container.innerHTML = products.map((product, index) => {
        const isLast = index === products.length - 1;
        const borderClass = isLast ? '' : 'mb-3 pb-3 border-bottom';
        
        return `
            <div class="d-flex align-items-center ${borderClass}">
                <div class="product-thumb-small bg-light rounded me-3"></div>
                <div class="flex-grow-1">
                    <h6 class="mb-0">${product.name}</h6>
                    <small class="text-muted">${product.sold} sold</small>
                </div>
                <span class="fw-semibold">₱${product.price.toLocaleString()}</span>
            </div>
        `;
    }).join('');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Render orders (empty by default)
    renderRecentOrders(recentOrders);
    
    // Render products (empty by default)
    renderTopProducts(topSellingProducts);
});

// Sales Chart Data (empty by default - can be populated from API/database)
const salesData = {
    daily: {
        labels: ['12 AM', '3 AM', '6 AM', '9 AM', '12 PM', '3 PM', '6 PM', '9 PM'],
        data: []
    },
    weekly: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        data: []
    },
    monthly: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        data: []
    }
};

// Sales Chart
let salesChart;

function createSalesChart(period) {
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (salesChart) {
        salesChart.destroy();
    }
    
    let chartData;
    
    if (period === 'daily') {
        chartData = {
            labels: salesData.daily.labels,
            datasets: [{
                label: 'Sales',
                data: salesData.daily.data,
                borderColor: '#e91e63',
                backgroundColor: 'rgba(233, 30, 99, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };
    } else if (period === 'weekly') {
        chartData = {
            labels: salesData.weekly.labels,
            datasets: [{
                label: 'Sales',
                data: salesData.weekly.data,
                borderColor: '#e91e63',
                backgroundColor: 'rgba(233, 30, 99, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };
    } else if (period === 'monthly') {
        chartData = {
            labels: salesData.monthly.labels,
            datasets: [{
                label: 'Sales',
                data: salesData.monthly.data,
                borderColor: '#e91e63',
                backgroundColor: 'rgba(233, 30, 99, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };
    }
    
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#580023'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#580023',
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

// Initialize with weekly view
createSalesChart('weekly');

// Add event listeners to period buttons
document.addEventListener('DOMContentLoaded', function() {
    const periodButtons = document.querySelectorAll('.sales-period-btn');
    
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            periodButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the period from data attribute
            const period = this.getAttribute('data-period');
            
            // Update chart
            createSalesChart(period);
        });
    });
});

// Category Chart Data (empty by default - can be populated from API/database)
const categoryData = {
    labels: [],
    data: []
};

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: categoryData.labels,
        datasets: [{
            data: categoryData.data,
            backgroundColor: [
                '#e91e63',
                '#4caf50',
                '#ff9800',
                '#2196f3',
                '#9c27b0'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#580023'
                }
            }
        }
    }
});