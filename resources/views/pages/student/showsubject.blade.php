@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')

@push('style')
    <style>
        .subject-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 15px;
            overflow: hidden;
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
        }

        .subject-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #5a8dee, #224abe);
        }

        .subject-card .card-body {
            padding: 20px;
        }

        .subject-card h5,
        .subject-card p {
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .subject-card .btn {
            background-color: white;
            color: #224abe;
            border-radius: 25px;
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        .subject-card .btn:hover {
            background-color: #ffbe00 !important;
            color: black;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Mata Pelajaran</h1>
            </div>
            <div class="row">
                @if ($subjects->isEmpty())
                    <div class="col-12 d-flex justify-content-center">
                        <div class="card shadow-lg text-center" style="width: 50%;">
                            <div class="card-body">
                                <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Tidak Ada Mata Pelajaran</h5>
                                <p class="card-text text-muted">Saat ini belum ada mata pelajaran yang tersedia. Silakan cek
                                    kembali nanti.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @foreach ($subjects as $subject)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card subject-card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title font-weight-bold">{{ $subject->name }}</h5>
                                <p><strong>Guru:</strong> {{ $teacher->name }}</p>
                                <a href="{{ route('materials.subject', $subject->id) }}" class="btn"><i
                                        class="fas fa-eye mr-1"></i> Lihat Materi</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
