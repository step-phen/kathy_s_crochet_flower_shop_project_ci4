<?= $this->extend('staff/layouts/page-layouts') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header mb-4 p-4 rounded shadow d-flex align-items-center" style="background: linear-gradient(90deg, #fe6e8b 0%, #f83b66 100%); color: #fff;">
    <div class="flex-grow-1">
        <h1 class="h2 fw-bold mb-1 page-header-title"><i class="bi bi-bar-chart-line me-2"></i>Reports Overview</h1>
        <p class="mb-0 page-header-date">
            <i class="bi bi-calendar3 me-1"></i>
            View Daily, Weekly, and Monthly Inventory Reports.
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


<div class="tab-content" id="reportTabsContent">
    <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar me-2 fs-4"></i>
                <span class="fs-5">Daily Inventory Report</span>
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
                            <canvas id="dailyChart" style="height:100%!important;width:100%!important;"></canvas>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle text-center">
                                <thead class="table-success">
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Flower</th>
                                        <th class="text-center">Stock Sold</th>
                                        <th class="text-center">Current Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic data should be rendered here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar-week me-2 fs-4"></i>
                <span class="fs-5">Weekly Inventory Report</span>
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
                        <canvas id="weeklyChart" style="height:100%!important;width:100%!important;"></canvas>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle text-center">
                        <thead class="table-warning">
                            <tr>
                                <th class="text-center">Week</th>
                                <th class="text-center">Flower</th>
                                <th class="text-center">Stock Sold</th>
                                <th class="text-center">Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic data should be rendered here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-gradient text-dark fw-bold d-flex align-items-center" style="background: linear-gradient(90deg, #ffc0cb 50%, #ffa2b3 100%);">
                <i class="bi bi-calendar-month me-2 fs-4"></i>
                <span class="fs-5">Monthly Inventory Report</span>
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
                        <canvas id="monthlyChart" style="height:100%!important;width:100%!important;"></canvas>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle text-center">
                        <thead class="table-info">
                            <tr>
                                <th class="text-center">Month</th>
                                <th class="text-center">Flower</th>
                                <th class="text-center">Stock Sold</th>
                                <th class="text-center">Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic data should be rendered here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart instances
    let dailyChartInstance, weeklyChartInstance, monthlyChartInstance;

    // Helper to render table rows
    function renderTableRows(selector, data, type) {
        const tableElement = document.querySelector(selector);
        if (!tableElement) return;
        
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().destroy();
        }
        
        const tbody = tableElement.querySelector('tbody');
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!data || !data.length) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No data available</td></tr>';
        } else {
            data.forEach(function(row) {
                let rowHTML = '<tr>';
                if (type === 'daily') {
                    rowHTML += `<td class="text-center">${row.date}</td>`;
                } else if (type === 'weekly') {
                    rowHTML += `<td class="text-center">${row.week}</td>`;
                } else if (type === 'monthly') {
                    rowHTML += `<td class="text-center">${row.month}</td>`;
                }
                rowHTML += `
                    <td class="text-center">${row.flower}</td>
                    <td class="text-center">${row.stock_sold}</td>
                    <td class="text-center">${row.current_stock}</td>
                </tr>`;
                tbody.innerHTML += rowHTML;
            });
        }
        
        // Reinitialize DataTable
        $(selector).DataTable({
            paging: true,
            searching: true,
            info: true,
            ordering: true,
            lengthChange: false,
            pageLength: 5,
            language: {
                emptyTable: 'No data available'
            }
        });
    }

    // Daily Report AJAX
    function updateDailyReport(date) {
        if (!date) {
            console.error('No date provided');
            return;
        }
        
        console.log('Fetching daily report for date:', date);
        
        $.ajax({
            url: '<?= base_url('staff/getDailyReport') ?>',
            method: 'GET',
            data: { date: date },
            dataType: 'json',
            success: function(resp) {
                console.log('Daily report response:', resp);
                if (resp.success && resp.data) {
                    renderTableRows('#daily table', resp.data, 'daily');
                    if (dailyChartInstance && resp.chart) {
                        dailyChartInstance.data.labels = resp.chart.labels;
                        dailyChartInstance.data.datasets = resp.chart.datasets;
                        dailyChartInstance.update();
                    }
                } else {
                    console.warn('No data in response');
                    renderTableRows('#daily table', [], 'daily');
                }
            },
            error: function(xhr, status, error) {
                console.error('Daily report error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                renderTableRows('#daily table', [], 'daily');
            }
        });
    }

    // Weekly Report AJAX
    function updateWeeklyReport(week) {
        if (!week) {
            console.error('No week provided');
            return;
        }
        
        console.log('Fetching weekly report for week:', week);
        
        $.ajax({
            url: '<?= base_url('staff/getWeeklyReport') ?>',
            method: 'GET',
            data: { week: week },
            dataType: 'json',
            success: function(resp) {
                console.log('Weekly report response:', resp);
                if (resp.success && resp.data) {
                    renderTableRows('#weekly table', resp.data, 'weekly');
                    if (weeklyChartInstance && resp.chart) {
                        weeklyChartInstance.data.labels = resp.chart.labels;
                        weeklyChartInstance.data.datasets = resp.chart.datasets;
                        weeklyChartInstance.update();
                    }
                } else {
                    console.warn('No data in response');
                    renderTableRows('#weekly table', [], 'weekly');
                }
            },
            error: function(xhr, status, error) {
                console.error('Weekly report error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                renderTableRows('#weekly table', [], 'weekly');
            }
        });
    }

    // Monthly Report AJAX
    function updateMonthlyReport(month) {
        if (!month) {
            console.error('No month provided');
            return;
        }
        
        console.log('Fetching monthly report for month:', month);
        
        $.ajax({
            url: '<?= base_url('staff/getMonthlyReport') ?>',
            method: 'GET',
            data: { month: month },
            dataType: 'json',
            success: function(resp) {
                console.log('Monthly report response:', resp);
                if (resp.success && resp.data) {
                    renderTableRows('#monthly table', resp.data, 'monthly');
                    if (monthlyChartInstance && resp.chart) {
                        monthlyChartInstance.data.labels = resp.chart.labels;
                        monthlyChartInstance.data.datasets = resp.chart.datasets;
                        monthlyChartInstance.update();
                    }
                } else {
                    console.warn('No data in response');
                    renderTableRows('#monthly table', [], 'monthly');
                }
            },
            error: function(xhr, status, error) {
                console.error('Monthly report error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                renderTableRows('#monthly table', [], 'monthly');
            }
        });
    }

    // Initialize Daily Chart
    if (document.getElementById('dailyChart')) {
        dailyChartInstance = new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                plugins: { 
                    legend: { display: true }
                },
                scales: { 
                    y: { beginAtZero: true } 
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });
        
        // Set today's date as default
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('dailyDateFilter').value = today;
        
        document.getElementById('dailyDateFilter').addEventListener('change', function() {
            updateDailyReport(this.value);
        });
        
        // Initial load
        updateDailyReport(today);
    }
    
    // Initialize Weekly Chart
    if (document.getElementById('weeklyChart')) {
        weeklyChartInstance = new Chart(document.getElementById('weeklyChart'), {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                plugins: { 
                    legend: { display: true }
                },
                scales: { 
                    y: { beginAtZero: true } 
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });
        
        const weekFilter = document.getElementById('weeklyWeekFilter');
        weekFilter.addEventListener('change', function() {
            updateWeeklyReport(this.value);
        });
        
        // Load current week data on page load
        const selectedWeek = weekFilter.value;
        if (selectedWeek) {
            updateWeeklyReport(selectedWeek);
        }
    }
    
    // Initialize Monthly Chart
    if (document.getElementById('monthlyChart')) {
        monthlyChartInstance = new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                plugins: { 
                    legend: { display: true }
                },
                scales: { 
                    y: { beginAtZero: true } 
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });
        
        const monthFilter = document.getElementById('monthlyMonthFilter');
        monthFilter.addEventListener('change', function() {
            updateMonthlyReport(this.value);
        });
        
        // Load current month data on page load
        const selectedMonth = monthFilter.value;
        if (selectedMonth) {
            updateMonthlyReport(selectedMonth);
        }
    }

    // Hook up report selector dropdown to switch visible pane
    const selector = document.getElementById('reportSelector');
    function switchReportPane(key) {
        const panes = document.querySelectorAll('.tab-pane');
        panes.forEach(p => p.classList.remove('show','active'));
        const target = document.getElementById(key);
        if (target) {
            target.classList.add('show','active');
        }
    }
    
    if (selector) {
        selector.addEventListener('change', function() {
            switchReportPane(this.value);
        });
        // Ensure initial pane matches selector
        switchReportPane(selector.value || 'daily');
    }
});
</script>
<?= $this->endSection() ?>