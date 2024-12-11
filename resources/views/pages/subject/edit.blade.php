@extends('layouts.app')

@section('title', 'Data Mata Pelajaran')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Mata Pelajaran</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Perbarui Data Mata Pelajaran</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('subjects.update', $subject->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $subject->name }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $subject->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save mr-1"></i>Perbarui</button>
                                    <a href="{{ route('subjects.index') }}" class="btn btn-danger"><i
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
