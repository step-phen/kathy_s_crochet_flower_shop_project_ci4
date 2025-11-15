<?= $this->extend('admin/layouts/page-layout') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4 p-4 rounded shadow d-flex align-items-center" style="background: linear-gradient(90deg, #fe6e8b 0%, #f83b66 100%); color: #fff;">
    <div class="flex-grow-1">
        <h1 class="h2 fw-bold mb-1"><i class="bi bi-graph-up me-2"></i>Sales Reports</h1>
        <p class="mb-0">
            <i class="bi bi-calendar3 me-1"></i>
            View Daily, Weekly, and Monthly Sales Performance
        </p>
    </div>
    <div class="ms-3 d-flex align-items-center gap-2">
        <label for="reportSelector" class="visually-hidden">Select report</label>
        <select id="reportSelector" class="form-select" style="width: 220px;">
            <option value="daily" selected>Daily Report</option>
            <option value="weekly">Weekly Report</option>
            <option value="monthly">Monthly Report</option>
        </select>
        <button type="button" class="btn btn-warning btn-sm" id="printReportBtn" title="Print Report" onclick="window.print()">
            <i class="bi bi-printer me-2"></i>Print Report
        </button>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4" id="summaryCards">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-currency-dollar fs-2 text-success mb-2"></i>
                <h6 class="text-muted mb-1">Total Revenue</h6>
                <h3 class="mb-0" id="totalRevenue">₱0.00</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-cart-check fs-2 text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Total Orders</h6>
                <h3 class="mb-0" id="totalOrders">0</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-flower1 fs-2 text-danger mb-2"></i>
                <h6 class="text-muted mb-1">Items Sold</h6>
                <h3 class="mb-0" id="totalItems">0</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack fs-2 text-warning mb-2"></i>
                <h6 class="text-muted mb-1">Average Order</h6>
                <h3 class="mb-0" id="avgOrder">₱0.00</h3>
            </div>
        </div>
    </div>
</div>

<div class="tab-content" id="reportTabsContent">
    <!-- Daily Report -->
    <div class="tab-pane fade show active" id="daily" role="tabpanel">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar me-2 fs-4"></i>
                <span class="fs-5">Daily Sales Report</span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="dailyDateFilter" class="form-label">Filter by Date:</label>
                        <input type="date" id="dailyDateFilter" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <div style="height:320px;width:100%;">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="dailyTable" class="table table-hover table-striped mb-0 align-middle text-center">
                                <thead class="table-success">
                                    <tr>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Items</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Report -->
    <div class="tab-pane fade" id="weekly" role="tabpanel">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar-week me-2 fs-4"></i>
                <span class="fs-5">Weekly Sales Report</span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="weeklyWeekFilter" class="form-label">Filter by Week:</label>
                        <select id="weeklyWeekFilter" class="form-select">
                            <option value="">Select Week</option>
                            <option value="2025-W46">Nov 10 - Nov 16, 2025</option>
                            <option value="2025-W47" selected>Nov 17 - Nov 23, 2025</option>
                            <option value="2025-W48">Nov 24 - Nov 30, 2025</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <div style="height:320px;width:100%;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="weeklyTable" class="table table-hover table-striped mb-0 align-middle text-center">
                        <thead class="table-warning">
                            <tr>
                                <th class="text-center">Order ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Report -->
    <div class="tab-pane fade" id="monthly" role="tabpanel">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar-month me-2 fs-4"></i>
                <span class="fs-5">Monthly Sales Report</span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="monthlyMonthFilter" class="form-label">Filter by Month:</label>
                        <select id="monthlyMonthFilter" class="form-select">
                            <option value="">Select Month</option>
                            <option value="2025-11" selected>November 2025</option>
                            <option value="2025-10">October 2025</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <div style="height:320px;width:100%;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="monthlyTable" class="table table-hover table-striped mb-0 align-middle text-center">
                        <thead class="table-info">
                            <tr>
                                <th class="text-center">Order ID</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let dailyChartInstance, weeklyChartInstance, monthlyChartInstance;

    // Helper to render table rows - FIXED VERSION
    function renderTableRows(tableId, data) {
        const table = document.getElementById(tableId);
        if (!table) return;
        
        // Destroy existing DataTable instance
        if ($.fn.DataTable.isDataTable('#' + tableId)) {
            $('#' + tableId).DataTable().destroy();
        }
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        // Clear tbody
        tbody.innerHTML = '';
        
        if (!data || !data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No data available</td></tr>';
            return; // Don't initialize DataTables on empty data
        }
        
        // Add rows as HTML first
        data.forEach(function(row) {
            const statusClass = row.status === 'delivered' ? 'success' : 
                               row.status === 'cancelled' ? 'danger' : 
                               row.status === 'pending' ? 'warning' : 'info';
            tbody.innerHTML += `
                <tr>
                    <td class="text-center">#${row.order_id}</td>
                    <td class="text-center">${row.customer_name}</td>
                    <td class="text-center">${row.order_date}</td>
                    <td class="text-center">${row.total_items}</td>
                    <td class="text-center">₱${parseFloat(row.total).toFixed(2)}</td>
                    <td class="text-center"><span class="badge bg-${statusClass}">${row.status}</span></td>
                </tr>`;
        });
        
        // Initialize DataTables AFTER HTML is populated
        $('#' + tableId).DataTable({
            paging: true,
            searching: true,
            info: true,
            ordering: true,
            lengthChange: false,
            pageLength: 10,
            language: { 
                emptyTable: 'No data available',
                zeroRecords: 'No matching records found'
            },
            // This tells DataTables to read from existing HTML
            retrieve: true
        });
    }

    // Update summary cards
    function updateSummary(data) {
        document.getElementById('totalRevenue').textContent = '₱' + parseFloat(data.total_revenue || 0).toFixed(2);
        document.getElementById('totalOrders').textContent = data.total_orders || 0;
        document.getElementById('totalItems').textContent = data.total_items || 0;
        document.getElementById('avgOrder').textContent = '₱' + parseFloat(data.avg_order || 0).toFixed(2);
    }

    // Daily Report
    function updateDailyReport(date) {
        if (!date) return;
        
        $.ajax({
            url: '<?= base_url('admin/getDailySalesReport') ?>',
            method: 'GET',
            data: { date: date },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    renderTableRows('dailyTable', resp.data);
                    updateSummary(resp.summary);
                    if (dailyChartInstance && resp.chart) {
                        dailyChartInstance.data.labels = resp.chart.labels;
                        dailyChartInstance.data.datasets[0].data = resp.chart.data;
                        dailyChartInstance.update();
                    }
                }
            },
            error: function() {
                renderTableRows('dailyTable', []);
            }
        });
    }

    // Weekly Report
    function updateWeeklyReport(week) {
        if (!week) return;
        
        $.ajax({
            url: '<?= base_url('admin/getWeeklySalesReport') ?>',
            method: 'GET',
            data: { week: week },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    renderTableRows('weeklyTable', resp.data);
                    updateSummary(resp.summary);
                    if (weeklyChartInstance && resp.chart) {
                        weeklyChartInstance.data.labels = resp.chart.labels;
                        weeklyChartInstance.data.datasets[0].data = resp.chart.data;
                        weeklyChartInstance.update();
                    }
                }
            },
            error: function() {
                renderTableRows('weeklyTable', []);
            }
        });
    }

    // Monthly Report
    function updateMonthlyReport(month) {
        if (!month) return;
        
        $.ajax({
            url: '<?= base_url('admin/getMonthlySalesReport') ?>',
            method: 'GET',
            data: { month: month },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    renderTableRows('monthlyTable', resp.data);
                    updateSummary(resp.summary);
                    if (monthlyChartInstance && resp.chart) {
                        monthlyChartInstance.data.labels = resp.chart.labels;
                        monthlyChartInstance.data.datasets[0].data = resp.chart.data;
                        monthlyChartInstance.update();
                    }
                }
            },
            error: function() {
                renderTableRows('monthlyTable', []);
            }
        });
    }

    // Initialize Charts
    const chartOptions = {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } },
        responsive: true,
        maintainAspectRatio: false
    };

    dailyChartInstance = new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Sales', data: [], backgroundColor: 'rgba(254, 110, 139, 0.8)', borderColor: 'rgb(254, 110, 139)', borderWidth: 1 }] },
        options: chartOptions
    });

    weeklyChartInstance = new Chart(document.getElementById('weeklyChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Sales', data: [], borderColor: 'rgb(254, 110, 139)', backgroundColor: 'rgba(254, 110, 139, 0.2)', tension: 0.3 }] },
        options: chartOptions
    });

    monthlyChartInstance = new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Sales', data: [], backgroundColor: 'rgba(254, 110, 139, 0.8)', borderColor: 'rgb(254, 110, 139)', borderWidth: 1 }] },
        options: chartOptions
    });

    // Event Listeners
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dailyDateFilter').value = today;
    document.getElementById('dailyDateFilter').addEventListener('change', function() {
        updateDailyReport(this.value);
    });

    document.getElementById('weeklyWeekFilter').addEventListener('change', function() {
        updateWeeklyReport(this.value);
    });
    
    document.getElementById('monthlyMonthFilter').addEventListener('change', function() {
        updateMonthlyReport(this.value);
    });

    // Report Selector
    document.getElementById('reportSelector').addEventListener('change', function() {
        const panes = document.querySelectorAll('.tab-pane');
        panes.forEach(p => p.classList.remove('show', 'active'));
        document.getElementById(this.value).classList.add('show', 'active');
    });

    // Initial Load
    updateDailyReport(today);
    
    const selectedWeek = document.getElementById('weeklyWeekFilter').value;
    if (selectedWeek) updateWeeklyReport(selectedWeek);
    
    const selectedMonth = document.getElementById('monthlyMonthFilter').value;
    if (selectedMonth) updateMonthlyReport(selectedMonth);
});
</script>
<?= $this->endSection() ?>