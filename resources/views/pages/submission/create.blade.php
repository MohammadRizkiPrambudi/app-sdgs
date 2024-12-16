@extends('layouts.app')

@section('title', 'Upload Tugas')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kerjakan Tugas</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kerjakan Tugas</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('submissions.store', $assignment->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="file">File Tugas</label>
                                                <input type="file" class="form-control mb-1" id="file"
                                                    name="file" required>
                                                <small class="text-danger">Upload Dalam Bentuk PDF</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save mr-1"></i>Unggah</button>
                                    <a href="{{ route('show.assignment') }}" class="btn btn-danger"><i
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
