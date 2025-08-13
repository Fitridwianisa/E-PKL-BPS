@extends('layouts.app')

@section('content')
<style>
    .stat-card {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 15px;
        padding: 20px;
        transition: 0.3s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
    }

    .stat-label {
        margin-top: 8px;
        font-size: 1rem;
        color: #777;
    }

    .chart-container {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 15px;
        padding: 20px;
        margin-top: 30px;
    }

    .chart-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .row {
        gap: 20px;
        justify-content: center;
        margin-bottom: 30px;
    }
</style>

<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-3 stat-card">
            <div class="stat-number">{{ number_format($belumDikonfirmasi) }}</div>
            <div class="stat-label">Pendaftar <br><strong>Belum dikonfirmasi</strong></div>
        </div>
        <div class="col-md-3 stat-card">
            <div class="stat-number">{{ $diterima }}</div>
            <div class="stat-label">Pendaftar <br><strong>Pelamar disetujui</strong></div>
        </div>
        <div class="col-md-3 stat-card">
            <div class="stat-number">{{ $ditolak }}</div>
            <div class="stat-label">Pendaftar <br><strong>Pelamar ditolak</strong></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 chart-container">
            <h5 class="chart-title">Grafik Pendaftaran per Bulan</h5>
            <canvas id="barChart" height="150"></canvas>
        </div>
        <div class="col-md-4 chart-container">
            <h5 class="chart-title">Komposisi Status</h5>
            <canvas id="pieChart" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statistik = @json($statistikPerBulan);

    const bulan = statistik.map(s => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][s.bulan - 1]);
    const diterima = statistik.map(s => s.diterima);
    const ditolak = statistik.map(s => s.ditolak);

    new Chart(document.getElementById("barChart"), {
        type: 'bar',
        data: {
            labels: bulan,
            datasets: [
                {
                    label: 'Diterima',
                    data: diterima,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                },
                {
                    label: 'Ditolak',
                    data: ditolak,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById("pieChart"), {
        type: 'doughnut',
        data: {
            labels: ['Belum dikonfirmasi', 'Diterima'],
            datasets: [{
                data: [{{ $belumDikonfirmasi }}, {{ $diterima }}],
                backgroundColor: ['#ff4d4d', '#4dc9ff']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
