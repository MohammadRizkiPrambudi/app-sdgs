@extends('layouts.app')

@section('title', 'Data Kelas')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kelas yang Diajar</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="kelas-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Kelas</th>
                                        <th class="text-center">Jumlah Siswa</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $index => $class)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $class->name }}</td>
                                            <td class="text-center">{{ $class->students->count() }}</td>
                                            <td class="text-center">
                                                <button onclick="showStudents({{ $class->id }})"
                                                    class="btn btn-primary">Lihat Siswa</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="siswaModalLabel">Daftar Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="siswaTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody id="siswaList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#kelas-table').DataTable();
        });

        function showStudents(classId) {
            // Jika sudah pernah diinisialisasi, hapus dulu
            if ($.fn.DataTable.isDataTable('#siswaTable')) {
                $('#siswaTable').DataTable().clear().destroy();
            }

            // Kosongkan tbody sebelum isi ulang
            document.getElementById('siswaList').innerHTML = '';

            fetch(`/teacher/class/${classId}/students/json`)
                .then(response => response.json())
                .then(data => {
                    let output = '';
                    data.forEach((siswa, index) => {
                        output += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${siswa.name}</td>
                        <td>${siswa.email}</td>
                    </tr>
                `;
                    });

                    // Masukkan data baru
                    document.getElementById('siswaList').innerHTML = output;

                    // Inisialisasi DataTables lagi
                    $('#siswaTable').DataTable();

                    // Tampilkan modal
                    $('#siswaModal').modal('show');
                })
                .catch(error => {
                    console.error('Gagal mengambil data siswa:', error);
                });
        }
    </script>
@endpush
