@extends('layouts.app')

@section('title', 'Data Kelas')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kelas</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Perbarui Data Kelas</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('classes.update', $class->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Nama Kelas</label>
                                            <input type="text" class="form-control rounded-box" id="name"
                                                name="name" value="{{ $class->name }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="teacher_id">Guru</label>
                                                <select class="form-control rounded-box" id="teacher_id" name="teacher_id">
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}"
                                                            {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject_id">Mata Pelajaran</label>
                                                <select class="form-control" id="subjects" name="subjects[]" multiple
                                                    required>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ in_array($subject->id, $class->subjects->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-box"><i
                                            class="fas fa-save mr-1"></i>Perbarui</button>
                                    <a href="{{ route('classes.index') }}" class="btn btn-danger rounded-box"><i
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
@endpush
