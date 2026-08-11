$(document).ready(function () {

    const palette = ['#2563eb', '#16a34a', '#f59e0b', '#dc2626', '#7c3aed', '#0891b2', '#db2777', '#65a30d'];

    // ===== REVENUE (line chart) =====

    const revenueData = $('#revenueChart').data('chart') || [];

    new Chart($('#revenueChart')[0], {
        type: 'line',
        data: {
            labels: revenueData.map((row) => row.date),
            datasets: [{
                label: 'Revenue (Rs.)',
                data: revenueData.map((row) => row.total),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.3,
                fill: true,
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } },
        },
    });

    // ===== ORDERS BY STATUS (doughnut) =====

    const statusData = $('#statusChart').data('chart') || [];

    new Chart($('#statusChart')[0], {
        type: 'doughnut',
        data: {
            labels: statusData.map((row) => row.label),
            datasets: [{
                data: statusData.map((row) => row.total),
                backgroundColor: palette,
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'right' } },
        },
    });

    // ===== ORDERS BY DRESS TYPE (bar) =====

    const dressTypeData = $('#dressTypeChart').data('chart') || [];

    new Chart($('#dressTypeChart')[0], {
        type: 'bar',
        data: {
            labels: dressTypeData.map((row) => row.label),
            datasets: [{
                label: 'Orders',
                data: dressTypeData.map((row) => row.total),
                backgroundColor: '#2563eb',
                borderRadius: 4,
            }],
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
        },
    });

});
