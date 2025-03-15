@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@push('style')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-md-12 mt-2">
                        <p style="color: #375a7f; font-size: larger; font-weight: 500;">
                            Hai, {{ $user->name }}! Selamat belajar dan semangat menyelesaikan tugas. 😁
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">Grafik Pengumpulan Tugas</div>
                        <div class="card-body">
                            <canvas id="submissionProgressChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header">Grafik Rata-rata Nilai</div>
                        <div class="card-body">
                            <canvas id="subjectGradesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Daftar Tugas Terbaru</div>
                <div class="card-body">
                    @if ($assignments->isEmpty())
                        <div class="alert alert-info">Belum ada tugas</div>
                    @else
                        <ul class="list-group">
                            @foreach ($assignments as $assignment)
                                @php
                                    $submission = $submissions->where('assignment_id', $assignment->id)->first();
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Tugas {{ $assignment->subject->name }}</h5>
                                        <small>Tenggat: {{ $assignment->due_date ?? 'Tidak Diketahui' }}</small>
                                        <p>{{ $assignment->description }}</p>
                                        @if ($submission)
                                            @if ($submission->grade !== null)
                                                <span class="badge badge-success px-3 py-2"><i
                                                        class="fas fa-check-circle"></i> Nilai:
                                                    {{ $submission->grade }}</span>
                                            @else
                                                <span class="badge badge-warning px-3 py-2"><i
                                                        class="fas fa-hourglass-half"></i> Menunggu Penilaian</span>
                                            @endif
                                        @else
                                            <a href="{{ route('submissions.create', $assignment->id) }}"
                                                class="btn btn-primary btn-sm">Unggah Tugas</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var subjectNames = @json($subjects->pluck('name'));
            var subjectGrades = @json($subjectGrades);
            var submissionProgress = @json($submissionProgress);

            var ctx1 = document.getElementById('submissionProgressChart').getContext('2d');
            new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Sudah Mengumpulkan', 'Belum Mengumpulkan'],
                    datasets: [{
                        data: [submissionProgress.submitted, submissionProgress.not_submitted],
                        backgroundColor: ['#4CAF50', '#F44336'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Progres Pengumpulan Tugas'
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('subjectGradesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: subjectNames,
                    datasets: [{
                        label: 'Nilai Rata-rata',
                        data: subjectGrades,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
