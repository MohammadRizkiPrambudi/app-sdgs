@extends('layouts.app')

@section('title', 'Data Materi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Materi</h1>
            </div>

            <div class="section-body">
                @foreach ($classSubjects as $cs)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $cs->subject_name }}</h4>
                                <small>Kelas: {{ $cs->class_name }}</small>
                            </div>
                            <a href="{{ route('materials.create', ['class_id' => $cs->class_id, 'subject_id' => $cs->subject_id]) }}"
                                class="btn btn-primary btn-sm">
                                Tambah Materi
                            </a>
                        </div>

                        <div class="card-body">
                            @php
                                $materi = \App\Models\Material::where('class_id', $cs->class_id)
                                    ->where('subject_id', $cs->subject_id)
                                    ->get();
                            @endphp

                            @if ($materi->count())
                                <ul class="list-group">
                                    @foreach ($materi as $m)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $m->title }}
                                            <div>
                                                <a href="{{ route('materials.show', $m->id) }}"
                                                    class="btn btn-info btn-sm">Lihat</a>
                                                <a href="{{ route('materials.edit', $m->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('materials.destroy', $m->id) }}"
                                                    class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada materi untuk mapel ini.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
