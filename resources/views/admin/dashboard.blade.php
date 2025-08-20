@extends('layouts.app')

@section('content')
<style>
    .stat-card {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 15px;
        transition: 0.3s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.15);
    }

    .stat-number {
        font-size: 1.8rem;   /* lebih kecil */
        font-weight: bold;
        color: #333;
    }

    .stat-label {
        margin-top: 6px;
        font-size: 0.9rem;
        color: #777;
        line-height: 1.3;
    }

    .chart-container {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
    }

    .chart-title {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .row {
        gap: 15px;
        justify-content: center;
        margin-bottom: 20px;
    }
</style>

<div class="container my-4">
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
            <div class="col-md-3 stat-card">
        <div class="stat-number">{{ $jumlahSiswa }}</div>
        <div class="stat-label">Total Pendaftar <br><strong>Siswa</strong></div>
        </div>
        <div class="col-md-3 stat-card">
            <div class="stat-number">{{ $jumlahMahasiswa }}</div>
            <div class="stat-label">Total Pendaftar<br><strong>Mahasiswa</strong></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 chart-container">
            <h5 class="chart-title">Grafik Pendaftaran per Bulan</h5>
            <canvas id="barChart" height="100"></canvas> {{-- kecilin --}}
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
