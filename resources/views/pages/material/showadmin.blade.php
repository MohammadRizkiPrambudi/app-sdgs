@extends('layouts.app')

@section('title', 'Data Materi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Materi {{ $material->subject->name }}</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-box shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">{{ $material->title }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="mt-1 mb-4" style="line-height: 1.8;">
                                    {!! $material->content !!}
                                </div>
                                <p id="material-content" class="d-none">{{ strip_tags($material->content) }}</p>
                                <div class="mt-4">
                                    @if ($user->role == 'admin')
                                        <a href="{{ route('classes.show', $material->class->id) }}" class="btn btn-danger">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Kelas
                                        </a>
                                    @else
                                        <a href="{{ route('materials.index') }}" class="btn btn-danger">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
