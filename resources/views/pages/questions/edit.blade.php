@extends('layouts.app')

@section('title', 'Soal Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Update Soal Ujian</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('questions.update', $question) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="question_text">Pertanyaan:</label>
                                        <textarea name="question_text" id="question_text" class="form-control summernote" required>{{ $question->question_text }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="option_a">Opsi A:</label>
                                                <input type="text" name="option_a" id="option_a" class="form-control"
                                                    value="{{ $question->option_a }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="option_b">Opsi B:</label>
                                                <input type="text" name="option_b" id="option_b" class="form-control"
                                                    value="{{ $question->option_b }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="option_c">Opsi C:</label>
                                                <input type="text" name="option_c" id="option_c" class="form-control"
                                                    value="{{ $question->option_c }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="option_d">Opsi D:</label>
                                                <input type="text" name="option_d" id="option_d" class="form-control"
                                                    value="{{ $question->option_d }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="correct_option">Jawaban Benar:</label>
                                        <select name="correct_option" id="correct_option" class="form-control" required>
                                            <option value="a"
                                                {{ $question->correct_option === 'a' ? 'selected' : '' }}>A</option>
                                            <option value="b"
                                                {{ $question->correct_option === 'b' ? 'selected' : '' }}>B</option>
                                            <option value="c"
                                                {{ $question->correct_option === 'c' ? 'selected' : '' }}>C</option>
                                            <option value="d"
                                                {{ $question->correct_option === 'd' ? 'selected' : '' }}>D</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan
                                        Perubahan</button>
                                    <a href="{{ route('questions.index') }}" class="btn btn-danger">Batal</a>
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
