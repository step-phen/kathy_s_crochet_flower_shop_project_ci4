// Sidebar Collapse
document.addEventListener('DOMContentLoaded', function () {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var now = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var el = document.getElementById('currentDate');
    if (el) {
        el.textContent = now.toLocaleDateString(undefined, options);
    }
});



