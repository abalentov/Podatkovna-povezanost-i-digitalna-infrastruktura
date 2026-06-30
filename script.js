document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') document.body.classList.add('dark-theme');
    
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'theme-toggle';
    toggleBtn.innerHTML = document.body.classList.contains('dark-theme') ? '☀️ Svijetla' : '🌙 Tamna';
    document.body.prepend(toggleBtn);
    
    toggleBtn.addEventListener('click', function() {
        document.body.classList.toggle('dark-theme');
        const isDark = document.body.classList.contains('dark-theme');
        this.innerHTML = isDark ? '☀️ Svijetla' : '🌙 Tamna';
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
});

function initGrafikoni(data) {
    const kolokviji = data.po_kolokviju || {};
    const labels = Object.keys(kolokviji);
    const prosjeci = labels.map(k => kolokviji[k].prosjek);
    const najbolji = labels.map(k => kolokviji[k].najbolji);
    const najlosiji = labels.map(k => kolokviji[k].najlosiji);
    
    const ctx1 = document.getElementById('chart-kolokviji');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Prosjek', data: prosjeci, backgroundColor: 'rgba(0,48,135,0.7)', borderColor: '#003087', borderWidth: 2 },
                    { label: 'Najbolji', data: najbolji, backgroundColor: 'rgba(76,175,80,0.7)', borderColor: '#4CAF50', borderWidth: 2 },
                    { label: 'Najlošiji', data: najlosiji, backgroundColor: 'rgba(244,67,54,0.7)', borderColor: '#f44336', borderWidth: 2 }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' }, title: { display: true, text: 'Prosjeci po kolokviju' } },
                scales: { y: { beginAtZero: true, max: 30 } }
            }
        });
    }
    
    const ctx2 = document.getElementById('chart-godine');
    if (ctx2) {
        const godine = data.po_godini || {};
        const godLabels = Object.keys(godine);
        const prolaznost = godLabels.map(g => godine[g].prolaznost);
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: godLabels.map(g => 'Godina ' + g),
                datasets: [{ data: prolaznost, backgroundColor: ['#4CAF50', '#FF9800'], borderColor: '#fff', borderWidth: 2 }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' }, title: { display: true, text: 'Prolaznost po godinama (%)' } }
            }
        });
    }
    
    const ctx3 = document.getElementById('chart-rang');
    if (ctx3) {
        const rangLista = data.rang_lista || [];
        const top5 = rangLista.slice(0, 5);
        const imena = top5.map(s => s.ime);
        const prosjeciRang = top5.map(s => s.prosjek);
        const boje = ['#FFD700', '#C0C0C0', '#CD7F32', '#4FC3F7', '#81C784'];
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: imena,
                datasets: [{ label: 'Prosjek', data: prosjeciRang, backgroundColor: boje.slice(0, prosjeciRang.length), borderColor: '#333', borderWidth: 1 }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false }, title: { display: true, text: '🏆 Top 5 studenata' } },
                scales: { x: { beginAtZero: true, max: 30 } }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetch('rezultati.json')
        .then(response => response.json())
        .then(data => initGrafikoni(data))
        .catch(error => console.log('Greška:', error));
    
    setTimeout(() => {
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => { bar.style.width = width; }, 200);
        });
    }, 300);
});