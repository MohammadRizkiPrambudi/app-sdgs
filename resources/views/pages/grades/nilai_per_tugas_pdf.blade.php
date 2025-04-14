<!DOCTYPE html>
<html>

<head>
    <title>Nilai Siswa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        h3 {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <h3>Nilai Siswa</h3>
    <p>
        Tugas: <strong>{{ $assignment->title }}</strong><br>
        Kelas: {{ $assignment->class->name }}<br>
        Mapel: {{ $assignment->subject->name }}<br>
        Tanggal: {{ $assignment->created_at->format('d M Y') }}
    </p>

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
            @foreach ($assignment->submissions as $i => $submission)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $submission->student->name }}</td>
                    <td>{{ $submission->grade ?? '-' }}</td>
                    <td>
                        @if ($submission->grade)
                            {{ $submission->grade >= 75 ? 'Lulus' : 'Remedial' }}
                        @else
                            Belum dinilai
                        @endif
                    </td>
                </tr>
            @endforeach

            @if ($assignment->submissions->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada pengumpulan</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
