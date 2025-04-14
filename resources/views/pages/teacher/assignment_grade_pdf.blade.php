<!DOCTYPE html>
<html>

<head>
    <title>Nilai Tugas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Nilai Tugas: {{ $assignment->title }}</h2>
    <p>Kelas: {{ $assignment->class->name }}</p>
    <p>Mata Pelajaran: {{ $assignment->subject->name }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $i => $student)
                @php
                    $submission = $assignment->submissions->firstWhere('student_id', $student->id);
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $submission->grade ?? '-' }}</td>
                    <td>
                        @if (!is_null($submission?->grade))
                            {{ $submission->grade >= 70 ? 'Lulus' : 'Tidak Lulus' }}
                        @else
                            Belum Dinilai
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
