// Complaints Chart
const complaintsCtx = document.getElementById('complaintsChart').getContext('2d');
new Chart(complaintsCtx, {
    type: 'bar',
    data: {
        labels: ['Dog Bites', 'High Blood', 'Broken Bones', 'Vomiting'],
        datasets: [{
            label: 'Complaints',
            data: [2, 1, 1, 1],
            backgroundColor: '#17a2b8',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
        },
    }
});

// Medical Records Chart
const medicalCtx = document.getElementById('medicalChart').getContext('2d');
new Chart(medicalCtx, {
    type: 'pie',
    data: {
        labels: ['Leptospirosis', 'None', 'TB', 'UTI'],
        datasets: [{
            data: [11.1, 33.3, 22.2, 33.3],
            backgroundColor: ['#dc3545', '#17a2b8', '#ffc107', '#28a745'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
        },
    }
});
