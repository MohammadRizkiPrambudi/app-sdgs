@extends('layouts.app')

@section('title', 'Daftar Tugas')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Tugas</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($assignments->isEmpty())
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <h5>Belum ada tugas</h5>
                                <p>Guru belum memberikan tugas untuk saat ini.</p>
                            </div>
                        </div>
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
@endpush
