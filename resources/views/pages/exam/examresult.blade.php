@extends('layouts.app')

@section('title', 'Hasil Ujian')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Hasil {{ $exam->title }}</h1>
            </div>
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm p-4">
                            <div class="card-body text-center">
                                <!-- Indikator Nilai -->
                                <h4 class="{{ $score >= 70 ? 'text-success' : 'text-danger' }}">
                                    Nilai Anda: {{ $score }}
                                </h4>
                                <p>Jawaban Benar: {{ $correctAnswers }} dari {{ $totalQuestions }} soal</p>

                                @if ($score >= 70)
                                    <div class="alert alert-success d-flex align-items-center justify-content-center"
                                        role="alert">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span>Selamat! Anda lulus ujian ini. 🎉</span>
                                    </div>
                                @else
                                    <div class="alert alert-primary d-flex align-items-center justify-content-center"
                                        role="alert">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        <span>Tetap semangat! Coba lagi untuk hasil yang lebih baik. 💪</span>
                                    </div>
                                @endif

                                <!-- Tombol Navigasi -->
                                <a href="{{ route('exams.index') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Ujian
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
