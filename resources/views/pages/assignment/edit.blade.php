@extends('layouts.app')

@section('title', 'Edit Tugas')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Tugas</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('assignments.update', $assignment->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="class_id">Kelas</label>
                                                <select class="form-control" id="class_id" name="class_id" required>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ $class->id == $assignment->class_id ? 'selected' : '' }}>
                                                            {{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject_id">Mata Pelajaran</label> <select class="form-control"
                                                    id="subject_id" name="subject_id" required>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ $subject->id == $assignment->subject_id ? 'selected' : '' }}>
                                                            {{ $subject->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">Judul Tugas</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ $assignment->title }}" required>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea class="form-control" id="description" rows="3" style="height: auto;" name="description" required>{{ $assignment->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save mr-1"></i>Perbarui</button>
                                    <a href="{{ route('assignments.index') }}" class="btn btn-danger"><i
                                            class="fas fa-arrow-left"></i>
                                        Batal</a>
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
