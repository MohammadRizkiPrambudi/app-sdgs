@extends('layouts.app')

@section('title', 'Data Admin')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Admin</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Admin</h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Admin</a>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Peran</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td class="text-center">{{ $user->name }}</td>
                                                    <td class="text-center">{{ $user->email }}</td>
                                                    <td class="text-center">{{ $user->role }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-warning"><i class="fas fa-edit mr-1"></i>Edit</a>
                                                        <a href="{{ route('users.destroy', $user->id) }}"
                                                            class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                                class="fas fa-trash mr-1"></i>Hapus</a>
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
