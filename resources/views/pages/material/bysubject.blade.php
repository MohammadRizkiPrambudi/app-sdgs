@extends('layouts.app')

@section('title', 'Data Materi')

@push('style')
    <style>
        .rounded-box {
            border-radius: 15px;
            overflow: hidden;
        }

        .list-group-item {
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .list-group-item i {
            color: #4e73df;
        }

        .alert {
            text-align: center;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header rounded-box">
                <h1>Materi {{ $subjectname }}</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card rounded-box shadow">
                            <div class="card-body">
                                @if ($materials->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Belum ada materi yang tersedia.
                                    </div>
                                @else
                                    <div class="list-group">
                                        @foreach ($materials as $material)
                                            <a href="{{ route('materials.show', $material->id) }}"
                                                class="list-group-item list-group-item-action">
                                                <i class="fas fa-file-alt"></i> {{ $material->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <a href="{{ route('show.subject') }}" class="btn btn-danger mt-3">
                                    <i class="fas fa-arrow-left"></i> Kembali
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
