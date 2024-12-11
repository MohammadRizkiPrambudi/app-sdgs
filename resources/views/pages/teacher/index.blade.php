@extends('layouts.app')

@section('title', 'Data Guru')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Guru</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Guru</h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Guru</a>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Guru</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($teachers as $teacher)
                                                <tr>
                                                    <td>
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>{{ $teacher->name }}</td>
                                                    <td>{{ $teacher->email }}</td>
                                                    <td>
                                                        <a href="{{ route('teachers.show', $teacher->id) }}"
                                                            class="btn btn-info">Lihat</a> <a
                                                            href="{{ route('teachers.edit', $teacher->id) }}"
                                                            class="btn btn-warning">Edit</a>
                                                        <a href="{{ route('teachers.destroy', $teacher->id) }}"
                                                            class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
