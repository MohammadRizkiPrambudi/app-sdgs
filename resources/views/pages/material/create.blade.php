@extends('layouts.app')

@section('title', 'Tambah Materi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section ">
            <div class="section-header rounded-box">
                <h1>Tambah materi</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-box">
                            <div class="card-body">
                                <form action="{{ route('materials.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="class_id">Kelas</label>
                                                <input type="text" class="form-control" value="{{ $class->name }}"
                                                    readonly>
                                                <input type="hidden" name="class_id" value="{{ $class->id }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject_id">Mata Pelajaran</label>
                                                <input type="text" class="form-control" value="{{ $subject->name }}"
                                                    readonly>
                                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="" for="title">Judul</label>
                                                <input type="text" class="form-control  rounded-box" id="title"
                                                    name="title" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="video_url">Link Video (YouTube)</label>
                                                <input type="text" class="form-control" id="video_url" name="video_url"
                                                    value="{{ old('video_url', $material->video_url ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="content">Konten</label>
                                                <textarea class="form-control summernote  rounded-box" id="content" name="content" rows="5" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-box"><i
                                            class="fas fa-save mr-1"></i>Simpan</button>
                                    <a href="{{ route('materials.index') }}" class="btn btn-danger rounded-box"><i
                                            class="fas fa-arrow-left"></i>
                                        Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <!-- Page Specific JS File -->
@endpush
