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
                                <a href="{{ route('classes.create') }}" class="rounded-box btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Kelas</a>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Kelas</th>
                                                <th>Guru</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($classes as $class)
                                                <tr>
                                                    <td>
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>{{ $class->name }}</td>
                                                    <td>{{ $class->teacher->name }}</td>
                                                    <td>{{ $class->subject->name }}</td>
                                                    <td>
                                                        <a href="{{ route('classes.edit', $class->id) }}"
                                                            class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                        <form action="{{ route('classes.destroy', $class->id) }}"
                                                            method="POST" style="display:inline-block;"> @csrf
                                                            @method('DELETE') <button type="submit"
                                                                class="btn btn-danger" data-confirm-delete="true"><i
                                                                    class="fas fa-trash"></i>Hapus</button> </form>
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
