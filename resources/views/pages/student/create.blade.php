@extends('layouts.app')

@section('title', 'Data Peserta Didik')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Peserta Didik</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Data Peserta Didik</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('students.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Kata Sandi</label> <input type="password"
                                                    class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="class_id">Kelas</label>
                                                <select class="form-control" id="class_id" name="class_id" required>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save mr-1"></i>Simpan</button>
                                    <a href="{{ route('students.index') }}" class="btn btn-danger"><i
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
    <!-- Page Specific JS File -->
@endpush
