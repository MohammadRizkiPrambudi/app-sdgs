@extends('layouts.app')

@section('title', 'Data Kelas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
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
                                <h4>Data Kelas</h4>
                            </div>
                            <div class="card-body">
                                <h1>Detail Kelas</h1>
                                <h2>{{ $class->name }}</h2>
                                <p><strong>Guru:</strong> {{ $class->teacher->name }}</p>
                                <p><strong>Mata Pelajaran:</strong></p>
                                <ul>
                                    @foreach ($class->subjects as $subject)
                                        <li>{{ $subject->name }}</li>
                                    @endforeach
                                </ul>
                                <h3>Daftar Siswa</h3>
                                <ul>
                                    @foreach ($class->students as $student)
                                        <li>{{ $student->name }}</li>
                                    @endforeach
                                </ul>
                                <h3>Materi</h3>
                                <ul>
                                    @foreach ($class->materials as $material)
                                        <li>{{ $material->title }}</li>
                                    @endforeach
                                </ul>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
